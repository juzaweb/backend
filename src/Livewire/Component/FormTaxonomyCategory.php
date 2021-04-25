<?php

namespace Tadcms\Backend\Livewire\Component;

use Livewire\Component;
use Tadcms\System\Models\Taxonomy;

class FormTaxonomyCategory extends Component
{
    public $items = [];
    public $name;
    public $parent;
    public $label;
    public $type;
    public $taxonomy;
    public $value;
    public $showFormAdd = false;
    
    public function mount($label, $type, $taxonomy, $value = [])
    {
        $this->label = $label;
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

    public function showFormAdd()
    {
        $this->showFormAdd = true;
    }

    public function add()
    {
        $this->validate([
            'name' => 'required',
        ]);

        if (Taxonomy::whereHas('translations', function ($q) {
            $q->where('name', '=', $this->name);
        })
            ->whereType($this->type)
            ->whereTaxonomy($this->taxonomy)
            ->exists()
        ) {
            return $this->addError('name', trans('validation.exists', [
                'attribute' => trans('tadcms::app.name')
            ]));
        }

        $model = Taxonomy::create([
            'name' => $this->name,
            'parent_id' => $this->parent,
            'type' => $this->type,
            'taxonomy' => $this->taxonomy
        ]);

        $this->resetForm();
        $this->items->push($model);
    }

    public function render()
    {
        return view('tadcms::livewire.components.form-category');
    }

    protected function resetForm()
    {
        $this->name = '';
        $this->parent = '';
    }
}
