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
        </div>
    </div>

    <table class="table predictionio_table">
        <tr>
            <th class="grid_head"></th>
            <th class="grid_head">ID</th>
            <th class="grid_head">Event</th>
            <th class="grid_head">Entity Type</th>
            <th class="grid_head">Event Time</th>
        </tr>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($entities as $entity)
                @if ($entity->entityType == 'user' && $entity->event == '$set')
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