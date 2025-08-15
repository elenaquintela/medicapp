<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    protected $table = 'informe';
    protected $primaryKey = 'id_informe';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_perfil',
        'id_tratamiento',
        'rango_inicio',
        'rango_fin',
        'ruta_pdf',
    ];

    protected $casts = [
        'rango_inicio' => 'date',
        'rango_fin'    => 'date',
        'ts_creacion'  => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil', 'id_perfil');
    }

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class, 'id_tratamiento', 'id_tratamiento');
    }

    public function getUrlAttribute(): ?string
    {
        if (!$this->ruta_pdf) {
            return null;
        }

        $relative = ltrim($this->ruta_pdf, '/');

        return asset('storage/' . $relative);
    }
}
