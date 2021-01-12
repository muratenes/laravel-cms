<div class="product-single-tabs">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content"
               aria-selected="true">Açıklama</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab" aria-controls="product-reviews-content"
               aria-selected="false">Yorumlar</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
            <div class="product-desc-content">
                {!! $product->desc !!}
            </div><!-- End .product-desc-content -->
        </div><!-- End .tab-pane -->
        <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
            <div class="product-reviews-content">
                <div class="collateral-box">
                    <ul>
                        <li>Bu ürüne toplamda {{ $product->comments_count }} yorum yapılmıştır. @auth()
                                <a href="#makeNewComment">yorum yap</a>
                            @elseauth()
                                Yorum yapmak için <a href="{{ route('user.login') }}">giriş</a> yapmalısın
                            @endauth</li>

                    </ul>
                </div><!-- End .collateral-box -->

                <div class="comment-respond">
                    <h3>Yorumlar</h3>
                    @foreach($comments as $com)
                        <div class="entry-author">
                            <figure>
                                <a href="#">
                                    <img src="/uploads/site/user.jpg" alt="{{$site->title}}">
                                </a>
                            </figure>
                            <div class="author-content">
                                <h4><a href="#">{{$com->user->full_name }}</a></h4>
                                {{ $com->message }}
                            </div>
                        </div>
                    @endforeach
                    @auth()
                        <div id="makeNewComment">
                            <form action="{{ route('product.comments.add',['product' => $product->id]) }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_slug" value="{{ $product->slug }}">
                                <div class="form-group required-field">
                                    <label>Yorumunuz</label>
                                    <textarea cols="30" rows="1" class="form-control" required="" name="message" maxlength="255"></textarea>
                                </div>

                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary">Gönder</button>
                                </div><!-- End .form-footer -->
                            </form>
                        </div>
                    @elseauth()
                        <p>Yorum yapmak için giriş yapmalısınız</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
