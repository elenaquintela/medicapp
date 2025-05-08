<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $table = 'medicamento';
    protected $primaryKey = 'id_medicamento';

    protected $fillable = [
        'nombre',
        'descripcion',
        'id_cima',
    ];

    // Relación con Tratamiento: un medicamento puede estar en muchos tratamientos
    public function tratamientosMedicamento()
    {
        return $this->hasMany(TratamientoMedicamento::class, 'id_medicamento', 'id_medicamento');
    }
}
