<?php

namespace Tadcms\Backend\Livewire\Component;

use Livewire\Component;
use Tadcms\System\Models\Taxonomy;
use Tadcms\System\Repositories\TaxonomyRepository;

class FormTaxonomy extends Component
{
    public $items = [];
    public $addNewForm = false;
    public $name;
    public $taxonomy;
    public $value;
    private $taxonomyRepository;
    
    public function mount($taxonomy, $value = [])
    {
        $this->taxonomy = $taxonomy;
        $this->value = $value;
        $this->taxonomyRepository = app()->make(TaxonomyRepository::class);
    }
    
    public function showAddNewForm()
    {
        $this->addNewForm = true;
    }
    
    public function loadItems()
    {
        $taxonomy = $this->taxonomy['taxonomy'];
        $this->items = Taxonomy::with(['childrens'])
            ->where('taxonomy', '=', $taxonomy)
            ->whereNull('parent_id')
            ->limit(10)
            ->get();
    }
    
    public function add()
    {
        $this->validate([
            'name' => 'required',
        ]);
        
        $model = $this->taxonomyRepository->create([
            'name' => $this->name,
            'taxonomy' => $this->taxonomy['taxonomy']
        ]);
        
        $this->resetForm();
        $this->items->push($model);
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