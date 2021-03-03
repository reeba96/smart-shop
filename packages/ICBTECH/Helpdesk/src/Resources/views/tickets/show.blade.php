@extends('helpdesk::layouts.master')

@section('page_title')
    {{ $ticket->subject }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ $ticket->subject }}</h1>
            </div>

            <div class="page-action">

                <div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>
                    <span >
                        {{ __('admin::app.export.export') }}
                    </span>
                </div>
                 
                @if (Request::segment(3) != "complete")
                    <a href="{{ route('admin.helpdesk.active.complete', $ticket->id) }}" class="btn btn-lg btn-primary" v-alert:message="'{{ __('admin::app.helpdesk.mark-complete') }}'">
                        {{ __('helpdesk::admin.mark-complete') }}
                    </a>
                @endif

                <a href="{{ route('admin.helpdesk.complete.delete', $ticket->id) }}" class="btn btn-lg btn-primary" v-alert:message="'{{ __('admin::app.helpdesk.delete') }}'">
                    {{ __('admin::app.datagrid.delete') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <tabs>
                <tab name="Information" :selected="true">
                
                    <input type="hidden" name="locale" value="all"/>

                    <accordian :title="'{{ __('helpdesk::admin.account-information') }}'" :active="false">
                        <div slot="body">
                            <div class="section-content">
                                <div class="row">
                                    {{ __('shop::app.customer.signup-form.firstname') }}: 
                                    {{ $customer->first_name }}
                                </div><br>
                                <div class="row">
                                    {{ __('shop::app.customer.signup-form.lastname') }}: 
                                    {{ $customer->last_name }}
                                </div><br>
                                <div class="row">
                                    {{ __('admin::app.datagrid.email') }}: 
                                    {{ $customer->email }}
                                </div>
                            </div>
                        </div>
                    </accordian>

                    <accordian :title="'{{ __('helpdesk::admin.general') }}'" :active="false">
                        <div slot="body">
                            <div class="section-content">
                                <div class="row">
                                    {{ __('helpdesk::lang.subject') }}: 
                                    {{ $ticket->subject }}
                                </div><br>
                                <div class="row">
                                    {{ __('helpdesk::lang.status') }}: 
                                    {{ $status->name }}
                                </div><br>
                                <div class="row">
                                    {{ __('helpdesk::lang.priority') }}: 
                                    {{ $priority->name }}
                                </div><br>
                                <div class="row">
                                    {{ __('helpdesk::lang.category') }}: 
                                    {{ $category->name }}
                                </div><br>
                                <div class="row">
                                    {{ __('helpdesk::lang.created') }}: 
                                    {{ $ticket->created_at }}
                                </div><br>
                            </div>
                        </div>
                    </accordian>

                    <accordian :title="'{{ __('helpdesk::lang.reply') }}'" :active="true">
                        <div slot="body">
                            <p>{{ $ticket->content }}</p><br>
                            <div class="section-content">
                                @include('helpdesk::tickets.partials.comments')
                            </div>
                        </div>
                    </accordian>

                </tab>
            </tabs>
  
        </div>
    </div>
@stop

@section('ticketit_extra_content')
    <h2 class="mt-5">{{ trans('helpdesk::lang.comments') }}</h2>
    @include('helpdesk::tickets.partials.comments')

    @include('helpdesk::tickets.partials.comment_form')
@stop