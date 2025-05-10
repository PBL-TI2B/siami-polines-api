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
    public $timestamps = false;
    public function sasaranStrategis()
    {
        return $this->belongsTo(SasaranStrategis::class, 'sasaran_strategis_id', 'sasaran_strategis_id');
    }

}
