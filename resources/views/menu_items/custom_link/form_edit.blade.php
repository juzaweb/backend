<div class="form-group mb-0">
    <label class="mb-0">@lang('tadcms::app.link-text')</label>
    <input type="text" name="text" class="form-control is-data-text" value="{{ $data->get('text') }}" autocomplete="off" required>
</div>

<div class="form-group mb-0">
    <label class=" mb-0">@lang('tadcms::app.url')</label>
    <input type="text" name="url" class="form-control" placeholder="http://" value="{{ $data->get('url') }}" autocomplete="off" required>
</div>