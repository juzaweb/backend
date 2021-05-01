<?php

namespace Tadcms\Backend\Livewire\Component;

use Livewire\Component;
use Tadcms\System\Models\Post;

class FormTaxonomyTag extends Component
{
    public $items = [];
    /**
     * @var \Illuminate\Support\Collection $taxonomy
     **/
    protected $taxonomy;
    protected $value;

    public function mount($taxonomy, $value = null)
    {
        $this->taxonomy = $taxonomy;
        $this->value = $value;
    }

    public function loadItems()
    {
        if ($this->value) {
            $post = is_numeric($this->value) ? Post::find($this->value) : $this->value;
            $this->items = $post->taxonomies()->with(['translations'])
                ->where('type', '=', $this->taxonomy->get('type'))
                ->where('taxonomy', '=', $this->taxonomy->get('singular'))
                ->get(['id', 'taxonomy']);
        }
    }
    
    public function render()
    {
        $this->loadItems();
        return view('tadcms::livewire.components.form-tag', [
            'taxonomy' => $this->taxonomy
        ]);
    }
}
