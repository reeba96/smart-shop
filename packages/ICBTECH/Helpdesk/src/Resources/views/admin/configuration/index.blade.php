@extends('helpdesk::layouts.master')

@section('page_title')
    {{ __('helpdesk::admin.nav-configuration') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('helpdesk::admin.nav-configuration') }}</h1>
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

        <tabs>
            <tab name="General" :selected="true">
            
                <input type="hidden" name="locale" value="all"/>
                <div class="page-content">
                    @inject('configurationGrid', 'ICBTECH\Helpdesk\DataGrids\ConfigurationDataGrid')
                    {!! $configurationGrid->render() !!}
                </div>

            </tab>
        </tabs>
    </div>

    <modal id="downloadDataGrid" :is-open="modalIds.downloadDataGrid">
        <h3 slot="header">{{ __('admin::app.export.download') }}</h3>
        <div slot="body">
            <export-form></export-form>
        </div>
    </modal>
@stop

@push('scripts')
    @include('admin::export.export', ['gridName' => $configurationGrid])
@endpush