<div class="form-group">
    <label class="col-form-label" for="{{ $name }}">{{ $title }}</label>
    <input type="text" name="{{ $name }}" class="form-control" id="{{ $name ?? '' }}" value="{{ get_config($name, $default ?? '') }}" autocomplete="off">
</div>