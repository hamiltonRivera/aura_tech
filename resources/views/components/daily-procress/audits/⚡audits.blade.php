<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
   <div class = “lg:grid grid-cols-4 sm:grid-col-1”>

{{-- primer fila --}}
  <div>
    @include('components.daily-procress.audits.sales')
  </div>

{{-- segunda fila --}}
  <div>
  @include('components.daily-procress.audits.cashier')
  </div>
</div>
</div>