@extends('admin.layouts.master')
@section('title','Kupon detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.coupons') }}"> Kuponlar</a>
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
                    <h3 class="box-title">Kupon Detay</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.coupons.save',$entry->id != null ? $entry->id : 0) }}" id="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Kod</label>
                                <input type="text" class="form-control" name="code" placeholder="Kod" required maxlength="20"
                                       value="{{ old('code', $entry->code) }}">
                            </div>

                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Adet</label>
                                <input type="number" class="form-control" name="qty" placeholder="Adet"
                                       value="{{ old('qty', $entry->qty) }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">İndirim Tutarı</label>
                                <input type="number" class="form-control" name="discount_price" placeholder="İndirim Tutarı"
                                       value="{{ old('discount_price', $entry->discount_price) }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Minumum Sepet Tutarı <i class="fa fa-question-circle" title="Kuponu uygulamak için minumum sepet tutarı"></i></label>
                                <input type="number" class="form-control" name="min_basket_price" placeholder="Minumum Sepet Tutarı"
                                       value="{{ old('min_basket_price', $entry->min_basket_price) }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Başlangıç Tarihi</label><br>
                                <input class="form-control" type="datetime-local" name="start_date"
                                       value="{{date('Y-m-d', strtotime($entry->start_date))}}T{{date('H:i:s', strtotime($entry->start_date))}}"
                                       id="example-datetime-local-input">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Bitiş Tarihi</label><br>
                                <input class="form-control" type="datetime-local" name="end_date"
                                       value="{{date('Y-m-d', strtotime($entry->end_date))}}T{{date('H:i:s', strtotime($entry->end_date))}}" id="example-datetime-local-input">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" name="active" {{ old('active',$entry->active) == 1 ? 'checked': '' }}>
                            </div>
                            <!-- currencies -->
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

                            <div class="form-group col-md-10">
                                <label for="exampleInputEmail1">Kategoriler
                                    <i class="fa fa-question-circle" title="Kupon hangi kategorilerde geçerli olacak"></i>
                                </label>
                                <select name="categories[]" id="categories" class="form-control" multiple required>
                                    <option value="">---Kategori Seçiniz --</option>
                                    @foreach($categories as $cat)
                                        <option {{ collect(old('categories',$selected_categories))->contains($cat->id) ? 'selected' : '' }}
                                                value="{{ $cat->id }}">{{ $cat->title  }} {{ $cat->parent_category ? "({$cat->parent_category->title})" : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
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
@section('footer')
    <script>
        $('select[id*="categories"]').select2({
            placeholder: 'Lütfen kategori seçiniz'
        });
    </script>
@endsection
