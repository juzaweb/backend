<?php
/**
 * @package    tadcms\tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/6/2021
 * Time: 7:57 PM
 */

namespace Tadcms\Backend\Livewire\Menu;

use Livewire\Component;
use Tadcms\System\Models\Taxonomy;

class TaxonomyItems extends Component
{
    public $items = [];

    public function loadItems()
    {
        $this->items = Taxonomy::orderBy('total_post', 'DESC')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        $this->loadItems();

        return view('tadcms::livewire.menu.items');
    }
}
