<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recordatorio extends Model
{
    protected $table = 'recordatorio';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_trat_med',
        'fecha_hora',
        'tomado',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'tomado'     => 'boolean',
    ];


    public function tratamientoMedicamento()
    {
        return $this->belongsTo(TratamientoMedicamento::class, 'id_trat_med', 'id_trat_med');
    }
}
