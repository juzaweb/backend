<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="row" wire:init="loadThemes">
        @foreach($themes as $theme)
                @livewire('tadcms::theme.theme-item', [
                    'theme' => $theme,
                    'activated' => get_config('activated_theme')
                ])

        @endforeach
    </div>
</div>