<div class="form-group col-md-{{ $width }}">
    <label for="{{ $name }}">{{ isset($label) && $label ? $label :  $name }}</label>
    <input type="text" class="{{ $class }}" name="title" placeholder="{{ $placeholder ?: $label }}" required maxlength="50" id="input_{{ $name }}"
           value="{{ old($name, $value) }}">
</div>
