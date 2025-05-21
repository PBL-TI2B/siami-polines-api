<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SetInstrumen extends Model
{
    //
    use HasFactory;

    protected $table = 'set_instrumen';

    protected $primaryKey = 'set_instrumen_unit_kerja_id';
    public $incrementing = true; // jika auto-increment
    protected $keyType = 'int';  // jika tipe intege
    public $timestamps = false;

    protected $fillable = [
        'jenis_unit_id',
        'aktivitas_id',
        'unsur_id',
    ];

    public function jenisunit()
    {
        return $this->belongsTo(JenisUnit::class, 'jenis_unit_id');
    }

    public function aktivitas()
    {
        return $this->belongsTo(Aktivitas::class, 'aktivitas_id');
    }

     public function getIndikatorAttribute()
    {
        return $this->aktivitas ? $this->aktivitas->indikator_kinerja : null;
    }

    public function getSasaranAttribute()
    {
        return $this->aktivitas && $this->aktivitas->indikator_kinerja
            ? $this->aktivitas->indikator_kinerja->sasaran_strategis
            : null;
    }
    public function unsur()
    {
        return $this->belongsTo(Unsur::class, 'unsur_id');
    }
    public function getDeskripsiAttribute()
    {
        return $this->unsur ? $this->unsur->deskripsi : null;
    }

    public function getKriteriaAttribute()
    {
        return $this->unsur && $this->unsur->deskripsi
            ? $this->unsur->deskripsi->kriteria
            : null;
    }
}
