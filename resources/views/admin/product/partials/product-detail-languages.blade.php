@foreach($product->descriptions as $index => $description)
    <div class="tab-pane" id="tab_product_{{ $index }}">
        <div class="row">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Başlık</label>
                    <input type="text" class="form-control" name="title_{{ $description->lang }}" placeholder="Ürün başlık"
                           value="{{ old("title_{{ $description->lang }", $description->title) }}">
                </div>
                @if(config('admin.product.use_tags'))
                    <div class="form-group col-md-6 key-container">
                        <label for="tags_{{ $description->lang }}">Kelimeler(Tags)</label>
                        <select class="form-control" multiple="multiple" id="tags_{{ $description->lang }}" name="tags_{{ $description->lang }}[]">
                            @if($description->tags)
                                @foreach($description->tags as $dtag)
                                    <option value="{{ $dtag }}" selected>{{ $dtag }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                @endif
                @if(config('admin.product.cargo_price'))
                    <div class="form-group col-md-2">
                        <label for="cargo_price">Kargo Fiyatı
                            <i class="fa fa-question-circle"
                               title="Lokasyona göre  kargo fiyatı belirleyebilirsiniz. eğer boş bırakılırsa ilgili dilin varsayılan  kargo ücreti uygulanır.Bu lokasyonda ücretsiz olması için 0 giriniz">
                            </i>
                        </label>
                        <input type="number" class="form-control" name="cargo_price_{{ $description->lang }}" placeholder="Kargo Fiyatı"
                               value="{{ old("cargo_price_$description->lang", $description->cargo_price) }}">
                    </div>
                @endif

                <div class="form-group col-md-12">
                    <label>Kısa Açıklama</label>
                    <input type="text" class="form-control" name="spot_{{ $description->lang }}" placeholder="Ürün hakkında kısa açıklama" maxlength="255"
                           value="{{ old("spot_{{ $description->lang }", $description->spot) }}">
                </div>

                <!-- açıklama --->
                <div class="form-group col-md-8">
                    <div class="box box-primary">
                        <div class="box-header" data-widget="collapse" data-toggle="tooltip">
                            <h3 class="box-title">Ürün Açıklama
                                <small>Ürün hakkında açıklama</small>
                            </h3>
                        </div>
                        <div class="box-body pad">
                                                     <textarea class="textarea" placeholder="Place some text here" id="editor_lang_{{ $description->lang }}"
                                                               style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                                               name="desc_{{ $description->lang }}">{{ old('desc_'. $description->lang ,$description->desc )}}
                                                     </textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    @include('admin.product.partials.product-features-for-language')
                </div>

            </div>
        </div>
    </div>
@endforeach
