<?php

namespace Tadcms\Backend\Livewire\Theme;

use Livewire\Component;
use Theanh\MultiTheme\Facades\Theme;

class ThemeItem extends Component
{
    public $theme;
    public $activated;
    public $isActivated;
    public $show = true;
    
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
    
    public function delete()
    {
        if ($this->theme['name'] == $this->activated) {
            return;
        }
        
        Theme::delete($this->theme['name']);
    
        $this->show = false;
    }
    
    public function render()
    {
        return view('tadcms::livewire.theme.theme-item');
    }
}
