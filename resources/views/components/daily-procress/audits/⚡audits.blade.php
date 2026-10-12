<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
   <div>
    @include('components.daily-process.audits.search')
   </div>

   <div>
    @include('components.daily-process.audits.sales')
   </div>

    <div>
    @include('components.daily-process.audits.cashier')
    </div>
</div>