@extends('helpdesk::layouts.master')

@section('page_title')
    {{ __('helpdesk::admin.nav-priorities') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('helpdesk::admin.nav-priorities') }}</h1>
            </div>

            <div class="page-action">
                <div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>
                    <span >
                        {{ __('admin::app.export.export') }}
                    </span>
                </div>

                <a href="{{ route('admin.helpdesk.priority.create') }}" class="btn btn-lg btn-primary">
                    {{ __('helpdesk::admin.btn-create-new-priority') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('priorityGrid', 'ICBTECH\Helpdesk\DataGrids\PriorityDataGrid')
            {!! $priorityGrid->render() !!}
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
    @include('admin::export.export', ['gridName' => $priorityGrid])
@endpush