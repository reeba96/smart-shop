@extends('predictionio::layouts.master')

@section('page_title')
    {{ __('admin::app.predictionio.items') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">

            <div class="page-title">
                <h1>{{ __('admin::app.predictionio.items') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.predictionio.importItems') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.predictionio.import_existing_products') }}
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
            <th class="grid_head">{{ __('admin::app.predictionio.categories') }}</th>
        </tr>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($entities as $entity)
                @if ($entity->entityType == 'item' && $entity->event == '$set')
                    <tr>
                        <td data-value="Number">{{ $i }}</td>
                        <td data-value="ID">{{$entity->eventId}}</td>
                        <td data-value="Event">{{$entity->event}}</td>
                        <td data-value="Entity Type">{{$entity->entityType}}</td>
                        <td data-value="Event Time">{{$entity->eventTime}}</td>
                        <td data-value="Event Time">{{ json_encode($entity->properties->categories) }}</td>
                    </tr>
                    <?php $i = $i + 1; ?>
                @endif
            @endforeach
        </tbody>
    </table>
@stop

@push('scripts')
   
@endpush