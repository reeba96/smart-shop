@extends('helpdesk::layouts.master')

@section('page_title')
    {{ __('helpdesk::admin.nav-categories') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('helpdesk::admin.nav-categories') }}</h1>
            </div>

            <div class="page-action">
                <div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>
                    <span >
                        {{ __('admin::app.export.export') }}
                    </span>
                </div>

                <a href="{{ route('admin.helpdesk.category.create') }}" class="btn btn-lg btn-primary">
                    {{ __('helpdesk::admin.btn-create-new-category') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('categoryGrid', 'ICBTECH\Helpdesk\DataGrids\CategoryDataGrid')
            {!! $categoryGrid->render() !!}
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
    @include('admin::export.export', ['gridName' => $categoryGrid])
@endpush