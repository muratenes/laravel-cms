<div class="form-group col-md-{{ $attributes['width'] ?? '2' }}">
    <label for="id_{{ $name }}" @isset($attributes['horizontal']) class='control-label col-sm-2' @endisset>{{ $label }}@isset($attributes['help'])
            <i class="fa fa-question-circle" title="{{ $attributes['help'] }}"></i>
        @endif</label>
    @isset($attributes['horizontal'])
        <div class="col-sm-10">
            @else
                <br>
            @endisset
            <select name="{{ $name }}" id="id_{{ $name }}" class="{{ $attributes['class'] ?? 'form-control' }}" {{ $attributes }}>
                @if(!isset($attributes['nohint']))
                    <option value="">Lütfen Seçiniz</option>
                @endif
                @foreach($options as $option)
                    @isset ($attributes['nokey'])
                        <option value="{{ $option }}" {{ $value == $option ? 'selected' : '' }}> {{ $option }}</option>
                    @else
                        <option value="{{ $option[$key] }}" {{ $value == $option[$key] ? 'selected' : '' }}> {{ $option[$optionValue] }}</option>
                    @endisset

                @endforeach
            </select>
            @isset($attributes['horizontal'])
        </div>
    @endisset
</div>
