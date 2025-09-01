@extends('layouts.registro')

@section('title', 'Elija su plan – MedicApp')

@section('content')
@php
    $features = [
        'Creación de múltiples perfiles' => [true, true],
        'Gestión de tratamientos y citas médicas' => [true, true],
        'Recordatorios de tomas y citas' => [true, true],
        'Soporte multiusuario (invite a familiares y cuidadores a gestionar su perfil)' => [false, true],
        'Generación y exportación de informes personalizados' => [false, true],
        'Sincronización de citas médicas con Google Calendar' => [false, true],
    ];
@endphp

<main class="flex-grow flex flex-col items-center px-4 py-8 sm:py-12">
    <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 sm:mb-12 uppercase tracking-wide">
        Elija un plan para su cuenta
    </h2>

    {{-- ====== MÓVIL: Cards ====== --}}
    <div class="w-full max-w-xl space-y-4 sm:hidden">
        {{-- Plan Estándar --}}
        <div class="bg-[#0C1222] border border-gray-600 rounded-xl p-5 text-white">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-yellow-300 text-xl font-bold">Estándar</h3>
                <span class="bg-yellow-300 text-[#0C1222] font-semibold text-xs px-2 py-1 rounded-full">GRATIS</span>
            </div>
            <ul class="mt-3 space-y-2 text-sm">
                @foreach($features as $text => [$std, $prem])
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5">{{ $std ? '✅' : '❌' }}</span>
                        <span class="{{ $std ? 'text-white' : 'text-gray-400' }}">{{ $text }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-5 text-center">
                <form method="POST" action="{{ route('planes.store') }}">
                    @csrf
                    <input type="hidden" name="rol_global" value="estandar">
                    <button type="submit"
                        class="inline-block bg-yellow-200 text-[#0C1222] font-bold px-6 py-2.5 rounded-full hover:bg-yellow-300 transition">
                        SELECCIONAR
                    </button>
                </form>
            </div>
        </div>

        {{-- Plan Premium --}}
        <div class="bg-[#0C1222] border border-gray-600 rounded-xl p-5 text-white">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-blue-300 text-xl font-bold">Premium</h3>
                <span class="bg-blue-300 text-[#0C1222] font-semibold text-xs px-2 py-1 rounded-full">10 €/MES</span>
            </div>
            <ul class="mt-3 space-y-2 text-sm">
                @foreach($features as $text => [$std, $prem])
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5">{{ $prem ? '✅' : '❌' }}</span>
                        <span class="{{ $prem ? 'text-white' : 'text-gray-400' }}">{{ $text }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-5 text-center">
                <form method="POST" action="{{ route('planes.store') }}">
                    @csrf
                    <input type="hidden" name="rol_global" value="premium">
                    <button type="submit"
                        class="inline-block bg-blue-300 text-[#0C1222] font-bold px-6 py-2.5 rounded-full hover:bg-blue-200 transition">
                        SELECCIONAR
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ====== DESKTOP: Tabla original ====== --}}
    <div class="hidden sm:block overflow-x-auto w-full max-w-6xl">
        <table class="table-auto w-full text-lg">
            <thead>
                <tr class="text-left border-b border-white">
                    <th class="py-4 px-6"></th>
                    <th class="py-4 px-6 text-center text-yellow-300 text-xl font-bold align-middle">
                        Estándar<br>
                        <span class="bg-yellow-300 text-[#0C1222] font-semibold text-xs px-2 py-1 rounded-full">GRATIS</span>
                    </th>
                    <th class="py-4 px-6 text-center text-blue-300 text-xl font-bold align-middle">
                        Premium<br>
                        <span class="bg-blue-300 text-[#0C1222] font-semibold text-xs px-2 py-1 rounded-full">10 €/MES</span>
                    </th>
                </tr>
            </thead>
            <tbody>
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
                        <form method="POST" action="{{ route('planes.store') }}">
                            @csrf
                            <input type="hidden" name="rol_global" value="estandar">
                            <button type="submit"
                                class="inline-block bg-yellow-200 text-[#0C1222] font-bold px-8 py-3 rounded hover:bg-yellow-300 transition">
                                SELECCIONAR
                            </button>
                        </form>
                    </td>
                    <td class="py-8 px-6 text-center">
                        <form method="POST" action="{{ route('planes.store') }}">
                            @csrf
                            <input type="hidden" name="rol_global" value="premium">
                            <button type="submit"
                                class="inline-block bg-blue-300 text-[#0C1222] font-bold px-8 py-3 rounded hover:bg-blue-200 transition">
                                SELECCIONAR
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</main>
@endsection
