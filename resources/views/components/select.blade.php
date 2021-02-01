<div class="form-group col-md-{{ $attributes['width'] ?? '2' }}">
    <label for="id_{{ $name }}">{{ $label }}@isset($attributes['help'])
            <i class="fa fa-question-circle" title="{{ $attributes['help'] }}"></i>
        @endif</label>
    <select name="{{ $name }}" id="id_{{ $name }}" class="{{ $attributes['class'] ?? 'form-control' }}">
        @if(!isset($attributes['nohint']))
            <option value="">Lütfen Seçiniz</option>
        @endif
        @foreach($options as $option)
            <option value="{{ $option[$key] }}" {{ $value == $option[$key] ? 'selected' : '' }}> {{ $option[$optionValue] }}</option>
        @endforeach
    </select>
</div>
