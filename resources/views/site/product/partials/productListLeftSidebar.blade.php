<aside class="sidebar-shop col-lg-3 order-lg-first">
    <div class="sidebar-wrapper">
        <div class="widget">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-body-cats" role="button" aria-expanded="true" aria-controls="widget-body-1">{{$category->title}}</a>
            </h3>
            <div class="collapse show" id="widget-body-cats">
                <div class="widget-body">
                    @if(count($data['subCategories']) > 0)
                        <ul class="cat-list">
                            @foreach($data['subCategories'] as $sub_cat)
                                <li><a href="{{route('category.detail',$sub_cat->slug)}}">{{$sub_cat->title}}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div><!-- End .widget-body -->
            </div><!-- End .collapse -->
        </div><!-- End .widget -->
        @foreach($data['attributes'] as $attribute)
            <div class="widget" id="attrFilterByID{{ $attribute->id}}" name="{{ $attribute->id}}">
                <h3 class="widget-title">
                    <a data-toggle="collapse" href="#widget-body-{{$attribute->id}}" role="button" aria-expanded="true"
                       aria-controls="widget-body-{{$attribute->id}}">{{ $attribute->title_lang }}</a>
                </h3>

                <div class="collapse show" id="widget-body-{{$attribute->id}}">
                    <div class="widget-body">
                        <ul class="config-size-list">
                            @foreach($data['subAttributes'] as $sub)
                                @if($sub->parent_attribute === $attribute->id)
                                    <li id="variantContainer{{$sub->id}}">
                                        <a href="javascript:void(0)" id="varyant-{{ $sub->id }}" name="{{ $sub->id }}" value="{{ $sub->id }}"
                                           data-model-name="{{ $attribute->id }}">{{$sub->title_lang}}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div><!-- End .widget-body -->
                </div><!-- End .collapse -->
            </div><!-- End .widget -->
        @endforeach
        @if(count($data['brands']) > 0)
            <div class="widget">
                <h3 class="widget-title">
                    <a data-toggle="collapse" href="#widget-body-4" role="button" aria-expanded="true" aria-controls="widget-body-4">Marka</a>
                </h3>
                <div class="collapse show" id="widget-body-4">
                    <div class="widget-body">
                        <ul class="cat-list" id="productBrandUl">
                            @foreach($data['brands'] as $brand)
                                <li data-value="{{$brand->id}}" id="brandId{{$brand->id}}"><a href="javascript:void(0);" data-value="{{$brand->id}}">{{ $brand->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        @include('site.product.partials.bestSellersSidebar3items')
        <div class="widget widget-block">
            <h3 class="widget-title">{{$category->title}}</h3>
            <h5>
                @foreach($category->sub_categories as $sub)
                    {{$sub->title}}{{ !$loop->last ? ',':''  }}
                @endforeach
            </h5>
            <p>{{ $category->spot }} </p>
        </div>
    </div>
</aside>
