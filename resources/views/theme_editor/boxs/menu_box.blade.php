@php
    $menu_id = intval(@$option_card[$input['name']]['menu']);
    //$menu = menu_info($menu_id);
$menu = null;
@endphp

<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('app.menu') }}</label>
    <select name="{{ $card['code'] }}[{{ $input['name'] }}][menu]" class="load-menu">
        @if($menu)
            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
        @endif
    </select>
</div>