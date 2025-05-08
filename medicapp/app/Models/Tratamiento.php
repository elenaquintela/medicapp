<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;

    protected $table = 'tratamiento';
    protected $primaryKey = 'id_tratamiento';

    protected $fillable = [
        'id_perfil',
        'causa',
        'fecha_inicio',
        'estado',
    ];

    // Relación con Perfil: un tratamiento pertenece a un perfil
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil', 'id_perfil');
    }

    // Relación con Medicamento: un tratamiento puede tener muchos medicamentos
    public function tratamientosMedicamento()
    {
        return $this->hasMany(TratamientoMedicamento::class, 'id_tratamiento', 'id_tratamiento');
    }
}
