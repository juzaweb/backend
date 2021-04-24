<?php

namespace Tadcms\Backend\Livewire\Menu;

use Livewire\Component;

class MenuIndex extends Component
{
    public $menu;
    public $items = [];

    public function loadItems()
    {
        $this->items = [
            (object) [
                'id' => 1,
                'name' => 'deasd'
            ],
            [
                'id' => 2,
                'name' => 'dzx'
            ],
            [
                'id' => 3,
                'name' => 'cds'
            ],
        ];
    }
    
    public function render()
    {
        return view('tadcms::livewire.menu.index');
    }
}