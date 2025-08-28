@php
  $perfil = $inv->perfil;
  $invitador = $inv->invitador;
@endphp
<!DOCTYPE html>
<html lang="es">
  <body style="font-family: Arial, Helvetica, sans-serif; line-height:1.5; color:#222">
    <p>Hola,</p>

    <p>
      {{ $invitador->nombre ?? $invitador->email }} te ha invitado a gestionar el perfil
      <strong>{{ $perfil->nombre_paciente }}</strong> en MedicApp.
    </p>

    <p>Para aceptar la invitación, haz clic </p>
    <p>
      <a href="{{ $link }}">AQUÍ: {{ $link }}</a>
    </p>

    <p>
      Si ya tienes cuenta, inicia sesión con este email ({{ $inv->email }}).<br>
      Si no tienes, podrás crearla y se aceptará la invitación automáticamente.
    </p>

    @if($inv->expires_at)
      <p>Este enlace caduca el {{ $inv->expires_at->format('d/m/Y H:i') }}.</p>
    @endif

    <p>Gracias,<br>Equipo MedicApp</p>
  </body>
</html>
