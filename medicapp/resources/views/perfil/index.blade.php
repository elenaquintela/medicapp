@extends('layouts.auth')

@section('title', 'Perfiles – MedicApp')

@section('content')
@php
    /** @var \App\Models\Usuario $usuario */
    $usuario = Auth::user();
    $perfiles = $usuario->perfiles;
    $perfilActivo = $usuario->perfilActivo;
@endphp

<div class="flex flex-col items-center px-10 pt-10">

    <!-- Título -->
    <h2 class="text-3xl font-bold mb-2 text-center">Perfiles</h2>
    <p class="text-center text-white mb-10">Seleccione en el desplegable amarillo el perfil que desea gestionar</p>

    <!-- Contenedor centrado con formulario y botones alineados -->
    <div class="flex flex-row items-start justify-center gap-12 w-full max-w-6xl">

        <!-- Formulario -->
        <form id="form-perfil" method="POST" action="{{ route('perfil.update', $perfilActivo->id_perfil) }}"
              class="bg-transparent border-2 border-gray-500 rounded-lg p-8 w-full max-w-md text-white">
            @csrf
            @method('PUT')

            <h3 class="text-xl font-bold mb-6 text-center text-yellow-200">Datos del paciente</h3>

            <!-- Nombre -->
            <div class="mb-6">
                <label class="block mb-2" for="nombre_paciente">Nombre</label>
                <input type="text" id="nombre_paciente" name="nombre_paciente"
                       class="w-full p-2 rounded text-black"
                       value="{{ old('nombre_paciente', $perfilActivo->nombre_paciente) }}" required>
            </div>

            <!-- Fecha de nacimiento -->
            <div class="mb-6">
                <label class="block mb-2" for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                       class="w-full p-2 rounded text-black"
                       value="{{ old('fecha_nacimiento', $perfilActivo->fecha_nacimiento) }}" required>
            </div>

            <!-- Género -->
            <div class="mb-6">
                <label class="block mb-2" for="sexo">Género</label>
                <select id="sexo" name="sexo" class="w-full p-2 rounded text-black" required>
                    <option value="F" @selected($perfilActivo->sexo === 'F')>Mujer</option>
                    <option value="M" @selected($perfilActivo->sexo === 'M')>Hombre</option>
                    <option value="NB" @selected($perfilActivo->sexo === 'NB')>No binario</option>
                    <option value="O" @selected($perfilActivo->sexo === 'O')>Otro</option>
                </select>
            </div>
        </form>

        <!-- Columna de botones -->
        <div class="flex flex-col gap-6 justify-center items-center self-stretch">

            <!-- Botón guardar -->
            <button form="form-perfil"
                    class="bg-green-500 hover:bg-green-600 text-black font-bold px-6 py-3 rounded-full shadow">
                Guardar cambios
            </button>

            <!-- Botón eliminar -->
            <form method="POST" action="{{ route('perfil.destroy', $perfilActivo->id_perfil) }}"
                  onsubmit="return confirm('¿Está seguro de que desea eliminar este perfil? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-3 rounded-full shadow">
                    Eliminar perfil
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
