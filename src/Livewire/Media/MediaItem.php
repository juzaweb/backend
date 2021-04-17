<?php

namespace Tadcms\Backend\Livewire\Media;

use Livewire\Component;

class MediaItem extends Component
{
    protected $item;
    
    public function mount($item)
    {
        $this->item = $item;
    }
    
    public function render()
    {
        return view('tadcms::livewire.media.media-item', [
            'item' => $this->item
        ]);
    }
}