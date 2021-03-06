@extends('predictionio::layouts.master')

@section('page_title')
    {{ __('admin::app.predictionio.users') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">

            <div class="page-title">
                <h1>{{ __('admin::app.predictionio.users') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.predictionio.importUsers') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.predictionio.import_existing_users') }}
                </a>
            </div>

        </div>
    </div>

    <table class="table predictionio_table">
        <tr>
            <th class="grid_head"></th>
            <th class="grid_head">{{ __('admin::app.predictionio.id') }}</th>
            <th class="grid_head">{{ __('admin::app.predictionio.event') }}</th>
            <th class="grid_head">{{ __('admin::app.predictionio.event_type') }}</th>
            <th class="grid_head">{{ __('admin::app.predictionio.event_time') }}</th>
        </tr>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($entities as $entity)
                <tr>
                    <td data-value="Number">{{ $i }}</td>
                    <td data-value="ID">{{$entity->eventId}}</td>
                    <td data-value="Event">{{$entity->event}}</td>
                    <td data-value="Entity Type">{{$entity->entityType}}</td>
                    <td data-value="Event Time">{{$entity->eventTime}}</td>
                </tr>
                <?php $i = $i + 1; ?>
            @endforeach
        </tbody>
    </table>
@stop

@push('scripts')
   
@endpush