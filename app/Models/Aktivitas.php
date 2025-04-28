<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    //
    use HasFactory;

    protected $table = 'aktivitas';

    protected $primaryKey = 'aktivitas_id';

    protected $fillable = [
        'indikator_kinerja_id',
        'nama_aktivitas',
        'satuan',
        'target',
    ];

    public function indikatorKinerja()
    {
        return $this->belongsTo(IndikatorKinerja::class, 'indikator_kinerja_id');
    }

    public function setInstrumens()
    {
        return $this->hasMany(SetInstrumen::class, 'aktivitas_id');
    }

}
