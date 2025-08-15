<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificacion';
    protected $primaryKey = 'id_notif';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario_dest',
        'id_perfil',
        'categoria',
        'titulo',
        'mensaje',
        'ts_programada',
        'leida',
    ];

    protected $casts = [
        'ts_programada' => 'datetime',
        'leida'         => 'boolean',
    ];


    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_dest', 'id_usuario');
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil', 'id_perfil')->withDefault();
    }
}
