<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstrumenResponse extends Model
{
    //
    use HasFactory;

    protected $table = 'instrumen_response';
    protected $primaryKey = 'instrumen_response_id';
    public $incrementing = true; // jika auto-increment
    protected $keyType = 'int';  // jika tipe intege
    public $timestamps = false;

    protected $fillable = [
        'auditing_id',
        'set_instrumen_unit_kerja_id',
        'response_id',
        'status_instrumen',
    ];

    public function auditing()
    {
        return $this->belongsTo(Auditing::class, 'auditing_id');
    }

    public function setInstrumenUnitKerja()
    {
        return $this->belongsTo(SetInstrumen::class, 'set_instrumen_unit_kerja_id');
    }
    public function response()
    {
        return $this->belongsTo(Response::class, 'response_id');
    }
    public function getUserAttribute()
    {
        return $this->auditing ? $this->auditing->auditee1 : null;
    }
    public function getUserRoleAttribute()
    {
        return $this->auditing && $this->auditing->auditee1
            ? $this->auditing->auditee1->role
            : null;
    }
    public function getUserUnitKerjaAttribute()
    {
        return $this->auditing && $this->auditing->auditee1
            ? $this->auditing->auditee1->unitKerja
            : null;
    }
    public function getJenisUnitAttribute()
    {
        return $this->setInstrumenUnitKerja ? $this->setInstrumenUnitKerja->jenisunit : null;
    }
    public function getUnsurAttribute()
    {
        return $this->setInstrumenUnitKerja ? $this->setInstrumenUnitKerja->unsur : null;
    }
    public function getDeskripsiAttribute()
    {
        return $this->setInstrumenUnitKerja && $this->setInstrumenUnitKerja->unsur
            ? $this->setInstrumenUnitKerja->unsur->deskripsi
            : null;
    }
    public function getKriteriaAttribute()
    {
        return optional($this->setInstrumenUnitKerja?->unsur?->deskripsi)->kriteria;
    }
}