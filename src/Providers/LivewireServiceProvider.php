<?php

namespace Tadcms\Backend\Providers;

use Tadcms\Backend\Livewire\Component\FormTaxonomy;
use Tadcms\Backend\Livewire\Menu\MenuIndex;
use Tadcms\Backend\Livewire\Menu\MenuItem;
use Tadcms\Backend\Livewire\Theme\ThemeItem;
use Tadcms\Backend\Livewire\Theme\ThemeList;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::component('tadcms::theme.theme-list', ThemeList::class);
        Livewire::component('tadcms::theme.theme-item', ThemeItem::class);
        Livewire::component('tadcms::menu.menu-index', MenuIndex::class);
        Livewire::component('tadcms::menu.menu-item', MenuItem::class);
        Livewire::component('tadcms::component.form-taxonomy', FormTaxonomy::class);
    }
}