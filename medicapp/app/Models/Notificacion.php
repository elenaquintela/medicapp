<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificacion';
    protected $primaryKey = 'id_notif';

    protected $fillable = [
        'id_usuario_dest',
        'id_perfil',
        'categoria',
        'titulo',
        'mensaje',
        'ts_programada',
        'leida',
    ];

    // Relación con Usuario: una notificación pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_dest', 'id_usuario');
    }

    // Relación con Perfil: una notificación pertenece a un perfil
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil', 'id_perfil')->withDefault();
    }
    // withDefault(): para evitar errores si el perfil no existe (id_perfil es null)
}
