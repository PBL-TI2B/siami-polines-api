<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTemuan extends Model
{
    use HasFactory;

    protected $table = 'laporan_temuan';
    protected $primaryKey = 'laporan_temuan_id';

    protected $fillable = [
        'auditing_id',
        'standar',
        'uraian_temuan',
        'kategori_temuan',
        'saran_perbaikan',
    ];

    protected $casts = [
        'standar' => 'array',
    ];

    public function auditing()
    {
        return $this->belongsTo(Auditing::class, 'auditing_id');
    }

    public function getUserAttribute()
    {
        return optional($this->auditing)->auditee1;
    }

    public function getUserRoleAttribute()
    {
        return $this->auditing && $this->auditing->auditee1
            ? $this->auditing->auditee1->role
            : null;
    }
}
