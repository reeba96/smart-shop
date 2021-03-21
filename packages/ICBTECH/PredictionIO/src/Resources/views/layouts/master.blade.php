@extends('admin::layouts.content')

@section('content-wrapper')
    <div class="inner-section">
    
        @include('predictionio::shared.nav')

        <div class="content-wrapper">
            
            @include ('admin::layouts.tabs')

            @yield('content')

        </div>
        
    </div>
@stop