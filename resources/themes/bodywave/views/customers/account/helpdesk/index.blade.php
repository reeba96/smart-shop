@extends('shop::customers.account.index')

@section('page_title')
    {{ __('shop::app.customer.account.helpdesk.title') }}
@endsection

@section('page-detail-wrapper')
    <div class="account-head mb-10">
        <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
        <span class="account-heading">
            {{ __('shop::app.customer.account.helpdesk.title') }}
        
            <a href="{{ route('customer.helpdesk.create') }}" style=" vertical-align: middle;" class="btn btn-lg btn-primary open-ticket">
                {{ __('shop::app.customer.account.helpdesk.create-ticket') }}
            </a>
        </span><br><br>
        
        <div class="horizontal-rule"></div>
    </div>
    
    {!! view_render_event('bagisto.shop.customers.account.helpdesk.list.before') !!}
        <div class="account-items-list">
            <div class="account-table-content">

                {!! app('Webkul\Shop\DataGrids\HelpdeskDataGrid')->render() !!}

            </div>
        </div>
    {!! view_render_event('bagisto.shop.customers.account.helpdesk.list.after') !!}
    
@endsection