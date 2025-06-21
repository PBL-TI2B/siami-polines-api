<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria'; // Nama tabel sesuai migrasi
    protected $primaryKey = 'kriteria_id'; // Primary key sesuai migrasi
    protected $fillable = ['nama_kriteria']; // Kolom yang dapat diisi, sesuaikan dengan kebutuhan
}
