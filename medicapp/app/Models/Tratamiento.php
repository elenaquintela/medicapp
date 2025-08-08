<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;

    protected $table = 'tratamiento';
    protected $primaryKey = 'id_tratamiento';

    public $timestamps = true;

    protected $fillable = [
        'id_perfil',
        'id_usuario_creador',
        'causa',
        'fecha_inicio',
        'estado',
    ];

    public function getRouteKeyName()
    {
        return 'id_tratamiento';
    }

    protected $casts = [
        'fecha_inicio' => 'datetime',
    ];

    // Relación con Perfil: un tratamiento pertenece a un perfil
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil', 'id_perfil');
    }

    // Relación con Medicamento: un tratamiento puede tener muchas medicaciones
    public function medicaciones()
    {
        return $this->hasMany(TratamientoMedicamento::class, 'id_tratamiento', 'id_tratamiento');
    }

    public function usuarioCreador()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'id_usuario_creador', 'id_usuario');
    }
}
