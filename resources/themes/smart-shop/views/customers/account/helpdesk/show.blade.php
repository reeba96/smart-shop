@extends('shop::customers.account.index')

@section('page_title')
    {{ __('shop::app.customer.account.helpdesk.title') }}
@endsection

@push('css')
    <style type="text/css">
        .account-content .account-layout .account-head {
            margin-bottom: 0px;
        }
        .sale-summary .dash-icon {
            margin-right: 30px;
            float: right;
        }
    </style>
@endpush

@section('page-detail-wrapper')
    <div class="account-content">
        <div class="account-layout">
            <div class="account-head">
                <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
                <span class="account-heading">
                    {{ __('shop::app.customer.account.helpdesk.page-title', ['ticket_subject' => $ticket->subject]) }}
                </span>
                <span></span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.ticket.view.before', ['ticket' => $ticket]) !!}

            <div class="sale-container">
                <tabs>
                    <tab name="{{ __('shop::app.customer.account.helpdesk.info') }}" :selected="true">

                        @include('shop::customers.account.helpdesk.partials.ticket_body')
                        
                        @include('shop::customers.account.helpdesk.partials.comments')
                    </tab>
                </tabs>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.ticket.view.after', ['ticket' => $ticket]) !!}
        </div>
    </div>
@endsection