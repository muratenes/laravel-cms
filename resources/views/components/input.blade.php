<div class="form-group col-md-{{ $width }}">
    <label for="{{ $name }}">{{ isset($label) && $label ? $label :  $name }}</label>
    <input type="text" class="{{ $class }}" name="title" placeholder="{{ $placeholder ?: $label }}"  id="input_{{ $name }}" {{ $attributes }}
           value="{{ old($name, $value) }}">
</div>
