<div class="pr-6 pb-4">
    {{-- tercer fila (Gastos por mes) --}}
    <div class="mt-4">
        <label for="" class="label_class">Gastos por mes</label>
        {{-- Primera fila: Enero y Febrero --}}
        <div class="flex gap-2 mb-2">
            <div class="w-full">
                <label for="" class="block text-xs font-medium text-gray-700">Enero</label>
                <input type="text" value="C$ {{ number_format($enero ?? 0, 2) }}"
                    class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
            </div>
            <div class="w-full">
                <label for="febrero" class="block text-xs font-medium text-gray-700">Febrero</label>
                <input type="text" value="C$ {{ number_format($febrero ?? 0, 2) }}"
                    class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
            </div>
        </div>

        {{-- Segunda fila: Marzo y Abril --}}
        <div class="flex gap-2 mb-2">
            <div class="w-full">
                <label for="" class="block text-xs font-medium text-gray-700">Marzo</label>
                <input type="text" value="C$ {{ number_format($marzo ?? 0, 2) }}"
                    class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
            </div>
            <div class="w-full">
                <label for="" class="block text-xs font-medium text-gray-700">Abril</label>
                <input type="text" value="C$ {{ number_format($abril ?? 0, 2) }}"
                    class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
            </div>
        </div>
    </div>

    {{-- Tercera fila: Mayo y Junio --}}
    <div class="flex gap-2 mb-2">
        <div class="w-full">
            <label for="" class="block text-xs font-medium text-gray-700">Mayo</label>
            <input type="text" value="C$ {{ number_format($mayo ?? 0, 2) }}"
                class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
        </div>

        <div class="w-full">
            <label for="" class="block text-xs font-medium text-gray-700">Junio</label>
            <input type="text" value="C$ {{ number_format($junio ?? 0, 2) }}"
                class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
        </div>
    </div>

    {{-- Cuarta fila: Julio y Agosto --}}
    <div class="flex gap-2 mb-2">
        <div class="w-full">
            <label for="" class="block text-xs font-medium text-gray-700">Julio</label>
            <input type="text" value="C$ {{ number_format($julio ?? 0, 2) }}"
                class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
        </div>

        <div class="w-full">
            <label for="" class="block text-xs font-medium text-gray-700">Agosto</label>
            <input type="text" value="C$ {{ number_format($agosto ?? 0, 2) }}"
                class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
        </div>
    </div>

    {{-- Quinta fila: Septiembre y Octubre --}}
    <div class="flex gap-2 mb-2">
        <div class="w-full">
            <label for="" class="block text-xs font-medium text-gray-700">Septiembre</label>
            <input type="text" value="C$ {{ number_format($septiembre ?? 0, 2) }}"
                class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
        </div>

        <div class="w-full">
            <label for="" class="block text-xs font-medium text-gray-700">Octubre</label>
            <input type="text" value="C$ {{ number_format($octubre ?? 0, 2) }}"
                class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
        </div>
    </div>

    {{-- Sexta fila: Noviembre y Diciembre --}}
    <div class="flex gap-2">
        <div class="w-full">
            <label for="" class="block text-xs font-medium text-gray-700">Noviembre</label>
            <input type="text" value="C$ {{ number_format($noviembre ?? 0, 2) }}"
                class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
        </div>

        <div class="w-full">
            <label for="" class="block text-xs font-medium text-gray-700">Diciembre</label>
            <input type="text" value="C$ {{ number_format($diciembre ?? 0, 2) }}"
                class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold w-full" disabled>
        </div>
    </div>
</div>