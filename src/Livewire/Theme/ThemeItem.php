<?php

namespace Tadcms\Backend\Livewire\Theme;

use Livewire\Component;

class ThemeItem extends Component
{
    public $theme;
    public $activated;
    public $isActivated;
    
    public function mount($theme, $activated)
    {
        $this->theme = $theme;
        $this->activated = $activated;
        $this->isActivated = ($this->theme['name'] == $this->activated);
    }
    
    public function activate()
    {
        if ($this->theme['name'] != $this->activated) {
            set_config('activated_theme', $this->theme['name']);
        }
    
        $this->isActivated = true;
    }
    
    public function render()
    {
        return view('tadcms::livewire.theme.theme-item');
    }
}
