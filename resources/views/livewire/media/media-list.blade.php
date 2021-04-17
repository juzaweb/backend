<div wire:init="loadItems" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="row">
        @foreach($items as $item)
            <div class="col-md-3">
                @livewire('tadcms::media.media-item', ['item' => $item])
            </div>
        @endforeach
    </div>
</div>