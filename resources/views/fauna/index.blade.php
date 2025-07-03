@extends('layouts.app')

@section('title', 'Registro de Fauna Silvestre')

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-blue-700 pb-2">
            📋 REGISTRO DE FAUNA SILVESTRE
        </h2>

        <a href="{{ route('fauna.create') }}"
           class="inline-flex items-center gap-2 mb-6 bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold px-5 py-3 rounded-lg shadow transition-all duration-200">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            ➕ Nuevo Registro
        </a>

            {{-- PLANTILLA--}}
<a href="{{ route('fauna.plantillaDescarga') }}"
   class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-green-600 text-white hover:bg-green-700 active:bg-green-800 shadow transition duration-150 text-xs font-semibold">
    Descargar plantilla PDF
</a>


        {{-- Formulario de filtros --}}
        <form action="{{ route('fauna.index') }}" method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg shadow flex flex-wrap gap-6 items-end border border-gray-200">

            <div>
                <label for="codigo" class="block mb-1 font-medium text-sm text-gray-700">Buscar por código</label>
                <input type="text" name="codigo" id="codigo" placeholder="Código" value="{{ request('codigo') }}"
                       class="border border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800">
            </div>

            <div>
                <label for="fecha_inicio" class="block mb-1 font-medium text-sm text-gray-700">Fecha inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}"
                       class="border border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800">
            </div>

            <div>
                <label for="fecha_fin" class="block mb-1 font-medium text-sm text-gray-700">Fecha fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}"
                       class="border border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800">
            </div>

            <div>
                <label for="gestion" class="block mb-1 font-medium text-sm text-gray-700">Gestión</label>
                <select name="gestion" id="gestion" class="border border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800">
                    <option value="">--Seleccione--</option>
                    @foreach($gestiones as $gestion)
                        <option value="{{ $gestion }}" {{ request('gestion') == $gestion ? 'selected' : '' }}>{{ $gestion }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white px-4 py-2 rounded shadow text-sm font-semibold transition duration-200">
                    Filtrar
                </button>
            </div>
        </form>

        {{-- Botones de exportar --}}
        <div class="flex flex-wrap gap-4 mb-6">
            <a href="{{ route('fauna.reporte.pdf', request()->only(['codigo', 'fecha_inicio', 'fecha_fin', 'gestion'])) }}"
               class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-semibold px-5 py-2.5 rounded-lg shadow transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 11V3m0 0L8 7m4-4l4 4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2M4 17h16" />
                </svg>
                Generar PDF
            </a>

            <a href="{{ route('fauna.reporte.excel', request()->only(['codigo', 'fecha_inicio', 'fecha_fin', 'gestion'])) }}"
   class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2"
   aria-label="Exportar listado a Excel">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2h-2M8 4H6a2 2 0 00-2 2v14a2 2 0 002 2h2m0-18v18m8-18v18" />
    </svg>
    Exportar a Excel
</a>

        </div>

        {{-- Tabla --}}
        <div class="overflow-auto">
            <table class="min-w-full text-sm text-left border-collapse border border-gray-300">
                <thead class="bg-blue-50 text-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-2 border">Código</th>
                        <th class="px-4 py-2 border">Fecha Recepción</th>
                        <th class="px-4 py-2 border">Ciudad</th>
                        <th class="px-4 py-2 border">Departamento</th>
                        <th class="px-4 py-2 border">Coordenadas</th>
                        <th class="px-4 py-2 border">Tipo Elemento</th>
                        <th class="px-4 py-2 border">Motivo Ingreso</th>
                        <th class="px-4 py-2 border">Lugar</th>
                        <th class="px-4 py-2 border">Institución Responsable</th>
                        <th class="px-4 py-2 border">Nombre Persona Recibe</th>
                        <th class="px-4 py-2 border">Especie</th>
                        <th class="px-4 py-2 border">Nombre Común</th>
                        <th class="px-4 py-2 border">Tipo Animal</th>
                        <th class="px-4 py-2 border">Edad Aparente</th>
                        <th class="px-4 py-2 border">Estado General</th>
                        <th class="px-4 py-2 border">Sexo</th>
                        <th class="px-4 py-2 border">Comportamiento</th>
                        <th class="px-4 py-2 border">Sospecha Enfermedad</th>
                        <th class="px-4 py-2 border">Descripción Enfermedad</th>
                        <th class="px-4 py-2 border">Alteraciones Evidentes</th>
                        <th class="px-4 py-2 border">Otras Observaciones-describa si el animal fue vacunado, recibió algun tratamiento y otros antecedentes clinicos</th>
                        <th class="px-4 py-2 border">Tiempo Cautiverio</th>
                        <th class="px-4 py-2 border">Tipo Alojamiento</th>
                        <th class="px-4 py-2 border">Contacto con Animales</th>
                        <th class="px-4 py-2 border">Descripción Contacto</th>
                        <th class="px-4 py-2 border">Padeció Enfermedad</th>
                        <th class="px-4 py-2 border">Descripción Padecimiento</th>
                        <th class="px-4 py-2 border">Tipo Alimentación</th>
                        <th class="px-4 py-2 border">Derivación CCFS</th>
                        <th class="px-4 py-2 border">Descripción Derivación</th>
                        <th class="px-4 py-2 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($faunas as $fauna)
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="px-4 py-2 border">{{ $fauna->codigo ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($fauna->fecha_recepcion)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->ciudad }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->departamento }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->coordenadas }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->tipo_elemento }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->motivo_ingreso }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->lugar }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->institucion_remitente }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->nombre_persona_recibe }}</td>
                            <td class="px-4 py-2 border italic">{{ $fauna->especie }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->nombre_comun }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->tipo_animal }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->edad_aparente }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->estado_general }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->sexo }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->comportamiento }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->sospecha_enfermedad ? 'SI' : 'NO' }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->descripcion_enfermedad }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->alteraciones_evidentes }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->otras_observaciones}}</td>
                            <td class="px-4 py-2 border">{{ $fauna->tiempo_cautiverio }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->tipo_alojamiento }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->contacto_con_animales ? 'SI' : 'NO' }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->descripcion_contacto }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->padecio_enfermedad ? 'SI' : 'NO' }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->descripcion_padecimiento }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->tipo_alimentacion }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->derivacion_ccfs ? 'SI' : 'NO' }}</td>
                            <td class="px-4 py-2 border">{{ $fauna->descripcion_derivacion }}</td>
                            <td>
    <div class="flex flex-col gap-2">
        <a href="{{ route('fauna.duplicar', $fauna->id) }}"
           class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-green-600 text-white hover:bg-green-700 active:bg-green-800 shadow transition duration-150 text-xs font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 16h8a2 2 0 002-2V8m-4 12H8a2 2 0 01-2-2V8m4-4h8a2 2 0 012 2v8a2 2 0 01-2 2h-8a2 2 0 01-2-2V6z" />
            </svg>
            Duplicar
        </a>

        <a href="{{ route('fauna.show', $fauna->id) }}"
           class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-blue-600 text-white hover:bg-blue-700 active:bg-blue-800 shadow transition duration-150 text-xs font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            Ver
        </a>

        <a href="{{ route('fauna.edit', $fauna->id) }}"
           class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-yellow-500 text-white hover:bg-yellow-600 active:bg-yellow-700 shadow transition duration-150 text-xs font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
            Editar
        </a>

        <form action="{{ route('fauna.destroy', $fauna->id) }}" method="POST" class="inline"
              onsubmit="return confirm('¿Eliminar este registro?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-red-600 text-white hover:bg-red-700 active:bg-red-800 shadow transition duration-150 text-xs font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
                Eliminar
            </button>
        </form>

        <a href="{{ route('fauna.pdf', $fauna->id) }}"
           class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-green-600 text-white hover:bg-green-700 active:bg-green-800 shadow transition duration-150 text-xs font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 11V3m0 0L8 7m4-4l4 4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2M4 17h16" />
            </svg>
            PDF
        </a>
    </div>
</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="31" class="text-center px-4 py-6 text-gray-500">No hay registros disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-center">
            {{ $faunas->links() }}
        </div>
    </div>
@endsection
