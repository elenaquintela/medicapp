@extends('layouts.welcome')

@section('content')
<div class="flex items-center justify-center min-h-screen relative px-4">
    <div class="flex flex-col lg:flex-row w-full max-w-6xl bg-[#0C1222] rounded-lg shadow-lg overflow-hidden">
        <div class="w-full lg:w-1/2 p-6 sm:p-8 lg:p-12 flex flex-col justify-center space-y-4 sm:space-y-6">
            <div class="shrink-0 flex items-center justify-center lg:justify-start space-x-3">
                <img src="{{ asset('logo.png') }}" alt="Logo MedicApp" class="w-16 h-12 sm:w-20 sm:h-16">
                <span class="text-4xl sm:text-5xl lg:text-6xl font-bold">MedicApp</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-center lg:text-left">Tu medicación, siempre a tiempo</h2>

            <p class="text-lg sm:text-xl leading-relaxed text-center">
                MedicApp te recuerda cada toma,<br>
                organiza tus <span class="text-yellow-300">citas médicas</span> y guarda <br>
                todo tu <span class="text-yellow-300">tratamiento</span> en un solo lugar…<br>
                para que tú solo te dediques a <span class="text-yellow-300">vivir</span>.
            </p>

            <div class="text-center mt-4 sm:mt-6">
                <a href="{{ route('register') }}"
                   class="inline-block bg-yellow-300 text-[#0C1222] font-bold py-3 px-8 sm:px-10 rounded-full hover:bg-yellow-200 transition">
                    Comenzar
                </a>
            </div>
        </div>

        <div class="w-full lg:w-1/2 p-6 sm:p-8 lg:p-12 flex flex-col justify-center border-t-4 lg:border-t-0 lg:border-l-4 border-yellow-300 lg:rounded-r-lg">
            <h2 class="text-lg sm:text-xl text-center mb-1">¿Ya tienes una cuenta?</h2>
            <h3 class="text-xl sm:text-2xl font-bold text-center mb-4 sm:mb-6">Iniciar sesión</h3>

            <form method="POST" action="{{ route('login') }}" class="space-y-3 sm:space-y-4">
                @csrf

                <div>
                    <label for="email" class="block mb-1 font-semibold text-sm sm:text-base">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded shadow-sm text-[#0C1222] text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <p class="text-xs sm:text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block mb-1 font-semibold text-sm sm:text-base">Contraseña</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded shadow-sm text-[#0C1222] text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <p class="text-xs sm:text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="text-center mt-4 sm:mt-6">
                    <button type="submit"
                            class="bg-yellow-300 text-[#0C1222] font-bold px-8 sm:px-10 py-3 rounded-full hover:bg-yellow-200 transition text-sm sm:text-base">
                        Acceder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
