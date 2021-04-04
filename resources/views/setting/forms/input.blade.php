<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    <input type="text" name="{{ $name }}" class="form-control" id="{{ $name ?? '' }}" value="{{ get_config($name) }}" autocomplete="off">
</div>