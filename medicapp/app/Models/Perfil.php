<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    //use HasFactory;

    protected $table = 'perfil';
    protected $primaryKey = 'id_perfil';

    public $timestamps = true;

    //Cuando usas métodos como Model::create([...]) o Model->update([...]), Laravel solo acepta los campos que tú le autorices explícitamente en $fillable.
    protected $fillable = [
        'nombre_paciente',
        'fecha_nacimiento',
        'sexo'
    ];

    // Relación con Usuario:
    // Un perfil puede pertenecer a muchos usuarios, y un usuario puede tener muchos perfiles.

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_perfil', 'id_perfil', 'id_usuario')
            ->withPivot('rol_en_perfil', 'fecha_inv', 'estado');
        // withPivot permite acceder a los campos de la tabla intermedia que no son id, ya que belongsToMany solo pilla los id de las tablas. Así, en un controlador o vista puedes acceder a estos datos:
        //$perfil = Perfil::find(1);
        //foreach ($perfil->usuarios as $usuario) {
        //echo $usuario->pivot->rol_en_perfil;
        //}
    }

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class, 'id_perfil', 'id_perfil');
    }


    // Relación con Cita: un perfil puede tener muchas citas
    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_perfil', 'id_perfil');
    }

    // Relación con Notificacion: un perfil puede recibir muchas notificaciones
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_perfil', 'id_perfil');
    }

    // Relación con Informe: un perfil puede tener muchos informes
    public function informes()
    {
        return $this->hasMany(Informe::class, 'id_perfil', 'id_perfil');
    }
}
