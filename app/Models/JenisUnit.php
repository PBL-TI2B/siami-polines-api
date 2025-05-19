<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisUnit extends Model
{
    protected $table = 'jenis_units';
    protected $primaryKey = 'jenis_unit_id';
    protected $fillable = ['nama_jenis_unit'];
    public $timestamps = false; // Sesuaikan dengan kebutuhan
}
