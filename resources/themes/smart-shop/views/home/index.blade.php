@extends('shop::layouts.master')

@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
@inject ('productRatingHelper', 'Webkul\Product\Helpers\Review')

@php
    $channel = core()->getCurrentChannel();

    $homeSEO = $channel->home_seo;

    if (isset($homeSEO)) {
        $homeSEO = json_decode($channel->home_seo);

        $metaTitle = $homeSEO->meta_title;

        $metaDescription = $homeSEO->meta_description;

        $metaKeywords = $homeSEO->meta_keywords;
    }
@endphp

@section('page_title')
    {{ isset($metaTitle) ? $metaTitle : "" }}
@endsection

@section('head')

    @if (isset($homeSEO))
        @isset($metaTitle)
            <meta name="title" content="{{ $metaTitle }}" />
        @endisset

        @isset($metaDescription)
            <meta name="description" content="{{ $metaDescription }}" />
        @endisset

        @isset($metaKeywords)
            <meta name="keywords" content="{{ $metaKeywords }}" />
        @endisset
    @endif
@endsection

@push('css')
    <style type="text/css">
        .product-price span:first-child, .product-price span:last-child {
            font-size: 18px;
            font-weight: 600;
        }
    </style>
@endpush

@section('content-wrapper')
    @include('shop::home.slider')
@endsection

@section('full-content-wrapper')

    <div class="full-content-wrapper">
        {!! view_render_event('bagisto.shop.home.content.before') !!}
        
            @if(isset($product_1) && isset($product_2) && isset($product_3))
   
                <div class="container-fluid advertisement-four-container">
                    <div class="row">
                        <div class="col-lg-4 col-12 offers-ct-panel">
                            <a @if (isset($product_1->path)) href="{{ asset($product_1->url_key) }}" @endif>
                                <img class="col-12" @if (isset($product_1->path)) src="{{ url()->to('/') }}/storage/{{ $product_1->path }}"  @endif />
                            </a>
                            <div><h2>{{ $product_1->name }}</h2></div>
                            <div><h3>Price: {{ $product_1->price }}</h3></div>
                        </div>
            
                        <div class="col-lg-4 col-12 offers-ct-panel">
                            <a @if (isset($product_1->path)) href="{{ asset($product_2->url_key) }}" @endif>
                                <img class="col-12" @if (isset($product_1->path)) src="{{ url()->to('/') }}/storage/{{ $product_2->path }}"  @endif />
                            </a>
                            <div><h2>{{ $product_2->name }}</h2></div>
                            <div><h3>Price: {{ $product_3->price }}</h3></div>
                        </div>
            
                        <div class="col-lg-4 col-12 offers-ct-panel">
                            <a @if (isset($product_1->path)) href="{{ asset($product_3->url_key) }}" @endif>
                                <img class="col-12" @if (isset($product_1->path)) src="{{ url()->to('/') }}/storage/{{ $product_3->path }}"  @endif />
                            </a>
                            <div><h2>{{ $product_3->name }}</h2></div>
                            <div><h3>Price: {{ $product_3->price }}</h3></div>
                        </div>
                        
                    </div>
                </div>
            @elseif ($velocityMetaData)
                {!! DbView::make($velocityMetaData)->field('home_page_content')->render() !!}
            @else
                @include('shop::home.advertisements.advertisement-four')
                @include('shop::home.featured-products')
                @include('shop::home.advertisements.advertisement-three')
                @include('shop::home.new-products')
                @include('shop::home.advertisements.advertisement-two')
            @endif

        {{ view_render_event('bagisto.shop.home.content.after') }}
    </div>

@endsection

