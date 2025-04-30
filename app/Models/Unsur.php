<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Deskripsi; // <- tambahkan ini untuk relasi

class Unsur extends Model
{
    protected $table = 'unsur';
    protected $primaryKey = 'unsur_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'deskripsi_id',
        'isi_unsur',
    ];

    public function deskripsi()
    {
        return $this->belongsTo(Deskripsi::class, 'deskripsi_id');
    }
}
