<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tilik extends Model
{
    use HasFactory;

    protected $table = 'tilik'; // nama tabel di database

    protected $primaryKey = 'tilik_id'; // nama primary key

    public $timestamps = false; // karena tidak ada created_at dan updated_at

    protected $fillable = [
        'pertanyaan',
        'indikator',
        'sumber_data',
        'metode_perhitungan',
        'target'
    ];
}
