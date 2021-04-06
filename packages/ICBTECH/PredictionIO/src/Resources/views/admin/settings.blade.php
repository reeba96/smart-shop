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
        <form  method="POST" action="{{ route('admin.predictionio.recommend') }}" onSubmit="return validateForm(event);">
            {{ csrf_field() }}
            <table class="table predictionio_table">
                <tr>
                    <th class="grid_head">{{ __('admin::app.predictionio.action') }}</th>
                    <th class="grid_head">{{ __('admin::app.predictionio.description') }}</th>
                </tr>
                <tbody>
                    <tr>
                        <td>
                            <button class="btn btn-lg btn-primary">
                                <a href="{{ route('admin.predictionio.build') }}"><font color="white"> {{ __('admin::app.predictionio.build') }}</font></a> 
                            </button>
                        </td>
                        <td>
                            <div class="control-group">
                                Building PredictionIO! 
                                <font color="red">{{ __('admin::app.predictionio.not_working') }}</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="btn btn-lg btn-primary">
                                <a href="{{ route('admin.predictionio.train') }}"><font color="white"> {{ __('admin::app.predictionio.train') }}</font></a> 
                            </button>
                        </td>
                        <td>
                            <div class="control-group">
                                Training PredictionIO! 
                                <font color="red">{{ __('admin::app.predictionio.not_working') }}</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="btn btn-lg btn-primary">
                                <a href="{{ route('admin.predictionio.deploy') }}"><font color="white"> {{ __('admin::app.predictionio.deploy') }}</font></a> 
                            </button>
                        </td>
                        <td>
                            <div class="control-group">
                                Deploying PredictionIO! 
                                <font color="red">{{ __('admin::app.predictionio.not_working') }}</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="btn btn-lg btn-primary">
                                <a href="{{ route('admin.predictionio.delete') }}"><font color="white"> {{ __('admin::app.predictionio.delete') }}</font></a> 
                            </button>
                        </td>
                        <td>
                            <div class="control-group">
                                Delete all data from PredictionIO database! 
                                <font color="red">{{ __('admin::app.predictionio.not_working') }}</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit" class="btn btn-lg btn-primary">
                                <font color="white"> {{ __('admin::app.predictionio.recommend') }}</font>
                            </button>
                        </td>
                        <td>
                            <div class="control-group">
                                Recommend <input type="number" value="4" class="control" id="product_number" name="product_number" style="width: 70px;" /> products to users.
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form> 
    </div>

@stop

@push('scripts')
    <script>
        function validateForm(e) {
            var product_number = document.getElementById("product_number").value;

            if (product_number  == "" || product_number  <= 0) {
                alert("{{ trans('admin::app.predictionio.recommended_products') }}");
                e.preventDefault();
            } 
    }
    </script>
@endpush