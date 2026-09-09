{{-- primer fila --}}
<div>
    <div class="mb-3">
        <label for="" class="label_class">Propietario(a)</label>
        <input class="inputs-formularios-cortos" value="{{ $setting->propietario }}" disabled>
       </div>
</div>

{{-- segunda fila --}}
<div>
    <div class="mb-3">
        <label for="" class="label_class">Teléfono</label>
        <input class="inputs-formularios-cortos" value="{{ $setting->telefono }}" disabled>
       </div>
</div>

{{-- tercer fila --}}
<div>
    <div class="mb-3">
        <label for="" class="label_class">Correo</label>
        <input class="inputs-formularios-cortos" value="{{ $setting->email }}" disabled>
       </div>
</div>
