<?php

use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use App\Models\ActivityLog;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;
    public $search = '';
    
    public function with(): array
{
    return [
        'sales' => Sale::with('user')
            ->orderBy('id', 'desc')
            ->where('numFactura', 'like', '%' . $this->search . '%')
            ->orWhereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10),
    ];
}

public function refresh()
  {
    return redirect('/private/admin/sales_to_cancel');
  }

public function anularVenta($id)
{
    
}



};
?>

<div>
      <div class="mb-3">
        @include('components.admin.sales-history-to-cancel.search')
      </div>
    
     <div class="mb-3">
        @include('components.admin.sales-history-to-cancel.table')
      </div>

</div>