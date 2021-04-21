<?php

namespace Tadcms\Backend\Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TopNotify extends Component
{
    public $items;
    public $total;

    public function mount()
    {
        $this->total = Auth::user()
            ->unreadNotifications()
            ->count();
    }

    public function loadItems()
    {
        $this->items = Auth::user()
            ->unreadNotifications()
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get(['id', 'data', 'created_at']);
    }

    public function render()
    {
        return view('tadcms::livewire.components.top-notify');
    }
}
