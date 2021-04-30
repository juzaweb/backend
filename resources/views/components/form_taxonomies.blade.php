@if($taxonomy->get('singular') == 'tag')
    @livewire('tadcms::component.form-tags', [
        'taxonomy' => $taxonomy,
    ])
@else
    @livewire('tadcms::component.form-taxonomies', [
        'taxonomy' => $taxonomy,
    ])
@endif