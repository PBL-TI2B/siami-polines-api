<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    //
    use HasFactory;

    protected $table = 'responses';
    protected $primaryKey = 'response_id';
    public $timestamps = false;
    protected $fillable = [
        'auditing_id',
        'set_instrumen_unit_kerja_id',
        'ketersediaan_standar_dan_dokumen',
        'spt_pt',
        'sn_dikti',
        'lokal',
        'nasional',
        'internasional',
        'capaian',
        'sesuai',
        'lokasi_bukti_dukung',
        'minor',
        'mayor',
        'ofi',
        'keterangan' 
    ];

    public function auditing()
    {
        return $this->belongsTo(Auditing::class, 'auditing_id');
    }

    public function setInstrumen()
    {
        return $this->belongsTo(SetInstrumen::class, 'set_instrumen_unit_kerja_id');
    }

}
