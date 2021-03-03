@extends('helpdesk::layouts.master')

@section('page_title')
    @if (Request::segment(3) == "complete")
        {{ __('helpdesk::lang.nav-completed-tickets') }}
    @else
        {{ __('helpdesk::lang.nav-active-tickets') }}
    @endif
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                @if (Request::segment(3) == "complete")
                    <h1>{{ __('helpdesk::lang.nav-completed-tickets') }}</h1>
                @else
                    <h1>{{ __('helpdesk::lang.nav-active-tickets') }}</h1>
                @endif
            </div>

            <div class="page-action">
                <div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>
                    <span >
                        {{ __('admin::app.export.export') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="page-content">
            @if (Request::segment(3) == "complete")
                @inject('ticketGrid', 'ICBTECH\Helpdesk\DataGrids\CompleteTicketDataGrid')
            @else
                @inject('ticketGrid', 'ICBTECH\Helpdesk\DataGrids\ActiveTicketDataGrid')
            @endif
            
            {!! $ticketGrid->render() !!}
        </div>
        
    </div>

    <modal id="downloadDataGrid" :is-open="modalIds.downloadDataGrid">
        <h3 slot="header">{{ __('admin::app.export.download') }}</h3>
        <div slot="body">
            <export-form></export-form>
        </div>
    </modal>

@stop

@push('scripts')
    @include('admin::export.export', ['gridName' => $ticketGrid])
@endpush