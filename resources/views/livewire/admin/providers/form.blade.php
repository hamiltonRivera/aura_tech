<div class="lg:grid grid-cols-2 sm:grid-col-1">
    {{-- primer  columna--}}
  <div>
    {{-- primer fila --}}
    <div>
      @include('livewire.admin.providers.form.name')
    </div>

    {{-- segunda fila --}}
    <div>
        @include('livewire.admin.providers.form.contact_number')
    </div>

    {{-- tercer fila --}}
    <div>
        {{-- @include('livewire.administrative.providers.form.carga-excel') --}}
    </div>
  </div>

  {{-- segunda columna --}}
   <div>
     {{-- primer fila --}}
     <div>
        @include('livewire.admin.providers.form.city')
     </div>
     {{-- segunda fila --}}
     <div>
        @include('livewire.admin.providers.form.company')
     </div>

     {{-- tercer fila --}}
     <div>
        @include('livewire.admin.providers.form.bottons')
     </div>
   </div>
</div>






