<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Informe de tratamiento</title>
<style>
  body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color: #222; }
  h1,h2,h3 { margin: 0 0 8px; }
  .box { border: 1px solid #ccc; padding: 10px; margin-bottom: 12px; }
  .muted { color: #666; }
  table { width: 100%; border-collapse: collapse; margin-top: 6px; }
  th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
  th { background: #f2f2f2; }
</style>
</head>
<body>
  <h1>MedicApp — Informe</h1>
  <p class="muted">Generado: {{ $generado_en->format('d/m/Y H:i') }} — Por: {{ $generado_por->email }}</p>

  <div class="box">
    <h2>Perfil</h2>
    <p><strong>Paciente:</strong> {{ $perfil->nombre_paciente }}</p>
    <p><strong>Fecha de nacimiento:</strong> {{ \Illuminate\Support\Carbon::parse($perfil->fecha_nacimiento)->format('d/m/Y') }}</p>
    <p><strong>Género:</strong> {{ $perfil->sexo }}</p>
  </div>

  <div class="box">
    <h2>Tratamiento</h2>
    <p><strong>ID:</strong> #{{ $tratamiento->id_tratamiento }}</p>
    <p><strong>Causa:</strong> {{ $tratamiento->causa }}</p>
    <p><strong>Inicio:</strong> {{ \Illuminate\Support\Carbon::parse($tratamiento->fecha_inicio)->format('d/m/Y') }}</p>
    <p><strong>Estado:</strong> {{ $tratamiento->estado }}</p>
    <p><strong>Rango del informe:</strong> {{ \Illuminate\Support\Carbon::parse($inicio)->format('d/m/Y') }} — {{ \Illuminate\Support\Carbon::parse($fin)->format('d/m/Y') }}</p>
  </div>

  <div class="box">
    <h3>Medicaciones</h3>
    @php $meds = method_exists($tratamiento,'medicaciones') ? $tratamiento->medicaciones : collect(); @endphp
    @if($meds->count())
      <table>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Indicacion</th>
            <th>Presentación</th>
            <th>Vía</th>
            <th>Dosis</th>
            <th>Pauta</th>
            <th>Inicio</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          @foreach($meds as $m)
            <tr>
              <td>{{ optional($m->medicamento)->nombre ?? '—' }}</td>
              <td>{{ $m->indicacion }}</td>
              <td>{{ $m->presentacion }}</td>
              <td>{{ $m->via }}</td>
              <td>{{ $m->dosis }}</td>
              <td>{{ $m->pauta_intervalo }} {{ $m->pauta_unidad }}</td>
              <td>{{ optional($m->fecha_hora_inicio)->format('d/m/Y H:i') }}</td>
              <td>{{ $m->estado }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p class="muted">No hay medicaciones registradas para este tratamiento.</p>
    @endif
  </div>

</body>
</html>
