@extends('layouts.registro')

@section('title', 'Aviso Legal – MedicApp')

@section('content')
<main class="flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl px-8">
        
        {{-- Título + Botón volver en la misma línea --}}
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-3xl font-bold text-center flex-1">Aviso Legal</h2>
            @include('components.legal-back')
        </div>

        <div class="prose prose-invert max-w-none text-white/90">
            <p class="mt-6"><strong>Titular del sitio:</strong> Elena Quintela Babío<br>
            <strong>NIF/CIF:</strong> Proyecto académico sin CIF<br>
            <strong>Domicilio:</strong> Proyecto académico – sin domicilio físico asociado<br>
            <strong>Correo de contacto:</strong> a23elenaqb@iessanclemente.net<br>
            <strong>Teléfono:</strong> No disponible<br>
            <strong>Nombre comercial / marca:</strong> MedicApp<br>
            <strong>Dominio/s:</strong> www.medicapp.com</p>

            <h3 class="text-2xl font-semibold mt-10 mb-4">1. Objeto del sitio web</h3>
            <p>Este sitio web ofrece una plataforma de <strong>gestión y seguimiento de tratamientos y medicación</strong>, incluyendo creación de perfiles, registro de medicación y pautas, recordatorios de tomas y gestión de citas médicas, así como la posibilidad de compartir acceso con terceros mediante invitaciones. El uso puede variar por tipo de cuenta (estándar/premium).</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">2. Condiciones de uso</h3>
            <ul class="list-disc pl-6">
                <li>No utilizar la plataforma con fines ilícitos o contrarios a la buena fe.</li>
                <li>No introducir datos falsos ni suplantar identidades.</li>
                <li>Respetar la confidencialidad y privacidad de terceros con los que se comparta acceso.</li>
                <li>Cumplir las normas específicas publicadas en el sitio.</li>
            </ul>
            <p class="mt-4">Si la persona usuaria es <strong>menor de edad</strong>, el registro y uso deben realizarse con el <strong>consentimiento y supervisión</strong> de sus representantes legales.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">3. Información sanitaria – Limitación de responsabilidad</h3>
            <p>La información gestionada en la plataforma tiene carácter <strong>informativo y organizativo</strong> y <strong>no sustituye</strong> la consulta con profesionales sanitarios. El titular no asume responsabilidad por decisiones médicas adoptadas exclusivamente en base a los datos almacenados en la aplicación.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">4. Registro y cuentas</h3>
            <p>Para funcionalidades avanzadas es necesario crear una cuenta y mantener credenciales seguras. El titular podrá <strong>suspender o cancelar</strong> cuentas que incumplan estas condiciones o impliquen riesgos de seguridad.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">5. Precios y modalidades de servicio</h3>
            <p>Actualmente el servicio es gratuito en su modalidad estándar y cuenta con un plan premium que ofrece funcionalidades adicionales. Las características de cada plan se muestran en la sección “Planes” de la cuenta de usuario.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">6. Propiedad intelectual e industrial</h3>
            <p>El software, diseño, interfaces, logotipos, nombre “MedicApp”, textos, imágenes y demás elementos del sitio están protegidos por derechos de <strong>propiedad intelectual e industrial</strong>. Queda prohibida su reproducción, distribución o comunicación pública salvo autorización expresa. Los contenidos de terceros se usan bajo sus licencias respectivas.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">7. Enlaces externos</h3>
            <p>El sitio puede contener enlaces a páginas de terceros, como Google Calendar o servicios de envío de correo. El titular <strong>no se responsabiliza</strong> de los contenidos o prácticas de privacidad de dichos sitios enlazados.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">8. Privacidad y protección de datos</h3>
            <p>Los datos personales tratados a través de la plataforma (incluyendo <strong>datos de salud</strong>) se rigen por la <a href="{{ url('/politica-privacidad') }}" class="underline hover:no-underline">Política de Privacidad</a>. El tratamiento se realiza con consentimiento expreso del usuario y cumpliendo la <strong>LOPDGDD</strong> y el <strong>RGPD</strong>.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">9. Cookies</h3>
            <p>El uso de cookies y tecnologías similares se detalla en la <a href="{{ url('/politica-cookies') }}" class="underline hover:no-underline">Política de Cookies</a>. Se proporciona información clara y mecanismos de gestión del consentimiento cuando proceda.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">10. Seguridad</h3>
            <p>El titular aplica medidas de seguridad razonables para proteger la información (por ejemplo, uso de HTTPS/TLS y buenas prácticas de desarrollo). No obstante, la seguridad absoluta en Internet no puede garantizarse.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">11. Legislación aplicable y jurisdicción</h3>
            <p>Este Aviso Legal se rige por la <strong>legislación española</strong>. Para cualquier controversia, las partes se someten a los <strong>Juzgados y Tribunales de A Coruña (España)</strong>, salvo que la normativa de consumidores y usuarios establezca otros fueros imperativos.</p>

            <h3 class="text-2xl font-semibold mt-8 mb-4">12. Contacto</h3>
            <p>Para dudas relacionadas con este Aviso Legal, puede contactar en: <strong>a23elenaqb@iessanclemente.net</strong>.</p>

            <p class="mt-8 text-sm text-white/60">Última actualización: {{ now()->format('d/m/Y') }}</p> <br>
        </div>
    </div>
</main>
@endsection
