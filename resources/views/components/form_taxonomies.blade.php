@if(($form ?? 'category') == 'category')
    @livewire('tadcms::component.form-taxonomies', [
        'label' => $label,
        'taxonomy' => $taxonomy,
        'type' => $type,
        'value' => $value ?? []
    ])
@endif

@if(($form ?? 'category') == 'tag')
    @livewire('tadcms::component.form-tags', [
        'label' => $label,
        'taxonomy' => $taxonomy,
        'type' => $type,
        'value' => $value ?? []
    ])
@endif