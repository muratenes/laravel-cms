<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{$product->title}} | {{ $site->title }}</title>

    <meta name="description"
          content="{{ is_null($product->spot) ? $site->title.' sayesinde '. $product->categories[0]->title .' kategorisinde bulunan ' . $product->title .' ürünlerine indirimlerle sahip  olabilirsiniz' : $product->spot }}"/>
    <meta name="keywords" content="{{ $product->categories[0]->title.','.@$product->categories[1]->title.','.@$product->categories[2]->title }}"/>
    <meta property="og:type" content="product"/>
    <meta property="og:url" content="{{ route('productDetail',$product->slug)  }}"/>
    <meta property="og:title" content="{{ $product->title .' | '. $site->title }}"/>
    <meta name="og:description" content="{{ $product->title }} {{ $product->spot }}"/>
    <meta property="og:image" content="{{ $site->domain }}/uploads/products/{{ $product->image }}"/>
    <meta name="twitter:card" content="product"/>
    <meta name="twitter:site" content="@siteadi"/>
    <meta name="twitter:creator" content="@siteadi"/>
    <meta name="twitter:title" content="{{ $product->title .' | '. $site->title }}"/>
    <meta name="twitter:description" content="{{ $product->title }} {{ $product->spot }}"/>
    <meta name="twitter:image:src" content="{{ $site->domain }}/uploads/products/{{ $product->image }}"/>
    <meta name="twitter:data1" content="{{ !is_null($product->discount_price) ? $product->discount_price : $product->price }}"/>
    <meta name="twitter:label1" content="{{ $site->title }} Fiyati"/>
    <meta name="twitter:domain" content="{{$site->domain}}"/>
    <link rel="canonical" href="{{ route('productDetail',$product->slug)  }}"/>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "{{ $product->title }}",
      "image": "{{ $site->domain }}/uploads/products/{{ $product->image }}",
      "description": "{{ is_null($product->spot) ? $site->title.' sayesinde '. $product->categories[0]->title .' kategorisinde bulunan ' . $product->title .' ürünlerine indirimlerle sahip  olabilirsiniz' : $product->spot }}",
      "brand": "{{ $product->info->brand->title }}",
      "offers": {
        "@type": "Offer",
        "url": "{{ route('productDetail',$product->slug)  }}",
        "priceCurrency": "TRY",
        "price": "{{ $product->price  }}",
        "availability": "https://schema.org/InStock",
        "itemCondition": "https://schema.org/NewCondition"
      }
    }




    </script>
</head>
<body>
<div class="product-single-container product-single-default product-quick-view container">
    <div class="row">
        <div class="col-lg-6 col-md-6 product-single-gallery">
            <div class="product-slider-container product-item">
                <div class="product-single-carousel owl-carousel owl-theme">
                    <div class="product-item">
                        <img class="product-single-image" src="{{ config('constants.image_paths.product_image_folder_path').$product->image }}"
                             data-zoom-image="{{ config('constants.image_paths.product_image_folder_path').$product->image }}"/>
                    </div>
                    @foreach($product->images as $image)
                        <div class="product-item">
                            <img class="product-single-image" src="{{ config('constants.image_paths.product_gallery_folder_path').$image->image }}"
                                 data-zoom-image="{{ config('constants.image_paths.product_gallery_folder_path').$image->image }}"/>
                        </div>
                    @endforeach
                </div>
                <!-- End .product-single-carousel -->
            </div>
            <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
                <div class="col-3 owl-dot">
                    <img src="{{ config('constants.image_paths.product_image_folder_path').$product->image }}"/>
                </div>
                @foreach($product->images as $image)
                    <div class="col-3 owl-dot">
                        <img src="{{ config('constants.image_paths.product_gallery_folder_path').$image->image }}"/>
                    </div>
                @endforeach
            </div>
        </div><!-- End .col-lg-7 -->

        <div class="col-lg-6 col-md-6">
            <input type="hidden" id="productDefaultPrice" value="{{ $discount !== null ? $discount : $product->price }}">
            <input type="hidden" id="productDefaultQty" value="{{ $product->qty }}">
            <div class="product-single-details">
                <h1 class="product-title">{{$product->title}}</h1>

                <div class="ratings-container">
                    <a href="#" class="rating-link">( 6 Reviews ) | </a><span class="help-block text-sm small">Stok :<span class="qty">{{$product->qty}}</span> </span>
                </div><!-- End .product-container -->

                <div class="price-box">
                    @if($discount)
                        <span class="old-price"><span>{{ $product->price }}</span> ₺</span>
                        <span class="product-price"><span class="price">{{ $product->discount_price }}</span> ₺</span>
                    @else
                        <span class="product-price"><span class="price">{{ $product->price }}</span> ₺</span>
                    @endif
                </div><!-- End .price-box -->

                <div class="product-desc">
                    <p>{!! substr($product->desc,0,150) !!}</p>
                    <p></p>
                </div><!-- End .product-desc -->

                <div class="product-filters-container" id="productDetailsContainer">
                    @foreach($product->detail as $index => $detail)
                        <tr>
                            <input type="hidden" name="attributeTitle{{$index}}" value="{{ $detail->attribute->title }}">{{ $detail->attribute->title }}
                            <td><select name="subAttributeTitle{{$index}}" class="form-control productVariantAttribute" id="subAttributeTitle{{$index}}"
                                        onchange="productVariantAttributeOnChange({{$product->id}});" required>
                                    <option value="">--Özellik Seçiniz--</option>
                                    @foreach($detail->subDetails as $subDetail)
                                        <option data-value="{{ $subDetail->parentSubAttribute->id }}"
                                                value="{{  $subDetail->parentSubAttribute->id }}|{{  $subDetail->parentSubAttribute->title }}|{{  $subDetail->parentDetail->attribute->title }}">{{ $subDetail->parentSubAttribute->title }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </div>

                <div class="product-action">
                    <div class="product-single-qty">
                        <input class="horizontal-quantity form-control" name="qty" id="qty" type="text" dt-max="{{$product->qty}}">
                    </div><!-- End .product-single-qty -->
                    <a href="javascript:void(0);" onclick="return addItemToBasket({{$product->id}})" class="paction add-cart" title="Sepete ekle">
                        <span>Sepete ekle</span>
                    </a>
                    <a href="#" class="paction add-wishlist" title="Add to Wishlist">
                        <span>Favorilerime Ekle</span>
                    </a>
                </div><!-- End .product-action -->

                <div class="product-single-share">
                    <label>Share:</label>
                    <!-- www.addthis.com share plugin-->
                    <div class="addthis_inline_share_toolbox"></div>
                </div><!-- End .product single-share -->
            </div><!-- End .product-single-details -->
        </div><!-- End .col-lg-5 -->
    </div><!-- End .row -->
</div><!-- End .product-single-container -->
</body>
</html>


