@foreach($item->subAttributes as $index=>$subAttribute)
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_sub_attribute_default_language_{{ $index }}" data-toggle="tab">
                        <img src="{{ langIcon(defaultLangID()) }}"/>
                    </a>
                </li>
                @foreach($subAttribute->descriptions as $subIndex => $description)
                    <li>
                        <a href="#tab_sub_attribute_{{ $subIndex }}_{{ $description->id }}" data-toggle="tab">
                            <img src="{{ langIcon($description->lang) }}"/>
                        </a>
                    </li>
                @endforeach
                <li class="pull-right">
                    <a href="javascript:void(0);" onclick="deleteProductSubAttributeFromDB({{$subAttribute->id}},{{$index}})"><i
                            class="fa fa-trash text-red"></i></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_sub_attribute_default_language_{{ $index }}">
                    <div class="row productSubAttribute" data-index="{{$index}}">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Başlık</label>
                            <input type="hidden" name="main_product_sub_attribute_id_{{$index}}" value="{{$subAttribute->id}}">
                            <input type="text" class="form-control" name="main_product_sub_attribute_title_{{$index}}"
                                   value="{{ $subAttribute->title}}">
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
                @foreach($subAttribute->descriptions as $descIndex => $description)
                    <div class="tab-pane" id="tab_sub_attribute_{{ $descIndex  }}_{{ $description->id }}">
                        <div class="row productSubAttributeDescription" data-index="{{$descIndex}}">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="hidden" name="product_sub_attribute_id_{{ $index }}_{{ $descIndex }}" value="{{$subAttribute->id}}">
                                <input type="hidden" name="product_sub_attribute_lang_{{$index }}_{{$descIndex}}" value="{{$description->lang }}">
                                <input type="text" class="form-control" name="product_sub_attribute_title_{{ $index }}_{{$descIndex}}"
                                       value="{{ $description->title}}">
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
@endforeach
