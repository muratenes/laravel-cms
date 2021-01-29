<div class="form-group col-md-{{ $width }}">
    <label for="{{ $name }}">{{ isset($label) && $label ? $label :  $name }}</label><br>
    <input type="{{ $type }}" class="{{ $class }}" name="{{ $name }}" placeholder="{{ $placeholder ?: $label }}" id="input_{{ $name }}" {{ $attributes }}
    value="{{ old($name, $value) }}"  {{ $type == 'checkbox' ? ($value == 1 ? 'checked': '' ) : '' }}>
    @if($type == 'file')
        <span class="help-block">
            <a href="{{ imageUrl("public/{$attributes['path']}",$value) }}" target="_blank">{{ $value }}</a>
        </span>
    @endif
</div>
