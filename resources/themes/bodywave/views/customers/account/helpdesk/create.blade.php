@extends('shop::customers.account.index')

@section('page_title')
    {{ __('shop::app.customer.account.helpdesk.title') }}
@endsection

@section('page-detail-wrapper')
    <div class="account-head mb-10">
        <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
        <span class="account-heading">{{ __('shop::app.customer.account.helpdesk.create-ticket') }}</span>
    </div>
    
    {!! view_render_event('bagisto.shop.customers.account.helpdesk.create.before') !!}

        <form method="post" action="{{ route('customer.helpdesk.save') }}" @submit.prevent="onSubmit">

            <div class="account-table-content">
                @csrf

                {!! view_render_event('bagisto.shop.customers.account.helpdesk.create_form_controls.before') !!}
                
                <div class="control-group" :class="[errors.has('subject') ? 'has-error' : '']">
                    <label for="subject" class="mandatory">{{ __('shop::app.customer.account.helpdesk.subject') }}</label>
                    <input type="text" class="control" name="subject" value="{{ old('subject') }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.helpdesk.subject') }}&quot;">
                    <span class="control-error" v-if="errors.has('subject')">@{{ errors.first('subject') }}</span>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.helpdesk.create_form_controls.after') !!}

                <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                    <label for="content" class="mandatory">{{ __('shop::app.customer.account.helpdesk.description') }}</label>
                    <textarea class="form-control" name="content" value="{{ old('content') }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.helpdesk.description') }}&quot;"></textarea>
                    <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.helpdesk.create_form_controls.content.after') !!}

                <div class="row">
                    <div class="col-sm">
                        <div class="control-group">
                            <label for="priority_id" class="mandatory">{{ __('shop::app.customer.account.helpdesk.priority') }}</label>
                            <select class="form-control" name="priority_id">
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="control-group">
                            <label for="category_id" class="mandatory">{{ __('shop::app.customer.account.helpdesk.category') }}</label>
                            <select class="form-control" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.helpdesk.create_form_controls.category.after') !!}

                <div class="button-group">
                    <button class="theme-btn" type="submit">
                        {{ __('shop::app.customer.account.helpdesk.save-ticket') }}
                    </button>
                </div>
            </div>
        </form>

    {!! view_render_event('bagisto.shop.customers.account.helpdesk.create.after') !!}
@endsection