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

    protected $fillable = [
        'unit_kerja_id',
        'aktivitas_id',
    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function aktivitas()
    {
        return $this->belongsTo(Aktivitas::class, 'aktivitas_id');
    }
    
}
