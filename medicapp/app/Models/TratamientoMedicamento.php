<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Esta más que una tabla de enlace es una tabla de detalle, tiene su propia clave primaria y sus propios campos. Además, tiene una relación consigo misma para poder gestionar los medicamentos sustitutos. Por eso necesitamos este modelo.

class TratamientoMedicamento extends Model
{
    use HasFactory;

    protected $table = 'tratamiento_medicamento';
    protected $primaryKey = 'id_trat_med';

    protected $fillable = [
        'id_tratamiento',
        'id_medicamento',
        'indicacion',
        'presentacion',
        'via',
        'dosis',
        'pauta_intervalo',
        'pauta_unidad',
        'observaciones',
        'estado',
        'sustituido_por',
    ];

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class, 'id_tratamiento', 'id_tratamiento');
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'id_medicamento', 'id_medicamento');
    }

    public function sustituidoPor()
    {
        return $this->belongsTo(self::class, 'sustituido_por', 'id_trat_med');
    }

    public function sustitutoDe()
    {
        return $this->hasMany(self::class, 'sustituido_por', 'id_trat_med');
    }
}
