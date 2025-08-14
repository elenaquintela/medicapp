@extends('layouts.registro')

@section('title', 'Política de Privacidad – MedicApp')

@section('content')
<main class="flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl px-8">
        <h2 class="text-3xl font-bold text-center mb-10">Política de Privacidad</h2>
        @include('components.legal-back')

        <div class="prose prose-invert max-w-none text-white/90">
            <p class="mt-6">En esta Política de Privacidad te explicamos cómo recopilamos, usamos y protegemos tus datos personales al utilizar <strong>MedicApp</strong>. Esta aplicación es un <strong>proyecto académico</strong> desarrollado con fines educativos, que simula el funcionamiento de un servicio real de gestión de tratamientos y medicación.</p>

            <h3 class="text-2xl font-semibold mt-10 mb-4">1. Responsable del tratamiento</h3>
            <p><strong>Titular:</strong> Elena Quintela Babío<br>
            <strong>Domicilio:</strong> Proyecto académico – sin domicilio físico asociado<br>
            <strong>Email de contacto:</strong> a23elenaqb@iessanclemente.net<br>
            <strong>Dominio:</strong> www.medicapp.com</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">2. Finalidad del tratamiento</h3>
            <p>Los datos personales que recogemos se utilizan para:</p>
            <ul class="list-disc pl-6">
                <li>Gestionar el registro y autenticación de usuarios.</li>
                <li>Crear y administrar perfiles de pacientes.</li>
                <li>Registrar tratamientos, medicamentos y pautas.</li>
                <li>Generar recordatorios de tomas de medicación.</li>
                <li>Gestionar citas médicas y notificaciones asociadas.</li>
                <li>Permitir el envío de invitaciones a otros usuarios para compartir perfiles.</li>
                <li>Sincronizar opcionalmente con Google Calendar (si el usuario lo autoriza).</li>
                <li>Enviar notificaciones por correo electrónico a través de SMTP o Mailtrap (según configuración).</li>
            </ul>

            <h3 class="text-2xl font-semibold mt-8 mb-4">3. Categorías de datos tratados</h3>
            <ul class="list-disc pl-6">
                <li><strong>Datos identificativos:</strong> nombre, correo electrónico, credenciales de acceso.</li>
                <li><strong>Datos de salud:</strong> información sobre tratamientos, medicamentos, dosis, pautas, citas y recordatorios.</li>
                <li><strong>Datos técnicos:</strong> dirección IP, logs de acceso y cookies técnicas necesarias para el funcionamiento.</li>
            </ul>
            <p>Los <strong>datos de salud</strong> se consideran categorías especiales según el RGPD y se tratan únicamente con el <strong>consentimiento expreso</strong> del usuario.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">4. Base jurídica</h3>
            <ul class="list-disc pl-6">
                <li><strong>Consentimiento del usuario</strong> para el tratamiento de datos de salud y la sincronización con servicios externos (Google Calendar).</li>
                <li><strong>Ejecución de un contrato</strong> (aunque sea un servicio gratuito) para la gestión de la cuenta y el acceso a las funcionalidades.</li>
                <li><strong>Interés legítimo</strong> para el mantenimiento y mejora de la seguridad de la plataforma.</li>
            </ul>

            <h3 class="text-2xl font-semibold mt-8 mb-4">5. Conservación de datos</h3>
            <p>Los datos se conservarán mientras el usuario mantenga una cuenta activa. En caso de eliminación de la cuenta, los datos serán eliminados de forma segura y definitiva.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">6. Destinatarios de los datos</h3>
            <p>Los datos no se cederán a terceros, salvo:</p>
            <ul class="list-disc pl-6">
                <li>Obligación legal.</li>
                <li>Servicios de terceros necesarios para el funcionamiento (Google Calendar, proveedores de email como SMTP o Mailtrap).</li>
            </ul>
            <p>En caso de uso de Google Calendar, se aplicará también la política de privacidad de Google.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">7. Transferencias internacionales</h3>
            <p>El uso de Google Calendar y servicios de correo puede implicar transferencias internacionales de datos a Estados Unidos, amparadas en las cláusulas contractuales tipo de la Comisión Europea o el marco de privacidad UE-EE.UU. cuando sea aplicable.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">8. Derechos del usuario</h3>
            <p>En cualquier momento, el usuario puede ejercer los siguientes derechos:</p>
            <ul class="list-disc pl-6">
                <li>Acceder a sus datos personales.</li>
                <li>Rectificar los datos inexactos o incompletos.</li>
                <li>Solicitar la supresión de sus datos.</li>
                <li>Limitar u oponerse al tratamiento.</li>
                <li>Solicitar la portabilidad de sus datos.</li>
                <li>Retirar el consentimiento en cualquier momento.</li>
            </ul>
            <p>Para ejercer estos derechos, puede enviar un correo a <strong>a23elenaqb@iessanclemente.net</strong> indicando el derecho que desea ejercer y acreditando su identidad.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">9. Seguridad</h3>
            <p>Aplicamos medidas técnicas y organizativas para proteger los datos, incluyendo cifrado de contraseñas, uso de HTTPS/TLS y controles de acceso. No obstante, la seguridad absoluta en Internet no puede garantizarse.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">10. Cookies</h3>
            <p>Para más información sobre el uso de cookies, consulta nuestra <a href="{{ url('/politica-cookies') }}" class="underline hover:no-underline">Política de Cookies</a>.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">11. Modificaciones</h3>
            <p>Esta Política de Privacidad puede actualizarse para adaptarse a cambios legales o técnicos. Cuando sea relevante, se informará de forma visible en el sitio web.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">12. Autoridad de control</h3>
            <p>Si considera que sus derechos han sido vulnerados, puede presentar una reclamación ante la <a href="https://www.aepd.es/" target="_blank" rel="noopener">Agencia Española de Protección de Datos (AEPD)</a>.</p>

            <p class="mt-8 text-sm text-white/60">Última actualización: {{ now()->format('d/m/Y') }}</p> <br>
        </div>
    </div>
</main>
@endsection
