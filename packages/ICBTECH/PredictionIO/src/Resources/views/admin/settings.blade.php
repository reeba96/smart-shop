@extends('predictionio::layouts.master')

@section('page_title')
    {{ __('admin::app.predictionio.settings') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.predictionio.settings') }}</h1>
            </div>
        </div>
    </div>
@stop

@push('scripts')
   
@endpush