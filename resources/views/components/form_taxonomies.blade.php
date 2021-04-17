@if($config['type'] == 'category')
    @livewire('tadcms::component.form-taxonomies', [
        'taxonomy' => $config,
        'value' => $value ?? []
    ])
@endif

@if($config['type'] == 'tag')
    @livewire('tadcms::component.form-tags', [
        'taxonomy' => $config,
        'value' => $value ?? []
    ])
@endif