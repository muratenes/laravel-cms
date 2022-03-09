  <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Özellikler <small>Ürüne ait seçili dilde yeni özellikler oluşturabilirsiniz </small></h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-default btn-sm" title="Yeni Özellik Ekle" onclick="addToNewPropertyForLanguage({{ $language->lang }})">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div id="product-feature-container-{{ $language->lang }}">
            @if($language['data']['properties'] and count($language['data']['properties']))
                @foreach($language['data']['properties'] as $i=> $properties)
                    <!-- Attr item -->
                        <div class="box-body product-item-language-{{ $language->lang }}" id="product-property-container-{{$language->lang}}-{{$i}}" data-index="{{ $i }}">
                            <div class="form-group col-md-6">
                                <label>@lang('admin.title')</label>
                                <input type="text" class="form-control" name="properties_{{ $language->lang }}[{{ $i }}][key]" placeholder="Özellik Adı" value="{{$properties['key']}}">
                            </div>
                            <div class="form-group col-md-5">
                                <label>@lang('admin.description')</label>
                                <input type="text" class="form-control" name="properties_{{ $language->lang }}[{{ $i }}][value]" placeholder="Açıklama" value="{{$properties['value'] ?? ''}}">
                            </div>
                            <div class="form-group col-md-1">
                                <label>@lang('admin.delete')</label><br>
                                <a onclick="deleteProductPropertiesByLanguage({{$i}},{{$language->lang}})"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                @endforeach
            @endif
            <!-- ./Attr item -->
            </div>


        </div>
