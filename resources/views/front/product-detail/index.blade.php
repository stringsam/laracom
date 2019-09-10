@extends('front.layout.master')

@section('body')

<section class="breadcrumb-area breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner"><!-- breadcrumb inner -->
                    <div class="left-content-area"><!-- left content area -->
                        <h1 class="title">Product Details</h1>
                    </div><!-- //. left content area -->
                    <div class="right-content-area">
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li>Product Details</li>
                        </ul>
                    </div>
                </div><!-- //. breadcrumb inner -->
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb area end -->

<!-- product details content area  start -->
<div class="product-details-content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="left-content-area"><!-- left content area -->
                    <div class="product-details-slider" id="product-details-slider" data-slider-id="1">
                        @if($product->getFirstMediaUrl('cover'))
                        <div class="single-product-thumb">
                            <img src="{{ $product->getFirstMediaUrl('cover', 'product_detail') }}" alt="product details image">
                        </div>
                        @endif
                        @foreach($product->getMedia('images') as $media)
                        <div class="single-product-thumb">
                            <img src="{{ $media->getUrl('product_detail') }}" alt="product details image">
                        </div>
                        @endforeach
                        @foreach($product->attributes as $attribute)
                            @if($attribute->getFirstMediaUrl('valueCover', 'cover_detail'))
                                <div class="single-product-thumb">
                                    <img src="{{ $attribute->getFirstMediaUrl('valueCover', 'cover_detail') }}" alt="product details image">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <ul class="owl-thumbs product-deails-thumb" data-slider-id="1">
                        @if($product->getFirstMediaUrl('cover'))
                        <li class="owl-thumb-item">
                            <img src="{{ $product->getFirstMediaUrl('cover', 'product_detail_thumb') }}" alt="product details thumb">
                        </li>
                        @endif
                        @foreach($product->getMedia('images') as $media)
                        <li class="owl-thumb-item">
                            <img src="{{ $media->getUrl('product_detail_thumb') }}" alt="product details thumb">
                        </li>
                        @endforeach
                        @foreach($product->attributes as $attribute)
                            @if($attribute->getFirstMediaUrl('valueCover', 'cover_detail_thumb'))
                                <li class="owl-thumb-item">
                                    <img src="{{ $attribute->getFirstMediaUrl('valueCover', 'cover_detail_thumb') }}" alt="product details thumb">
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div><!-- //.left content area -->
            </div>
            <div class="col-lg-6">
                <div class="right-content-area"><!-- right content area -->
                    {{--<div class="top-content">--}}
                        {{--<ul class="review">--}}
                            {{--<li><i class="fas fa-star"></i></li>--}}
                            {{--<li><i class="fas fa-star"></i></li>--}}
                            {{--<li><i class="fas fa-star"></i></li>--}}
                            {{--<li><i class="fas fa-star-half-alt"></i></li>--}}
                            {{--<li><i class="far fa-star"></i></li>--}}
                            {{--<li class="reviewes">23 <small>reviews</small> </li>--}}
                        {{--</ul>--}}
                        {{--<span class="orders">Orders (200+)</span>--}}
                    {{--</div>--}}
                    {{--{{ dd($product) }}--}}
                    <div class="bottom-content">
                        @foreach($product->categories as $category)
                        <span class="cat">{{ $category->name }}</span>
                        @endforeach
                        <h3 class="title">{{ $product->name }}</h3>
                        <div class="price-area">
                            <div class="left">
                                <span class="sprice">{{ $product->discounted_price ? $product->discounted_price : $product->price }}</span>

                                @if($product->discounted_price)
                                    <span class="dprice"><del>{{ $product->price }}</del></span>
                                @endif
                            </div>
                            {{--<div class="right">--}}
                                {{--<a href="#" class="size">size chart</a>--}}
                            {{--</div>--}}
                        </div>
                        <ul class="product-spec">
                            <li>Brands:  <span class="right">Hewlett-Packard </span></li>
                            <li>{{ __('Kód') }}: <span class="right">{{ $product->sku }}</span></li>
                            {{--<li>Reward Points:  <span class="right">100 </span></li>--}}
                            <li>{{ __('Stav: ') }}:
                                @if($product->quantity > 0)
                                <span class="right base-color">{{ __('Na sklade') }} </span>
                                @else
                                <span class="right">{{ __('Vypredané') }} </span>
                                @endif
                            </li>

                        </ul>

                        <product-detail-form @updated-cart="updateCart" :product="{{ $product->id }}" :url="'{{ route('cart.store') }}'" inline-template>
                            <div>
                                <div class="pdescription">
                                    <h4 class="title">{{ __('Popis') }}</h4>
                                    <p>{!! $product->description !!}</p>
                                    @include('front.product-detail.partials.combinations')
                                </div>
                                <div class="paction">
                                    <div class="qty">
                                        <ul>
                                            <li><span class="qtminus" @click="quantity--"><i class="fas fa-minus"></i></span></li>
                                            <li><span class="qttotal">@{{ quantity }}</span></li>
                                            <li><span class="qtplus" @click="quantity++"><i class="fas fa-plus"></i></span></li>
                                        </ul>
                                    </div>
                                    <ul class="activities">
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-hourglass"></i></a></li>
                                        <li><a href="#"><i class="fas fa-share-square"></i></a></li>
                                    </ul>
                                    <div class="btn-wrapper">
                                        <a href="#" class="boxed-btn addtocart" data-product-id="{{ $product->id }}" @click="addToCart">{{ __('Do košíka') }}</a>
                                    </div>
                                </div>
                            </div>
                        </product-detail-form>
                    </div>
                </div><!-- //. right content area -->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="product-details-area">
                    <div class="product-details-tab-nav">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="item-review-tab" data-toggle="tab" href="#item_review" role="tab" aria-controls="item_review" aria-selected="true">{{ __('Vlastnosti produktu') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="descr-tab" data-toggle="tab" href="#descr" role="tab" aria-controls="descr" aria-selected="false">{{ __('Popis') }}</a>
                            </li>
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link" id="method-tab" data-toggle="tab" href="#method" role="tab" aria-controls="method" aria-selected="false">Features</a>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                    <div class="tab-content" >
                        <div class="tab-pane fade show active" id="item_review" role="tabpanel" aria-labelledby="item-review-tab">
                            <div class="item_review_content">
                                <h4 class="title">Technical Specifications</h4>
                                <ul class="product-specification"><!-- product specification -->
                                    @if($product->featureValues)
                                        @foreach($product->featureValues as $featureValue)
                                        <li>
                                            <div class="single-spec"><!-- single specification -->
                                                <span class="heading">{{ $featureValue->getValueAttribute() }}</span>
                                                <span class="details">{{ $featureValue->feature()->first()->title }}</span>
                                            </div>
                                        </li>
                                        @endforeach
                                    @endif
                                </ul><!-- //.product specification -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="descr" role="tabpanel" aria-labelledby="descr-tab">
                            <div class="descr-tab-content">
                                <h4 class="title">{{ __('Popis produktu') }}</h4>
                                {!! $product->description !!}
                            </div>
                        </div>
                        {{--<div class="tab-pane fade" id="method" role="tabpanel" aria-labelledby="method-tab">--}}
                            {{--<div class="more-feature-content">--}}
                                {{--<h4 class="title">More Features</h4>--}}
                                {{--<div class="feature-list-wrapper">--}}
                                    {{--<div class="row">--}}
                                        {{--<div class="col-lg-3 col-md-6">--}}
                                            {{--<ul class="features-list">--}}
                                                {{--<li><i class="fas fa-check"></i> 24/7 Online Support</li>--}}
                                                {{--<li><i class="fas fa-check"></i> 24/7 Online Support</li>--}}
                                                {{--<li><i class="fas fa-check"></i> 24/7 Online Support</li>--}}
                                                {{--<li><i class="fas fa-check"></i> 24/7 Online Support</li>--}}
                                            {{--</ul>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-lg-3 col-md-6">--}}
                                            {{--<ul class="features-list">--}}
                                                {{--<li><i class="fas fa-check"></i> Unlimited Features</li>--}}
                                                {{--<li><i class="fas fa-check"></i> Unlimited Features</li>--}}
                                                {{--<li><i class="fas fa-check"></i> Unlimited Features</li>--}}
                                                {{--<li><i class="fas fa-check"></i> Unlimited Features</li>--}}
                                            {{--</ul>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-lg-3 col-md-6">--}}
                                            {{--<ul class="features-list">--}}
                                                {{--<li><i class="fas fa-check"></i> 100% Pure cotton</li>--}}
                                                {{--<li><i class="fas fa-check"></i> 100% Pure cotton</li>--}}
                                                {{--<li><i class="fas fa-check"></i> 100% Pure cotton</li>--}}
                                                {{--<li><i class="fas fa-check"></i> 100% Pure cotton</li>--}}
                                            {{--</ul>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-lg-3 col-md-6">--}}
                                            {{--<ul class="features-list">--}}
                                                {{--<li><i class="fas fa-check"></i> Simple and easy</li>--}}
                                                {{--<li><i class="fas fa-check"></i> Simple and easy</li>--}}
                                                {{--<li><i class="fas fa-check"></i> Simple and easy</li>--}}
                                                {{--<li><i class="fas fa-check"></i> Simple and easy</li>--}}
                                            {{--</ul>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<p>Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncove--}}
                                    {{--many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour--}}
                                    {{--and the like) Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum--}}
                                    {{--will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose--}}
                                    {{--(injected humour and the like)..</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product details content area end -->
<!-- recently added start -->
<div class="recently-added-area product-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="recently-added-nav-menu"><!-- recently added nav menu -->
                    <ul>
                        <li>recently added</li>
                    </ul>
                </div><!-- //.recently added nav menu -->
            </div>
            <div class="col-lg-12">
                <div class="recently-added-carousel" id="recently-added-carousel"><!-- recently added carousel -->
                    <div class="single-new-collection-item">
                        <div class="thumb">
                            <img src="assets/img/new-collections/09.jpg" alt="product image">
                            <div class="hover">
                                <a href="#" class="addtocart">Add to cart</a>
                            </div>
                        </div>
                        <div class="content">
                            <a href="#" class="category">accesories</a>
                            <h4 class="title">Milo Hoverboard</h4>
                            <div class="price"><span class="sprice">$7.00</span> <del class="dprice">$42.00</del></div>
                        </div>
                    </div>
                    <div class="single-new-collection-item">
                        <div class="thumb">
                            <img src="assets/img/new-collections/10.jpg" alt="product image">
                            <div class="hover">
                                <a href="#" class="addtocart">Add to cart</a>
                            </div>
                        </div>
                        <div class="content">
                            <a href="#" class="category">Bike</a>
                            <h4 class="title">Dart Moto Bike</h4>
                            <div class="price"><span class="sprice">$30.00</span> <del class="dprice">$45.00</del></div>
                        </div>
                    </div>
                    <div class="single-new-collection-item">
                        <div class="thumb">
                            <img src="assets/img/new-collections/11.jpg" alt="product image">
                            <div class="hover">
                                <a href="#" class="addtocart">Add to cart</a>
                            </div>
                        </div>
                        <div class="content">
                            <a href="#" class="category">cycle</a>
                            <h4 class="title">Minimal Cycle</h4>
                            <div class="price"><span class="sprice">$70.00</span> <del class="dprice">$120.00</del></div>
                        </div>
                    </div>
                    <div class="single-new-collection-item">
                        <div class="thumb">
                            <img src="assets/img/new-collections/12.jpg" alt="product image">
                            <div class="hover">
                                <a href="#" class="addtocart">Add to cart</a>
                            </div>
                        </div>
                        <div class="content">
                            <a href="#" class="category">hat</a>
                            <h4 class="title">Red Yello Hat</h4>
                            <div class="price"><span class="sprice">$89.00</span> <del class="dprice">$156.00</del></div>
                        </div>
                    </div>
                    <div class="single-new-collection-item">
                        <div class="thumb">
                            <img src="assets/img/new-collections/03.jpg" alt="product image">
                            <div class="hover">
                                <a href="#" class="addtocart">Add to cart</a>
                            </div>
                        </div>
                        <div class="content">
                            <a href="#" class="category">cycle</a>
                            <h4 class="title">Minimal Cycle</h4>
                            <div class="price"><span class="sprice">$70.00</span> <del class="dprice">$90.00</del></div>
                        </div>
                    </div>
                </div><!-- //. recently added carousel -->
            </div>
        </div>
    </div>
</div>
<!-- recently added end -->

@endsection

{{--@section('bottom-scripts')--}}
    {{--<script>--}}
        {{--$('.addtocart').on('click', function(){--}}
            {{--$.ajax({--}}
                {{--method: "POST",--}}
                {{--url: "/cart",--}}
                {{--data: {--}}
                    {{--product: $('.addtocart').data('product-id'),--}}
                    {{--quantity: $('.qttotal').text(),--}}
                    {{--productAttribute: $('.attribute-select').val(),--}}
                    {{--_token: "{{ csrf_token() }}",--}}
                {{--}--}}
            {{--}).done(() => {--}}
                {{--console.log('addedToCart');--}}
            {{--}).fail((response) => {--}}
                {{--console.log('fail');--}}
                {{--});--}}
            {{--});--}}
    {{--</script>--}}
{{--@endsection--}}