@extends('admin.layouts.master')
@section('title','Kampanya detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.campaigns') }}"> Kampanyalar</a>
                    › {{ $entry->title }}
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a type="submit" onclick="document.getElementById('form').submit()" class="btn btn-success btn-sm">Kaydet</a>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Kampanya Detay</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post"
                      action="{{ route('admin.campaigns.save',$entry->id != null ? $entry->id : 0) }}" id="form"
                      enctype="multipart/form-data">
                  @csrf
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="text" class="form-control" name="title" placeholder="kampanya başlık"
                                       required maxlength="50"
                                       value="{{ old('title', $entry->title) }}">
                            </div>

                            <div class="form-group col-md-1">
                                <label for="discount_type">İndirim Tipi</label>
                                <select name="discount_type" class="form-control">
                                    <option value="1" {{ old('discount_type',$entry->discount_type) == 1 ? 'selected' : '' }}>Normal(Tl)</option>
                                    <option value="2" {{ old('discount_type',$entry->discount_type) == 2 ? 'selected' : '' }}>Yüzde</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">İndirim Miktari</label>
                                <input type="number" class="form-control" name="discount_amount" required
                                       placeholder="İndirim Tutarı"
                                       value="{{ old('discount_amount', $entry->discount_amount) }}">
                            </div>


                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Başlangıç Tarihi
                                    <i class="fa fa-question-circle" title="Kampanya başlangıç tarihi geldiğinde kampanya otomatik olarak aktif edilir ve indirimler uygulanır"></i>
                                </label><br>
                                <input class="form-control" type="datetime-local" name="start_date"
                                       @if(!is_null(old('start_date',$entry->start_date)))
                                       value="{{date('Y-m-d', strtotime($entry->start_date)).'T'.date('H:i:s', strtotime($entry->start_date))}}" min="{{date('Y-m-d' .'T'. date('H:i:s'))}}"
                                       @else
                                       value="{{date('Y-m-d').'T'.date('H:i:s')}}"
                                       @endif
                                       id="example-datetime-local-input">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Bitiş Tarihi</label><br>
                                <input class="form-control" type="datetime-local" name="end_date"
                                       @if(!is_null(old('end_date',$entry->end_date)))
                                       value="{{date('Y-m-d', strtotime($entry->end_date)).'T'.date('H:i:s', strtotime($entry->end_date))}}" min="{{date('Y-m-d' .'T'. date('H:i:s'))}}"
                                       @else
                                       value="{{date('Y-m-d').'T'.date('H:i:s')}}"
                                       @endif
                                       id="example-datetime-local-input">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Aktif Mi ?
                                    <i class="fa fa-question-circle" title="İndirimleri hemen uygulamak istiyorsanız aktif edebilirsiniz"></i>
                                </label><br>
                                <input type="checkbox" class="minimal"
                                       name="active" {{ old('active',$entry->active) == 1 ? 'checked': '' }}>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="image">Fotoğraf</label><br>
                                <input type="file" class="form-control" name="image">
                                @if($entry->image)
                                    <span class="help-block"><a
                                            href="{{ imageUrl('public/kampanyalar',$entry->image) }}">{{ $entry->image }}</a></span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Kategoriye göre indirim</label>
                            <select name="categories[]" id="categories" class="form-control" multiple>
                                <option value="">---Kategori Seçiniz --</option>
                                @foreach($categories as $cat)
                                    <option
                                        {{ collect(old('categories',$selected_categories))->contains($cat->id) ? 'selected' : '' }}
                                        value="{{ $cat->id }}">{{ $cat->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-11" id="productSearchContainer" style="display: none">
                            <label for="exampleInputEmail1">Seçili Firmaların Ürünlerinde indirim</label>
                            <select name="companies[]" id="companies" class="form-control" multiple>
                                <option value=""></option>
                                @foreach($companies as $com)
                                    <option
                                        {{  collect(old('companies',$selected_companies))->contains($com->id) ? 'selected' : '' }}
                                        value="{{ $com->id }}">{{ $com->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Min Ürün Tutarı <i class="fa fa-question-circle" title="Kampanya sadece ürün fiyatı belirleyeceğiniz fiyat üzerindeki ürünlerde uygulanır"></i></label>
                            <input type="number" class="form-control" name="min_price" value="{{ old('min_price',$entry->min_price) }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Para Birimi<i class="fa fa-question-circle" title="Kampanya hangi para biriminde uygulanacaksa o seçilmelidir"></i></label>
                            <select name="currency_id" id="" class="form-control" required>
                                <option value="">Para Birimi seçiniz</option>
                                @foreach ($currencies as $currency)
                                    <option {{ $currency[0] == $entry->currency_id ? 'selected' : '' }} value="{{ $currency[0] }}">
                                        {{ $currency[1] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Kampanya Hakkında Yazı</label>
                            <textarea name="spot" id="" cols="30" rows="10" maxlength="250" class="form-control">{{ old('spot',$entry->spot) }}</textarea>
                        </div>
                    </div>


                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (left) -->

    </div>
@endsection
@section("footer")
    <script type="text/javascript">
        $('select[id*="categories"]').select2({
            placeholder: 'Kampanyanın geçerli olacağı kategorileri seçiniz'
        });
        $('select#mySelect2').select2({
            placeholder: 'Kampanyanın geçerli olacağı ürünleri seçmek için arama yapın'
        });
        $('select#companies').select2({
            placeholder: 'Kampanyanın geçerli olacağı firmayı seçiniz'
        });
    </script>
@endsection

