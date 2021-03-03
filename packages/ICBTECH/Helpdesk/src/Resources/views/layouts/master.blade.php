@extends('admin::layouts.content')

@section('content-wrapper')
    <div class="inner-section">
    
        @include('helpdesk::shared.nav')

        <div class="content-wrapper">
            
            @include ('admin::layouts.tabs')

            @yield('content')

        </div>
        
    </div>
@stop