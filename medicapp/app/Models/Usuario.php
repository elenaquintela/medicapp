<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'email',
        'contrasena',
        'rol_global',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // Relación con Perfil:
    // Un perfil puede pertenecer a muchos usuarios, y un usuario puede tener muchos perfiles.
    public function perfiles()
    {
        return $this->belongsToMany(Perfil::class, 'usuario_perfil', 'id_usuario', 'id_perfil')
            ->withPivot('rol_en_perfil', 'fecha_inv', 'estado');
    }

    // Relación con Cita: un usuario puede crear muchas citas
    public function citasCreadas()
    {
        return $this->hasMany(Cita::class, 'id_usuario_crea', 'id_usuario');
    }

    // Relación con Notificacion: un usuario puede recibir muchas notificaciones
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_usuario_dest', 'id_usuario');
    }

    // Relación con Informe: un usuario puede crear muchos informes
    public function informes()
    {
        return $this->hasMany(Informe::class, 'id_usuario', 'id_usuario');
    }
}
