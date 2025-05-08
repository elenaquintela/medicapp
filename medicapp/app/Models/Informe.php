<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    use HasFactory;

    protected $table = 'informe';
    protected $primaryKey = 'id_informe';

    protected $fillable = [
        'id_usuario',
        'id_perfil',
        'tipo',
        'rango_inicio',
        'rango_fin',
        'ruta_pdf',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil', 'id_perfil');
    }
}
