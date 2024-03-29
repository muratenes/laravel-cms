@foreach($product->languages as $index => $language)
    <div class="tab-pane" id="tab_product_{{ $index }}">
        <div class="row">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>@lang('admin.title')</label>
                    <input type="text" class="form-control" name="title_{{ $language->lang }}" placeholder="@lang('admin.product.title')"
                           value="{{ old("title_{{ $language->lang }", $language['data']['title']) }}">
                </div>
                @if(admin('modules.product.tag'))
                    <div class="form-group col-md-6 key-container">
                        <label for="tags_{{ $language->lang }}">@lang('admin.product.keywords')</label>
                        <select class="form-control" multiple="multiple" id="tags_{{ $language->lang }}" name="tags_{{ $language->lang }}[]">
                            @if($language->data['tags'])
                                @foreach($language['data']['tags'] as $dtag)
                                    <option value="{{ $dtag }}" selected>{{ $dtag }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                @endif
                @if(admin('modules.product.cargo_price'))
                    <div class="form-group col-md-2">
                        <label for="cargo_price">@lang('admin.product.cargo_price')
                            <i class="fa fa-question-circle"
                               title="Lokasyona göre  kargo fiyatı belirleyebilirsiniz. eğer boş bırakılırsa ilgili dilin varsayılan  kargo ücreti uygulanır.Bu lokasyonda ücretsiz olması için 0 giriniz">
                            </i>
                        </label>
                        <input type="number" class="form-control" name="cargo_price_{{ $language->lang }}" placeholder="Kargo Fiyatı" step="any"
                               value="{{ old("cargo_price_$language->lang", $language['data']['cargo_price']) }}">
                    </div>
                @endif

                <div class="form-group col-md-12">
                    <label>@lang('admin.product.short_description')</label>
                    <input type="text" class="form-control" name="spot_{{ $language->lang }}" placeholder="Ürün hakkında kısa açıklama" maxlength="255"
                           value="{{ old("spot_{{ $language->lang }", $language['data']['spot']) }}">
                </div>

                <!-- açıklama --->
                <div class="form-group col-md-8">
                    <div class="box box-primary">
                        <div class="box-header" data-widget="collapse" data-toggle="tooltip">
                            <h3 class="box-title">@lang('admin.product.product_desc')
                                <small>@lang('admin.product.desc_of_product')</small>
                            </h3>
                        </div>
                        <div class="box-body pad">
                             <textarea class="textarea" placeholder="Place some text here" id="editor_lang_{{ $language->lang }}"
                                       style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                       name="desc_{{ $language->lang }}">{{ old('desc_'. $language->lang ,$language['data']['desc'] )}}
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
