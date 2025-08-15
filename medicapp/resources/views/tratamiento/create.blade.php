@extends('layouts.auth')

@section('title', 'Nuevo tratamiento – MedicApp')

@section('content')
<main class="flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl px-8">
        <h2 class="text-3xl font-bold text-center mb-10">Nuevo tratamiento</h2>

        <form method="POST" action="{{ route('tratamiento.store') }}" class="space-y-6">
            @csrf
            <div>
                <label for="causa" class="block mb-1 text-lg">Causa de tratamiento</label>
                <input id="causa" name="causa" type="text" required
                       value="{{ old('causa') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('causa')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if ($volver_a_index ?? false)
                <input type="hidden" name="volver_a_index" value="1">
            @endif

            <div class="text-center mt-8">
                <button type="submit" name="accion" value="done"
                        class="bg-yellow-300 text-[#0C1222] font-bold text-lg px-10 py-3 rounded-full hover:bg-yellow-200 transition">
                    Crear tratamiento
                </button>
            </div>
        </form>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const causasExistentes = @json($perfilActivo->tratamientos->pluck('causa')->map(fn($c) => mb_strtolower(trim($c))));
        const form = document.querySelector('form');
        const inputCausa = document.getElementById('causa');

        form.addEventListener('submit', function (e) {
            const causaIngresada = inputCausa.value.trim().toLowerCase();

            if (causasExistentes.includes(causaIngresada)) {
                e.preventDefault();

                let error = inputCausa.parentElement.querySelector('.js-error');
                if (error) error.remove();

                const mensaje = document.createElement('p');
                mensaje.textContent = 'Este perfil ya tiene un tratamiento con esa causa. Usa otro nombre.';
                mensaje.classList.add('text-red-500', 'text-sm', 'mt-1', 'js-error');

                inputCausa.parentElement.appendChild(mensaje);
            }
        });
    });
</script>

@endsection
