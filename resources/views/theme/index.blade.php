@extends('tadcms::layouts.admin')

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
                                <button class="btn btn-primary activate-theme" data-theme="{name}">Activate</button>
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

        $('.list-view').on('click', '.activate-theme', function () {
            let btn = $(this);
            let icon = btn.find('i').attr('class');
            let theme = btn.data('theme');
            if (!theme) {
                return false;
            }

            btn.find('i').attr('class', 'fa fa-spinner fa-spin');
            btn.prop("disabled", true);

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.themes.activate') }}',
                dataType: 'json',
                data: {
                    'theme': theme,
                }
            }).done(function(response) {
                btn.find('i').attr('class', icon);
                btn.prop("disabled", false);

                if (response.status === false) {
                    show_message(response);
                    return false;
                }

                window.location="";
                return false;
            }).fail(function(response) {
                btn.find('i').attr('class', icon);
                btn.prop("disabled", false);

                show_message(response);
                return false;
            });
        });
    </script>

@endsection