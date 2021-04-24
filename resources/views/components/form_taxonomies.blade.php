@if(($form ?? 'category') == 'category')
    @livewire('tadcms::component.form-taxonomies', [
        'taxonomy' => $taxonomy,
        'type' => $type,
        'value' => $value ?? []
    ])
@endif

@if(($form ?? 'category') == 'tag')
    @livewire('tadcms::component.form-tags', [
        'taxonomy' => $config,
        'value' => $value ?? []
    ])
@endif