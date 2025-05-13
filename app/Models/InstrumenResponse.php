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

    // public function response()
    // {
    //     return $this->belongsTo(Response::class, 'response_id');
    // }
    
}