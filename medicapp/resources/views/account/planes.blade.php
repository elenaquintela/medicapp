<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Elija su plan – MedicApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0C1222] text-white min-h-screen font-sans flex flex-col justify-between">

    <!-- Header -->
    <x-header />

    <main class="flex-grow flex flex-col items-center px-4 py-12">
        <h2 class="text-3xl font-bold text-center mb-12 uppercase tracking-wide">
            Elija un plan para su cuenta
        </h2>

        <div class="overflow-x-auto w-full max-w-6xl">
            <table class="table-auto w-full text-lg">
                <thead>
                    <tr class="text-left border-b border-white">
                        <th class="py-4 px-6"></th>
                        <th class="py-4 px-6 text-center text-yellow-300 text-xl font-bold align-middle">
                            Estándar<br><span class="text-white text-sm">GRATIS</span>
                        </th>
                        <th class="py-4 px-6 text-center text-blue-300 text-xl font-bold align-middle">
                            Premium<br><span class="text-white text-sm">10 €/MES</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $features = [
                            'Creación de múltiples perfiles' => [true, true],
                            'Gestión de tratamientos y citas médicas' => [true, true],
                            'Configuración de alertas y recordatorios' => [true, true],
                            'Soporte multiusuario (invite a familiares y cuidadores a gestionar su perfil)' => [false, true],
                            'Generación y exportación de informes personalizados' => [false, true],
                            'Sincronización de citas médicas con Google Calendar' => [false, true],
                        ];
                    @endphp
            
                    @foreach($features as $desc => [$std, $prem])
                    <tr class="border-t border-white">
                        <td class="py-4 px-6">{{ $desc }}</td>
                        <td class="py-4 px-6 text-center">{!! $std ? '✅' : '❌' !!}</td>
                        <td class="py-4 px-6 text-center">{!! $prem ? '✅' : '❌' !!}</td>
                    </tr>
                    @endforeach
            
                    <tr>
                        <td></td>
                        <td class="py-8 px-6 text-center">
                            <a href="{{ route('dashboard') }}"
                               class="inline-block bg-yellow-200 text-[#0C1222] font-bold px-8 py-3 rounded hover:bg-yellow-300 transition">
                                SELECCIONAR
                            </a>
                        </td>
                        <td class="py-8 px-6 text-center">
                            <a href="{{ route('dashboard') }}"
                               class="inline-block bg-blue-300 text-[#0C1222] font-bold px-8 py-3 rounded hover:bg-blue-200 transition">
                                SELECCIONAR
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </main>

    <!-- Footer -->
    <x-footer />
</body>
</html>
