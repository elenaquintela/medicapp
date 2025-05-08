<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'cita';
    protected $primaryKey = 'id_cita';

    protected $fillable = [
        'id_perfil',
        'id_usuario_crea',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'motivo',
        'ubicacion',
        'especialidad',
        'recordatorio',
    ];

    // Relación con Perfil: una cita pertenece a un perfil
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil', 'id_perfil');
    }

    // Relación con Usuario: una cita es creada por un usuario
    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_crea', 'id_usuario');
    }
}
