<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    //use HasFactory;

    protected $table = 'perfil';
    protected $primaryKey = 'id_perfil';

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
}