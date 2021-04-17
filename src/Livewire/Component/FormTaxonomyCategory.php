<?php

namespace Tadcms\Backend\Livewire\Component;

use Livewire\Component;
use Tadcms\System\Models\Taxonomy;
use Tadcms\System\Repositories\TaxonomyRepository;

class FormTaxonomyCategory extends Component
{
    public $items = [];
    public $name;
    public $taxonomy;
    public $value;
    public $showFormAdd = false;
    private $taxonomyRepository;
    
    public function mount($taxonomy, $value = [])
    {
        $this->taxonomy = $taxonomy;
        $this->value = $value;
        $this->taxonomyRepository = app()->make(TaxonomyRepository::class);
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
        $this->showFormAdd = true;
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
        return view('tadcms::livewire.components.form_category');
    }
    
    protected function resetForm()
    {
        $this->name = '';
    }
}