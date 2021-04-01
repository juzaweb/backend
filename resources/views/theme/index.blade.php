@extends('tadcms::backend.layout')

@section('content')

    <div class="row mb-2">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                @if(config('tadcms.themes.upload.enabled'))
                    <a href="{{ route('admin.themes.install') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add-new-theme')</a>
                @endif
            </div>
        </div>
    </div>

    <div class="row list-view"></div>

    <template id="theme-template">
        <div class="col-md-4">
            <div class="card">

                <div class="height-200 d-flex flex-column kit__g13__head"
                     style="background-image: url('{thumbnail}')">
                </div>

                <div class="card card-borderless mb-0">
                    <div class="card-header border-bottom-0">
                        <div class="d-flex">
                            <div class="text-dark text-uppercase font-weight-bold mr-auto">
                                {name}
                            </div>
                            <div class="text-gray-6">
                                <button class="btn btn-primary" data-plugin="{plugin}">Activate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script type="text/javascript">
        var listView = new TadList({
            'url': '{{ route('admin.themes.get-data') }}',
            'template': '#theme-template',
            'load_more_scroll': true,
            'page_size': 6,
        });
    </script>

@endsection