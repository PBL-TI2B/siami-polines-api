<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SasaranStrategis extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'sasaran_strategis';

    protected $primaryKey = 'sasaran_strategis_id';

    protected $fillable = [
        'nama_sasaran',
    ];

    public function indikatorKinerjas()
    {
        return $this->hasMany(IndikatorKinerja::class, 'sasaran_strategis_id');
    }
}

