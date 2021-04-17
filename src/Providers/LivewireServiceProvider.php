<?php

namespace Tadcms\Backend\Providers;

use Tadcms\Backend\Livewire\Menu\MenuIndex;
use Tadcms\Backend\Livewire\Menu\MenuItem;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::component('tadcms::theme.theme-list', 'Tadcms\Backend\Livewire\Theme\ThemeList');
        Livewire::component('tadcms::theme.theme-item', 'Tadcms\Backend\Livewire\Theme\ThemeItem');
        Livewire::component('tadcms::menu.menu-index', MenuIndex::class);
        Livewire::component('tadcms::menu.menu-item', MenuItem::class);
        Livewire::component('tadcms::component.form-taxonomies', 'Tadcms\Backend\Livewire\Component\FormTaxonomyCategory');
        Livewire::component('tadcms::component.form-tags', 'Tadcms\Backend\Livewire\Component\FormTaxonomyTag');
        Livewire::component('tadcms::media.media-list', 'Tadcms\Backend\Livewire\Media\MediaList');
        Livewire::component('tadcms::media.media-item', 'Tadcms\Backend\Livewire\Media\MediaItem');
    }
}