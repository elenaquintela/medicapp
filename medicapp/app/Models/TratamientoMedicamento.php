<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Medicamento;

class TratamientoMedicamento extends Model
{
    use HasFactory;

    protected $table = 'tratamiento_medicamento';
    protected $primaryKey = 'id_trat_med';
    public $timestamps = true;

    protected $fillable = [
        'id_tratamiento',
        'id_medicamento',
        'indicacion',
        'presentacion',
        'via',
        'dosis',
        'pauta_intervalo',
        'pauta_unidad',
        'fecha_hora_inicio',
        'observaciones',
        'estado',
        'sustituido_por',
    ];

    protected $casts = [
        'fecha_hora_inicio' => 'datetime',
        'pauta_intervalo'   => 'integer',
    ];

    /** ----------------- Relaciones ----------------- */
    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class, 'id_tratamiento', 'id_tratamiento');
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'id_medicamento', 'id_medicamento');
    }

    public function recordatorios()
    {
        return $this->hasMany(Recordatorio::class, 'id_trat_med', 'id_trat_med');
    }

    /** El nuevo TM que sustituyó a ESTE registro (self FK: sustituido_por) */
    public function sustituidoPor()
    {
        return $this->belongsTo(self::class, 'sustituido_por', 'id_trat_med');
    }

    /** Registros que fueron sustituidos POR este (inverso útil en listados) */
    public function sustitutoDe()
    {
        return $this->hasMany(self::class, 'sustituido_por', 'id_trat_med');
    }

    public function sustituto() { return $this->sustituidoPor(); }
    public function sustitucionesHechas() { return $this->sustitutoDe(); }

    
    public function scopeActivas($q)     { return $q->where('estado', 'activo'); }
    public function scopeArchivadas($q)  { return $q->where('estado', 'archivado'); }
    public function scopeConSustitucion($q) { return $q->whereNotNull('sustituido_por'); }

    /** Accesor */
    public function getPautaTextoAttribute()
    {
        return "{$this->pauta_intervalo} {$this->pauta_unidad}";
    }

   
    public function sustituir(array $data): self
    {
        return DB::transaction(function () use ($data) {
            // 1) Resolver medicamento (catálogo)
            if (empty($data['id_medicamento'])) {
                $nombre = trim($data['nombre'] ?? '');
                if ($nombre === '') {
                    throw new \InvalidArgumentException('Debe indicarse nombre o id_medicamento.');
                }
                $med = Medicamento::firstOrCreate(['nombre' => $nombre], ['descripcion' => null]);
                $data['id_medicamento'] = $med->id_medicamento;
            }

            // 2) Crear nueva línea con la MISMA indicación y tratamiento
            $nuevo = self::create([
                'id_tratamiento'    => $this->id_tratamiento,
                'id_medicamento'    => $data['id_medicamento'],
                'indicacion'        => $this->indicacion, // fija, no se cambia
                'presentacion'      => $data['presentacion'],
                'via'               => $data['via'],
                'dosis'             => $data['dosis'],
                'pauta_intervalo'   => (int)$data['pauta_intervalo'],
                'pauta_unidad'      => $data['pauta_unidad'],
                'fecha_hora_inicio' => $data['fecha_hora_inicio'] ?? null,
                'observaciones'     => $data['observaciones'] ?? null,
                'estado'            => 'activo',
            ]);

            // 3) Archivar la antigua y enlazar sustitución
            $this->update([
                'estado'         => 'archivado',
                'sustituido_por' => $nuevo->id_trat_med,
            ]);

            // 4) Eliminar recordatorios FUTUROS del antiguo
            $this->recordatorios()
                 ->where('fecha_hora', '>', Carbon::now())
                 ->delete();

            // (Los recordatorios del nuevo se generarán al entrar al dashboard)
            return $nuevo;
        });
    }
}
