<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Özellikler <small>Ürüne ait yeni özellikler oluşturabilirsiniz</small></h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-default btn-sm" title="Yeni Özellik Ekle" onclick="addToNewProperty()">
                        <i class="fa fa-plus"></i>
                    </button>
{{--                    <button type="button" title="varsayılanları koy" onclick="cloneDefaultProps()">--}}
{{--                        <i class="fa fa-copy"></i>--}}
{{--                    </button>--}}
                </div>
            </div>
            <div id="containerOzellikler">
            @if(@count($product->properties) > 0)
                @foreach($product->properties as $i=>$properties)
                    <!-- Attr item -->
                        <div class="box-body itemOzellikler" id="productPropertyContainer{{$i}}" data-index="{{ $i }}">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="text" class="form-control" name="properties[{{ $i }}][key]" placeholder="Özellik Adı" value="{{$properties['key']}}">
                            </div>
                            <div class="form-group col-md-5">
                                <label>Açıklama</label>
                                <input type="text" class="form-control" name="properties[{{ $i }}][value]" placeholder="Açıklama" value="{{$properties['value'] ?? ''}}">
                            </div>
                            <div class="form-group col-md-1">
                                <label>Sil</label><br>
                                <a onclick="deleteProductProperties({{$i}})"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                @endforeach
            @endif
            <!-- ./Attr item -->
            </div>


        </div>
    </div>
</div>
