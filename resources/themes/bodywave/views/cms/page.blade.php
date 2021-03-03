@extends('shop::layouts.master')

@section('page_title')
    {{ $page->page_title }}
@endsection

@section('head')
    @isset($page->meta_title)
        <meta name="title" content="{{ $page->meta_title }}" />
    @endisset

    @isset($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}" />
    @endisset

    @isset($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}" />
    @endisset
@endsection

@section('content-wrapper')
    <div class="p-4 m-4 row offset-1">
        <div class="container card" style="width: 60%;">
            <div class="card-body">
              <p class="card-text">
                {!! DbView::make($page)->field('html_content')->render() !!}
              </p>
            </div>
        </div>  
    </div>
        
@endsection