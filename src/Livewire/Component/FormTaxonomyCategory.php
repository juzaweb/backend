<?php

namespace Tadcms\Backend\Livewire\Component;

use Livewire\Component;
use Tadcms\System\Models\Taxonomy;

class FormTaxonomyCategory extends Component
{
    public $items = [];
    public $value;
    protected $taxonomy;

    public function mount($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }
    
    public function loadItems()
    {
        $this->items = Taxonomy::with(['childrens'])
            ->where('type', '=', $this->taxonomy->get('type'))
            ->where('taxonomy', '=', $this->taxonomy->get('singular'))
            ->whereNull('parent_id')
            ->get();
    }

    public function render()
    {
        $this->loadItems();
        return view('tadcms::livewire.components.form-category', [
            'taxonomy' => $this->taxonomy
        ]);
    }
}
