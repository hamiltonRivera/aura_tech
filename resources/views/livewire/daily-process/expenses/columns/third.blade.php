{{-- Título de la sección --}}





{{-- Tercera fila: Mayo y Junio --}}
<div class="flex gap-2 mb-2">
    <div>
        <label for="" class="block text-xs font-medium text-gray-700">Mayo</label>
        <input type="text" value="C$ {{ number_format($mayo ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>

    <div>
        <label for="" class="block text-xs font-medium text-gray-700">Junio</label>
        <input type="text" value="C$ {{ number_format($junio ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>
</div>

{{-- Cuarta fila: Julio y Agosto --}}
<div class="flex gap-2 mb-2">
    <div>
        <label for="" class="block text-xs font-medium text-gray-700">Julio</label>
        <input type="text" value="C$ {{ number_format($julio ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>

    <div>
        <label for="" class="block text-xs font-medium text-gray-700">Agosto</label>
        <input type="text" value="C$ {{ number_format($agosto ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>
</div>

{{-- Quinta fila: Septiembre y Octubre --}}
<div class="flex gap-2 mb-2">
    <div>
        <label for="" class="block text-xs font-medium text-gray-700">Septiembre</label>
        <input type="text" value="C$ {{ number_format($septiembre ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>

    <div>
        <label for="" class="block text-xs font-medium text-gray-700">Octubre</label>
        <input type="text" value="C$ {{ number_format($octubre ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>
</div>

{{-- Sexta fila: Noviembre y Diciembre --}}
<div class="flex gap-2">
    <div>
        <label for="" class="block text-xs font-medium text-gray-700">Noviembre</label>
        <input type="text" value="C$ {{ number_format($noviembre ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>

    <div>
        <label for="" class="block text-xs font-medium text-gray-700">Diciembre</label>
        <input type="text" value="C$ {{ number_format($diciembre ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>
</div>
