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



};
?>

<div>
    {{-- It always seems impossible until it is done. - Nelson Mandela --}}
</div>