<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseTilik extends Model
{
    use HasFactory;

    protected $table = 'response_tilik';
    protected $primaryKey = 'response_tilik_id';
    public $timestamps = false;
    protected $fillable = [
        'auditing_id',
        'tilik_id',
        'realisasi',
        'standar_nasional',
        'uraian_isian',
        'akar_penyebab',
        'rencana_perbaikan',
    ];
    public function auditing()
    {
        return $this->belongsTo(Auditing::class, 'auditing_id');
    }

    public function tilik()
    {
        return $this->belongsTo(Tilik::class, 'tilik_id');
    }

}
