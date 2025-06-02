<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPtpp extends Model
{
    //
    use HasFactory;

    protected $table = 'laporan_ptpp';

    protected $fillable = [
        'standar',
        'uraian_temuan',
        'kategori_temuan',
        'saran_perbaikan',
        'status',
    ];
}
