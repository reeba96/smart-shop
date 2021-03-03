@extends('helpdesk::layouts.master')

@section('page', trans('helpdesk::lang.index-title'))
@section('page_title', trans('helpdesk::lang.index-my-tickets'))


@section('ticketit_header')
{{--
{!!-- link_to_route($setting->grab('main_route').'.create', trans('helpdesk::lang.btn-create-new-ticket'), null, ['class' => 'btn btn-primary']) !!}
--}}
@stop

@section('ticketit_content_parent_class', 'pl-0 pr-0')

@section('ticketit_content')
    <div id="message"></div>
    @include('helpdesk::tickets.partials.datatable')
@stop
{{-- ajax: '{!!  route($setting->grab('main_route').'.data', $complete) !!}', --}}
@section('footer')
<script src="https://cdn.datatables.net/v/bs4/dt-{{ ICBTECH\Helpdesk\Helpers\Cdn::DataTables }}/r-{{ ICBTECH\Helpdesk\Helpers\Cdn::DataTablesResponsive }}/datatables.min.js"></script>
<script>
	$('.table').DataTable({
		processing: false,
		serverSide: true,
		responsive: true,
		pageLength: {{ $setting->grab('paginate_items') }},
		lengthMenu: {{ json_encode($setting->grab('length_menu')) }},
		ajax: '',
		language: {
			decimal:        "{{ trans('helpdesk::lang.table-decimal') }}",
			emptyTable:     "{{ trans('helpdesk::lang.table-empty') }}",
			info:           "{{ trans('helpdesk::lang.table-info') }}",
			infoEmpty:      "{{ trans('helpdesk::lang.table-info-empty') }}",
			infoFiltered:   "{{ trans('helpdesk::lang.table-info-filtered') }}",
			infoPostFix:    "{{ trans('helpdesk::lang.table-info-postfix') }}",
			thousands:      "{{ trans('helpdesk::lang.table-thousands') }}",
			lengthMenu:     "{{ trans('helpdesk::lang.table-length-menu') }}",
			loadingRecords: "{{ trans('helpdesk::lang.table-loading-results') }}",
			processing:     "{{ trans('helpdesk::lang.table-processing') }}",
			search:         "{{ trans('helpdesk::lang.table-search') }}",
			zeroRecords:    "{{ trans('helpdesk::lang.table-zero-records') }}",
			paginate: {
				first:      "{{ trans('helpdesk::lang.table-paginate-first') }}",
				last:       "{{ trans('helpdesk::lang.table-paginate-last') }}",
				next:       "{{ trans('helpdesk::lang.table-paginate-next') }}",
				previous:   "{{ trans('helpdesk::lang.table-paginate-prev') }}"
			},
			aria: {
				sortAscending:  "{{ trans('helpdesk::lang.table-aria-sort-asc') }}",
				sortDescending: "{{ trans('helpdesk::lang.table-aria-sort-desc') }}"
			},
		},
		columns: [
			{ data: 'id', name: 'ticketit.id' },
			{ data: 'subject', name: 'subject' },
			{ data: 'status', name: 'ticketit_statuses.name' },
			{ data: 'updated_at', name: 'ticketit.updated_at' },
			{ data: 'agent', name: 'users.name' }
		]
	});
</script>
@append
