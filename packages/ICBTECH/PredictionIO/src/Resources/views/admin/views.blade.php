@extends('predictionio::layouts.master')

@section('page_title')
    {{ __('admin::app.predictionio.views') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">

            <div class="page-title">
                <h1>{{ __('admin::app.predictionio.views') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.predictionio.deleteViews') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.predictionio.delete_saved_views_from_table') }}
                </a>
                <a href="{{ route('admin.predictionio.importViews') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.predictionio.import_existing_views') }}
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
                @if ($entity->entityType == 'user' && $entity->event == 'view')
                    <tr>
                        <td data-value="Number">{{ $i }}</td>
                        <td data-value="ID">{{$entity->eventId}}</td>
                        <td data-value="Event">{{$entity->event}}</td>
                        <td data-value="Entity Type">{{$entity->entityType}}</td>
                        <td data-value="Event Time">{{$entity->eventTime}}</td>
                    </tr>
                    <?php $i = $i + 1; ?>
                @endif
            @endforeach
        </tbody>
    </table>
@stop

@push('scripts')
   
@endpush