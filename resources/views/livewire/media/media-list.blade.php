<div wire:init="loadItems" xmlns:wire="http://www.w3.org/1999/xhtml">
    <ul class="media-list">
        @foreach($items as $item)
            @livewire('tadcms::media.media-item', ['item' => $item])
        @endforeach
    </ul>
</div>