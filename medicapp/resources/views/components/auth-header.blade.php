@props(['perfilesUsuario', 'perfilActivo' => null])

@php
    $usuario = Auth::user();
    $rol = $usuario->rol_global;
@endphp

<header class="bg-[#0C1222] text-white py-4 px-6 flex items-center justify-between shadow-md">
    <!-- Logo + Nombre -->
    <div class="shrink-0 flex items-center space-x-3">
        <img src="{{ asset('logo.png') }}" alt="Logo MedicApp" class="w-20 h-auto">
        <span class="text-4xl font-bold text-white">MedicApp</span>
    </div>

    <!-- Controles de usuario -->
    <div class="flex items-center space-x-6">

        <!-- Selector de perfil activo -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="bg-yellow-300 text-[#0C1222] font-semibold px-4 py-2 rounded-full shadow hover:bg-yellow-200 transition inline-flex items-center">
                    <span>{{ $perfilActivo->nombre_paciente ?? 'Perfil actual' }}</span>
                    <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0l-4.25-4.25a.75.75 0 01.02-1.06z"/>
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                @if (count($perfilesUsuario) <= 1)
                    <x-dropdown-link :href="route('perfil.create')">
                        Crear nuevo perfil
                    </x-dropdown-link>
                @else
                    @foreach ($perfilesUsuario as $perfil)
                    <x-dropdown-link :href="route('dashboard', ['perfil' => $perfil->id_perfil])">
                        {{ $perfil->nombre_paciente }}
                    </x-dropdown-link>
                    @endforeach

                    <hr class="my-2 border-gray-300">

                    <x-dropdown-link :href="route('perfil.create')">
                        Nuevo perfil
                    </x-dropdown-link>
                @endif
            </x-slot>
        </x-dropdown>

        <!-- Notificaciones -->
        <a href="#" title="Notificaciones">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.104-14.684a1.5 1.5 0 1 0-1.208 0A5.002 5.002 0 0 0 3 6c0 1.098-.628 2.082-1.579 2.563A.5.5 0 0 0 1.5 9.5h13a.5.5 0 0 0 .079-.937A2.993 2.993 0 0 1 13 6a5.002 5.002 0 0 0-4.896-4.684z"/>
            </svg>
        </a>

        <!-- Menú usuario -->
        @php
            $user = Auth::user();
            $isPremium = $user->rol_global === 'premium';
        @endphp

        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-full shadow transition
                    {{ $isPremium ? 'bg-[#7fb0dd] text-white hover:bg-[#6aa1d0]' : 'bg-yellow-300 text-[#0C1222] hover:bg-yellow-200' }}">
                    <span class="font-bold mr-2">{{ $user->nombre ?? $user->name }}</span>
                    <span class="text-sm font-semibold {{ $isPremium ? 'text-white' : 'text-[#0C1222]' }}">
                        {{ ucfirst($user->rol_global) }}
                    </span>
                    <svg class="ml-2 w-4 h-4 {{ $isPremium ? 'text-white' : 'text-[#0C1222]' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('account.edit')">
                    Cuenta
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                        Salir
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>
