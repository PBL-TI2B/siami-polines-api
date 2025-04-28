<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria'; // Nama tabel di database
    protected $primaryKey = 'kriteria_id'; // Primary key
    public $timestamps = false; // Karena tabel ini nggak ada kolom created_at / updated_at
}
