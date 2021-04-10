<?php

namespace Tadcms\Backend\Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Tadcms\System\Models\Taxonomy;

class FormTaxonomy extends Component
{
    public $items = [];
    public $addNewForm = false;
    public $name;
    public $taxonomy;
    
    public function mount($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }
    
    public function showAddNewForm()
    {
        $this->addNewForm = true;
    }
    
    public function loadItems()
    {
        $this->items = Taxonomy::query()
            ->where('taxonomy', '=', $this->taxonomy)
            ->limit(10)
            ->get();
    }
    
    public function add()
    {
        $this->validate([
            'name' => 'required',
        ]);
        
        Taxonomy::create([
            'name' => $this->name,
            'taxonomy' => $this->taxonomy
        ]);
        
        $this->resetForm();
        $this->loadItems();
    }
    
    public function render()
    {
        return view('tadcms::livewire.components.form_taxonomy');
    }
    
    protected function resetForm()
    {
        $this->name = '';
    }
}