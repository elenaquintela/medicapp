@extends('layouts.auth')

@section('title', 'Nuevo tratamiento – MedicApp')

@section('content')
<main class="flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl px-8">
        <h2 class="text-3xl font-bold text-center mb-10">Nuevo tratamiento</h2>

        <form method="POST" action="{{ route('tratamiento.store') }}" class="space-y-6">
            @csrf

            <!-- Causa del tratamiento -->
            <div>
                <label for="causa" class="block mb-1 text-lg">Causa de tratamiento</label>
                <input id="causa" name="causa" type="text" required
                       class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('causa')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botón -->
            <div class="text-center mt-8">
                <button type="submit" name="accion" value="done"
                        class="bg-yellow-300 text-[#0C1222] font-bold text-lg px-10 py-3 rounded-full hover:bg-yellow-200 transition">
                    Crear tratamiento
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
