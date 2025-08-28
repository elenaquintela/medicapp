<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property-read \App\Models\Perfil|null $perfilActivo
 */


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

    protected $casts = [
        'google_oauth_tokens' => 'array',
        'notif_last_seen' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function perfiles()
    {
        return $this->belongsToMany(Perfil::class, 'usuario_perfil', 'id_usuario', 'id_perfil')
            ->withPivot('rol_en_perfil', 'fecha_inv', 'estado');
    }

    public function citasCreadas()
    {
        return $this->hasMany(Cita::class, 'id_usuario_crea', 'id_usuario');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_usuario_dest', 'id_usuario');
    }

    public function informes()
    {
        return $this->hasMany(Informe::class, 'id_usuario', 'id_usuario');
    }

    public function getPerfilActivoAttribute()
    {
        $id = session('perfil_activo_id');
        if (!$id) {
            return null;
        }
        return $this->perfiles()->whereKey($id)->first();
    }

    public function setPerfilActivo(int $idPerfil)
    {
        session(['perfil_activo_id' => $idPerfil]);
    }

    public function perfilesCreados()
    {
        return $this->belongsToMany(Perfil::class, 'usuario_perfil', 'id_usuario', 'id_perfil')
            ->withPivot('rol_en_perfil', 'fecha_inv', 'estado')
            ->wherePivot('rol_en_perfil', 'creador');
    }

    public function perfilesInvitado()
    {
        return $this->belongsToMany(Perfil::class, 'usuario_perfil', 'id_usuario', 'id_perfil')
            ->withPivot('rol_en_perfil', 'fecha_inv', 'estado')
            ->wherePivot('rol_en_perfil', 'invitado');
    }

    public function isPremium(): bool
    {
        return $this->rol_global === 'premium';
    }
}
