<?php

namespace App\Livewire\DailyProcess\Combos;

use Livewire\Component;
use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Product;

class CombosEUD extends Component
{
    public function render()
    {
        return view('livewire.daily-process.combos.combos-e-u-d');
    }
}
