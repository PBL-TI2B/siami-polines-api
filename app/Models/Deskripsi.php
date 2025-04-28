<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deskripsi extends Model
{
    protected $table = 'deskripsi'; // nama tabel
    protected $primaryKey = 'deskripsi_id'; // <-- tambah ini
    public $incrementing = true; // primary key auto increment
    protected $keyType = 'int'; // tipe data primary key
    public $timestamps = false;  // Menonaktifkan pengelolaan timestamp

    protected $fillable = [
        'kriteria_id',
        'isi_deskripsi',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
