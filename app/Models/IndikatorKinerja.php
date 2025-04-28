<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndikatorKinerja extends Model
{
    //
    use HasFactory;

    protected $table = 'indikator_kinerja';

    protected $primaryKey = 'indikator_kinerja_id';

    protected $fillable = [
        'sasaran_strategis_id',
        'isi_indikator_kinerja',
    ];

    public function sasaranStrategis()
    {
        return $this->belongsTo(SasaranStrategis::class, 'sasaran_strategis_id');
    }

    public function aktivitas()
    {
        return $this->hasMany(Aktivitas::class, 'indikator_kinerja_id');
    }
}
