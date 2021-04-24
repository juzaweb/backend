<?php

namespace Tadcms\Backend\Livewire\Component;

use Livewire\Component;
use Tadcms\System\Models\Taxonomy;

class FormTaxonomyCategory extends Component
{
    public $items = [];
    public $name;
    public $type;
    public $taxonomy;
    public $value;
    
    public function mount($type, $taxonomy, $value = [])
    {
        $this->type = $type;
        $this->taxonomy = $taxonomy;
        $this->value = $value;
    }
    
    public function loadItems()
    {
        $this->items = Taxonomy::with(['childrens'])
            ->where('type', '=', $this->type)
            ->where('taxonomy', '=', $this->taxonomy)
            ->whereNull('parent_id')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('tadcms::livewire.components.form_category');
    }
}
