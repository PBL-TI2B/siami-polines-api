<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class SidebarMenuController extends Controller
{
    /**
     * Mengambil menu sidebar berdasarkan role_id dari query parameter
     */
    public function getSidebarMenus(Request $request)
    {
        try {
            // Ambil role_id dari query parameter atau body
            $roleId = $request->query('role_id') ?? $request->input('role_id');

            if (!$roleId) {
                Log::warning('Gagal mengambil menu sidebar: Role ID tidak disediakan', [
                    'path' => $request->path(),
                    'query' => $request->query(),
                    'body' => $request->input(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role ID harus disediakan sebagai query parameter atau dalam body request.'
                ], 400);
            }

            // Ambil role untuk validasi dan prefix
            $role = Role::where('role_id', $roleId)->first();
            if (!$role) {
                Log::warning('Gagal mengambil menu sidebar: Role ID tidak valid', [
                    'role_id' => $roleId,
                    'query' => $request->query(),
                    'body' => $request->input(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role ID tidak valid.'
                ], 400);
            }

            // Periksa keberadaan tabel
            $requiredTables = ['menus', 'sub_menus', 'role_menu_access', 'role_sub_menu_access'];
            foreach ($requiredTables as $table) {
                if (!Schema::hasTable($table)) {
                    Log::error('Gagal mengambil menu sidebar: Tabel tidak ditemukan', [
                        'table' => $table,
                        'role_id' => $roleId,
                    ]);
                    return response()->json([
                        'status' => 'error',
                        'message' => "Tabel {$table} tidak ditemukan di database."
                    ], 500);
                }
            }

            // Periksa data role_menu_access
            $menuAccessCount = \App\Models\RoleMenuAccess::where('role_id', $roleId)->count();
            if ($menuAccessCount === 0) {
                Log::info('Tidak ada akses menu untuk role_id', [
                    'role_id' => $roleId,
                    'role_name' => $role->nama_role,
                ]);
            }

            // Ambil menu tanpa cache
            $menuItems = $this->fetchMenuItems($roleId, $role->prefix);

            Log::info('Berhasil mengambil menu sidebar', [
                'role_id' => $roleId,
                'role_name' => $role->nama_role,
                'prefix' => $role->prefix,
                'menu_count' => count($menuItems),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => "Berhasil mengambil sidebar untuk role {$role->nama_role}",
                'data' => $menuItems
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil menu sidebar: Kesalahan tak terduga', [
                'role_id' => $roleId ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil menu sidebar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fungsi untuk mengambil menu items dengan prefix route
     */
    private function fetchMenuItems($roleId, $prefix)
    {
        try {
            $menus = Menu::with(['subMenus' => function ($query) use ($roleId) {
                $query->whereHas('roleSubMenuAccesses', function ($q) use ($roleId) {
                    $q->where('role_id', $roleId);
                })->select('sub_menus.sub_menu_id', 'sub_menus.menu_id', 'sub_menus.nama_sub_menu', 'sub_menus.route', 'sub_menus.route_params', 'sub_menus.icon');
            }])
                ->whereHas('roleMenuAccesses', function ($query) use ($roleId) {
                    $query->where('role_id', $roleId);
                })
                ->select('menus.menu_id', 'menus.nama_menu', 'menus.route', 'menus.icon')
                ->get();

            if ($menus->isEmpty()) {
                Log::info('Tidak ada menu ditemukan untuk role_id', ['role_id' => $roleId]);
                return [];
            }

            return $menus->map(function ($menu) use ($prefix) {
                $item = [
                    'label' => $menu->nama_menu,
                    'route' => $prefix . '.' . ($menu->route ?? 'dashboard.index'),
                    'icon' => $menu->icon ?? 'heroicon-o-list-bullet',
                    'dropdown' => $menu->subMenus->isNotEmpty(),
                    'subItems' => [],
                ];

                if ($menu->subMenus->isNotEmpty()) {
                    $item['subItems'] = $menu->subMenus->map(function ($subMenu) use ($prefix) {
                        $routeParams = [];
                        if ($subMenu->route_params) {
                            try {
                                $decodedParams = json_decode($subMenu->route_params, true);
                                $routeParams = is_array($decodedParams) ? $decodedParams : [];
                                if (!is_array($decodedParams)) {
                                    Log::warning('route_params bukan array', [
                                        'sub_menu_id' => $subMenu->sub_menu_id,
                                        'route_params' => $subMenu->route_params,
                                    ]);
                                }
                            } catch (\Exception $e) {
                                Log::warning('route_params tidak valid di sub_menu', [
                                    'sub_menu_id' => $subMenu->sub_menu_id,
                                    'route_params' => $subMenu->route_params,
                                    'error' => $e->getMessage(),
                                ]);
                            }
                        }

                        return [
                            'label' => $subMenu->nama_sub_menu,
                            'route' => $prefix . '.' . ($subMenu->route ?? 'dashboard.index'),
                            'routeParams' => $routeParams,
                            'icon' => $subMenu->icon ?? 'heroicon-o-list-bullet',
                        ];
                    })->toArray();
                }

                return $item;
            })->toArray();
        } catch (\Exception $e) {
            Log::error('Gagal mengambil menu items', [
                'role_id' => $roleId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [];
        }
    }

    public function createMenu(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required|exists:roles,role_id',
                'nama_menu' => 'required|string|max:255',
                'route' => 'nullable|string|max:255',
                'icon' => 'nullable|string|max:255',
                'sub_menus' => 'nullable|array',
                'sub_menus.*.nama_sub_menu' => 'required_with:sub_menus|string|max:255',
                'sub_menus.*.route' => 'nullable|string|max:255',
                'sub_menus.*.route_params' => 'nullable|json',
                'sub_menus.*.icon' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::warning('Gagal membuat menu: Validasi gagal', [
                    'errors' => $validator->errors(),
                    'input' => $request->all(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $role = Role::where('role_id', $request->role_id)->first();
            if (!$role) {
                Log::warning('Gagal membuat menu: Role ID tidak valid', [
                    'role_id' => $request->role_id,
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role ID tidak valid.',
                ], 400);
            }

            // Check if required tables exist
            $requiredTables = ['menus', 'sub_menus', 'role_menu_access', 'role_sub_menu_access'];
            foreach ($requiredTables as $table) {
                if (!Schema::hasTable($table)) {
                    Log::error('Gagal membuat menu: Tabel tidak ditemukan', [
                        'table' => $table,
                        'role_id' => $request->role_id,
                    ]);
                    return response()->json([
                        'status' => 'error',
                        'message' => "Tabel {$table} tidak ditemukan di database.",
                    ], 500);
                }
            }

            $menu = Menu::create([
                'nama_menu' => $request->nama_menu,
                'route' => $request->route,
                'icon' => $request->icon,
            ]);

            // Create role menu access
            \App\Models\RoleMenuAccess::create([
                'role_id' => $request->role_id,
                'menu_id' => $menu->menu_id,
            ]);

            // Handle sub-menus if provided
            if ($request->has('sub_menus')) {
                foreach ($request->sub_menus as $subMenuData) {
                    $subMenu = \App\Models\SubMenu::create([
                        'menu_id' => $menu->menu_id,
                        'nama_sub_menu' => $subMenuData['nama_sub_menu'],
                        'route' => $subMenuData['route'] ?? null,
                        'route_params' => $subMenuData['route_params'] ?? null,
                        'icon' => $subMenuData['icon'] ?? null,
                    ]);

                    \App\Models\RoleSubMenuAccess::create([
                        'role_id' => $request->role_id,
                        'sub_menu_id' => $subMenu->sub_menu_id,
                    ]);
                }
            }

            Log::info('Berhasil membuat menu', [
                'role_id' => $request->role_id,
                'menu_id' => $menu->menu_id,
                'role_name' => $role->nama_role,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil dibuat',
                'data' => $menu,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Gagal membuat menu: Kesalahan tak terduga', [
                'role_id' => $request->role_id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat menu: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing menu item
     */
    public function updateMenu(Request $request, $menuId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required|exists:roles,role_id',
                'nama_menu' => 'required|string|max:255',
                'route' => 'nullable|string|max:255',
                'icon' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::warning('Gagal memperbarui menu: Validasi gagal', [
                    'menu_id' => $menuId,
                    'errors' => $validator->errors(),
                    'input' => $request->all(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $menu = Menu::find($menuId);
            if (!$menu) {
                Log::warning('Gagal memperbarui menu: Menu tidak ditemukan', [
                    'menu_id' => $menuId,
                    'role_id' => $request->role_id,
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu tidak ditemukan.',
                ], 404);
            }

            $role = Role::where('role_id', $request->role_id)->first();
            if (!$role) {
                Log::warning('Gagal memperbarui menu: Role ID tidak valid', [
                    'role_id' => $request->role_id,
                    'menu_id' => $menuId,
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role ID tidak valid.',
                ], 400);
            }

            $menu->update([
                'nama_menu' => $request->nama_menu,
                'route' => $request->route,
                'icon' => $request->icon,
            ]);

            Log::info('Berhasil memperbarui menu', [
                'menu_id' => $menuId,
                'role_id' => $request->role_id,
                'role_name' => $role->nama_role,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil diperbarui',
                'data' => $menu,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Gagal memperbarui menu: Kesalahan tak terduga', [
                'menu_id' => $menuId,
                'role_id' => $request->role_id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui menu: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a menu item
     */
    public function deleteMenu(Request $request, $menuId)
    {
        try {
            $roleId = $request->query('role_id') ?? $request->input('role_id');

            if (!$roleId) {
                Log::warning('Gagal menghapus menu: Role ID tidak disediakan', [
                    'menu_id' => $menuId,
                    'query' => $request->query(),
                    'body' => $request->input(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role ID harus disediakan sebagai query parameter atau dalam body request.',
                ], 400);
            }

            $menu = Menu::find($menuId);
            if (!$menu) {
                Log::warning('Gagal menghapus menu: Menu tidak ditemukan', [
                    'menu_id' => $menuId,
                    'role_id' => $roleId,
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu tidak ditemukan.',
                ], 404);
            }

            $role = Role::where('role_id', $roleId)->first();
            if (!$role) {
                Log::warning('Gagal menghapus menu: Role ID tidak valid', [
                    'role_id' => $roleId,
                    'menu_id' => $menuId,
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role ID tidak valid.',
                ], 400);
            }

            // Delete related role menu access
            \App\Models\RoleMenuAccess::where('menu_id', $menuId)
                ->where('role_id', $roleId)
                ->delete();

            // Delete related sub-menus and their role access
            $subMenus = \App\Models\SubMenu::where('menu_id', $menuId)->get();
            foreach ($subMenus as $subMenu) {
                \App\Models\RoleSubMenuAccess::where('sub_menu_id', $subMenu->sub_menu_id)
                    ->where('role_id', $roleId)
                    ->delete();
                $subMenu->delete();
            }

            $menu->delete();

            Log::info('Berhasil menghapus menu', [
                'menu_id' => $menuId,
                'role_id' => $roleId,
                'role_name' => $role->nama_role,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil dihapus',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Gagal menghapus menu: Kesalahan tak terduga', [
                'menu_id' => $menuId,
                'role_id' => $roleId ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus menu: ' . $e->getMessage(),
            ], 500);
        }
    }
}

