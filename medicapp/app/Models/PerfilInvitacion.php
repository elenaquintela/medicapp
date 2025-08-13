<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilInvitacion extends Model
{
    protected $table = 'perfil_invitacion';
    protected $primaryKey = 'id_invitacion';
    public $timestamps = true;

    protected $fillable = [
        'id_perfil','id_usuario_invitador','email','token',
        'estado','expires_at','accepted_at','id_usuario_invitado'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function perfil()    { return $this->belongsTo(Perfil::class, 'id_perfil', 'id_perfil'); }
    public function invitador() { return $this->belongsTo(Usuario::class, 'id_usuario_invitador', 'id_usuario'); }
    public function invitado()  { return $this->belongsTo(Usuario::class, 'id_usuario_invitado', 'id_usuario'); }

    public function isExpired(): bool {
        return $this->expires_at && now()->greaterThan($this->expires_at);
    }
}
