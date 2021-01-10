<aside class="sidebar-shop col-lg-3 order-lg-first">
    <div class="widget">
        <h3 class="widget-title">
            <a data-toggle="collapse" href="#widget-body-1" role="button" aria-expanded="true" aria-controls="widget-body-1">Kategoriler</a>
        </h3>
        <div class="collapse show" id="widget-body-1">
            <div class="widget-body">
                <ul class="cat-list">
                    <li><a href="{{route('searchView')}}?q={{request('q')}}&cat=">Tüm Kategoriler</a></li>
                    @foreach($data['categories'] as $cat)
                        <li><a href="{{route('searchView')}}?q={{request('q')}}&cat={{$cat->id}}">{{$cat->title}}</a></li>
                    @endforeach
                </ul>
            </div><!-- End .widget-body -->
        </div><!-- End .collapse -->
    </div><!-- End .widget -->
    <div class="sidebar-wrapper">
        @foreach($data['attributes'] as $attribute)
            <div class="widget" id="attrFilterByID{{ $attribute->id}}" name="{{ $attribute->id}}">
                <h3 class="widget-title">
                    <a data-toggle="collapse" href="#widget-body-{{$attribute->id}}" role="button" aria-expanded="true"
                       aria-controls="widget-body-{{$attribute->id}}">{{ $attribute->title }}</a>
                </h3>

                <div class="collapse show" id="widget-body-{{$attribute->id}}">
                    <div class="widget-body">
                        <ul class="config-size-list">
                            @foreach($data['subAttributes'] as $sub)
                                @if($sub->parent_attribute === $attribute->id)
                                    <li id="variantContainer{{$sub->id}}">
                                        <a href="javascript:void(0)" id="varyant-{{ $sub->id }}" name="{{ $sub->id }}" value="{{ $sub->id }}"
                                           data-model-name="{{ $attribute->id }}">{{$sub->title}}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div><!-- End .widget-body -->
                </div><!-- End .collapse -->
            </div><!-- End .widget -->
        @endforeach

        <div class="widget" id="brandWidgetContainer">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-body-marka" role="button" aria-expanded="true" aria-controls="widget-body-4">Marka</a>
            </h3>

            <div class="collapse show" id="widget-body-marka">
                <div class="widget-body">
                    <ul class="cat-list" id="productBrandUl">
                        @foreach($data['brands'] as $brand)
                            <li data-value="{{$brand['id']}}" id="brandId{{$brand['id']}}"><a href="javascript:void(0);" data-value="{{$brand['id']}}">{{ $brand['title'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @include('site.urun.partials.bestSellersSidebar3items')
    </div>
</aside>
