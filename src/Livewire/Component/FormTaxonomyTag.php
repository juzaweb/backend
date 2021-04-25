<?php

namespace Tadcms\Backend\Livewire\Component;

use Livewire\Component;
use Tadcms\System\Models\Taxonomy;

class FormTaxonomyTag extends Component
{
    public $items = [];
    public $type;
    public $label;
    public $name;
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
            'type' => $this->type,
            'taxonomy' => $this->taxonomy,
        ]);
        
        $this->resetForm();
        $this->value->push($model);
    }
    
    public function render()
    {
        return view('tadcms::livewire.components.form-tag');
    }
    
    protected function resetForm()
    {
        $this->name = '';
    }
}
