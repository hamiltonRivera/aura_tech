<?php

namespace App\Livewire\DailyProcess\Combos;

use Livewire\Component;
use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\ComboDetail;
use App\Models\Combo;

class CombosEUD extends Component
{   

    use WithPagination;
    public $search_product = '';
    public $comboSel;
    public $description;

    public function render()
    {
        return view('livewire.daily-process.combos.combos-e-u-d');
    }
}
