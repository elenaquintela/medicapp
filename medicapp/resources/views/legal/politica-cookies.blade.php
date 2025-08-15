@extends('layouts.registro')

@section('title', 'Política de Cookies – MedicApp')

@section('content')
<main class="flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl px-8">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-3xl font-bold text-center flex-1">Política de Cookies</h2>
            @include('components.legal-back')
        </div>

        <div class="prose prose-invert max-w-none text-white/90">
            <p class="mt-6">En esta Política de Cookies te explicamos qué son las cookies, qué tipos utiliza este sitio y cómo puedes gestionarlas. En la configuración actual de la plataforma <strong>solo se usan cookies técnicas o necesarias</strong> para el funcionamiento básico; no empleamos cookies de analítica, publicidad ni perfiles de terceros.</p>

            <h3 class="text-2xl font-semibold mt-10 mb-4">1. ¿Qué son las cookies?</h3>
            <p>Las cookies son pequeños archivos que se almacenan en tu dispositivo cuando navegas por un sitio web. Sirven para recordar información sobre tu visita, como tu sesión iniciada o las preferencias básicas, con el fin de facilitar la navegación y mejorar la experiencia.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">2. ¿Qué tipos de cookies existen?</h3>
            <ul class="list-disc pl-6">
                <li><strong>Técnicas o necesarias:</strong> permiten el funcionamiento básico de la web (iniciar sesión, mantener sesiones, seguridad, carga de páginas). <em>Estas no requieren tu consentimiento.</em></li>
                <li><strong>Preferencias o personalización:</strong> recuerdan opciones como idioma o interfaz.</li>
                <li><strong>Analíticas o de medición:</strong> ayudan a comprender cómo se usa el sitio (p. ej., páginas más visitas). Suelen requerir consentimiento.</li>
                <li><strong>Publicidad o comportamentales:</strong> muestran anuncios personalizados en base a tu navegación. Requieren consentimiento.</li>
            </ul>

            <h3 class="text-2xl font-semibold mt-8 mb-4">3. Cookies que usa este sitio (estado actual)</h3>
            <p>En el momento actual, el sitio <strong>solo utiliza cookies técnicas</strong> imprescindibles para que la aplicación funcione correctamente:</p>

            <div class="overflow-x-auto">
                <table class="table-auto w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th class="py-2 border-b border-white/10">Cookie</th>
                            <th class="py-2 border-b border-white/10">Tipo</th>
                            <th class="py-2 border-b border-white/10">Finalidad</th>
                            <th class="py-2 border-b border-white/10">Duración</th>
                            <th class="py-2 border-b border-white/10">Propietario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 border-b border-white/10"><code>XSRF-TOKEN</code></td>
                            <td class="py-2 border-b border-white/10">Técnica / Seguridad</td>
                            <td class="py-2 border-b border-white/10">Protege los formularios contra ataques CSRF.</td>
                            <td class="py-2 border-b border-white/10">Sesión</td>
                            <td class="py-2 border-b border-white/10">Propia (MedicApp)</td>
                        </tr>
                        <tr>
                            <td class="py-2 border-b border-white/10"><code>laravel_session</code></td>
                            <td class="py-2 border-b border-white/10">Técnica</td>
                            <td class="py-2 border-b border-white/10">Mantiene la sesión iniciada del usuario y el enrutado interno.</td>
                            <td class="py-2 border-b border-white/10">Sesión</td>
                            <td class="py-2 border-b border-white/10">Propia (MedicApp)</td>
                        </tr>
                        <tr>
                            <td class="py-2 border-b border-white/10"><code>remember_web_*</code> (opcional)</td>
                            <td class="py-2 border-b border-white/10">Técnica</td>
                            <td class="py-2 border-b border-white/10">“Recordar sesión” cuando eliges mantener la sesión iniciada.</td>
                            <td class="py-2 border-b border-white/10">Persistente</td>
                            <td class="py-2 border-b border-white/10">Propia (MedicApp)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <h3 class="text-2xl font-semibold mt-8 mb-4">4. Cookies de terceros</h3>
            <p>Algunas funcionalidades opcionales pueden integrarse con servicios externos (por ejemplo, Google Calendar o servicios de correo para notificaciones). <strong>Este sitio no instala cookies de estos terceros</strong> por sí mismo; no obstante, si accedes a sus plataformas o interactúas con contenidos externos, dichos terceros pueden usar sus propias cookies conforme a sus políticas.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">5. ¿Cómo puedes gestionar o deshabilitar las cookies?</h3>
            <p>Puedes permitir, bloquear o eliminar las cookies desde la configuración de tu navegador. Los pasos varían según el navegador:</p>
            <ul class="list-disc pl-6">
                <li><strong>Chrome, Edge, Brave:</strong> Configuración &gt; Privacidad y seguridad &gt; Cookies y otros datos de sitios.</li>
                <li><strong>Firefox:</strong> Preferencias &gt; Privacidad &amp; Seguridad &gt; Cookies y datos del sitio.</li>
                <li><strong>Safari (macOS/iOS):</strong> Preferencias &gt; Privacidad &gt; Gestionar datos de sitios web.</li>
            </ul>
            <p class="mt-4">Ten en cuenta que bloquear las cookies técnicas puede impedir el funcionamiento correcto de la aplicación (inicio de sesión, seguridad y navegación interna).</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">6. Actualizaciones de esta política</h3>
            <p>Esta Política de Cookies puede actualizarse para reflejar cambios técnicos o legales. Cuando la modificación sea relevante, se te informará de forma visible (por ejemplo, mediante un aviso en el sitio o el banner de cookies).</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">7. Contacto</h3>
            <p>Si tienes dudas sobre el uso de cookies en este sitio, puedes escribir a <strong>a23elenaqb@iessanclemente.net</strong>. Para más información sobre cómo tratamos tus datos personales, consulta la <a href="{{ url('/politica-privacidad') }}" class="underline hover:no-underline">Política de Privacidad</a>.</p>

            <p class="mt-8 text-sm text-white/60">Última actualización: {{ now()->format('d/m/Y') }}</p> <br>
        </div>
    </div>
</main>
@endsection
