<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

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
}
