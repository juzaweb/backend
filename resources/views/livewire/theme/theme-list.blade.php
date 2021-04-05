<div class="row">
    @foreach($themes as $theme)
        <div class="col-md-4">
        @livewire('tadcms::theme.theme-item', [
                'theme' => $theme,
                'activated' => get_config('activated_theme')
            ])
        </div>
    @endforeach
</div>