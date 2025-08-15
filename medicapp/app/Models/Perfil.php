<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfil';
    protected $primaryKey = 'id_perfil';

    public $timestamps = true;

    protected $fillable = [
        'nombre_paciente',
        'fecha_nacimiento',
        'sexo'
    ];


    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_perfil', 'id_perfil', 'id_usuario')
            ->withPivot('rol_en_perfil', 'fecha_inv', 'estado');
    }

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class, 'id_perfil', 'id_perfil');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_perfil', 'id_perfil');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_perfil', 'id_perfil');
    }

    public function informes()
    {
        return $this->hasMany(Informe::class, 'id_perfil', 'id_perfil');
    }
}
