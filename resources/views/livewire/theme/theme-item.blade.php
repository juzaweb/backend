<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="height-200 d-flex flex-column kit__g13__head" wire:loading.delay
             style="background-image: url('{{ $theme['screenshot'] }}')">
        </div>

        <div class="card card-borderless mb-0">
            <div class="card-header border-bottom-0">
                <div class="d-flex">
                    <div class="text-dark text-uppercase font-weight-bold mr-auto">
                        {{ $theme['name'] }}
                    </div>
                    <div class="text-gray-6">
                        @if($isActivated)
                            <button class="btn btn-secondary" disabled> Activated</button>
                        @else
                            <button
                                    class="btn btn-primary"
                                    wire:click="activate"
                                    wire:loading.attr="disabled"
                            ><i class="fa fa-check" wire:loading.class="fa fa-spinner fa-spin"></i> Activate</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
