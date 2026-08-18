<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ActivityLog;
use Livewire\WithPagination;
class ActivityLogs extends Component
{
    use WithPagination;
    public $search = '';
    public function render()
    {
        $logs = ActivityLog::with('user')->orderBy('id', 'asc')
         ->whereRelation('user', 'name', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.admin.activity-logs', compact('logs'));
    }
}
