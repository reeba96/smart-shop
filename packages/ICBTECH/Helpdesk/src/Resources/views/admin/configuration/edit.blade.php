@extends('helpdesk::layouts.master')

@section('page_title')
    {{ __('helpdesk::admin.config-edit-subtitle') }}
@stop

@section('content') 
    <div class="content">
        <form method="POST" action="{{ route('admin.helpdesk.configuration.update', $configuration->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>

                        {{ __('helpdesk::admin.config-edit-subtitle') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.configuration.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()
                    <input type="hidden" name="locale" value="all"/>

                    <accordian :title="'{{ __('helpdesk::admin.general') }}'" :active="true">
                        <div slot="body">

                            <div class="control-group" :class="[errors.has('value') ? 'has-error' : '']">
                                <label for="value" class="required">{{ __('helpdesk::admin.config-edit-value') }}</label>
                                <input type="text" v-validate="'required'" class="control" id="value" name="value" value="{{ old('name') ?: $configuration->value }}" data-vv-as="&quot;{{ __('helpdesk::admin.config-edit-value') }}&quot;" />
                                <span class="control-error" v-if="errors.has('value')">@{{ errors.first('value') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('default') ? 'has-error' : '']">
                                <label for="default" class="required">{{ __('helpdesk::admin.config-edit-default') }}</label>
                                <input type="text" v-validate="'required'" class="control" id="default" name="default" value="{{ old('name') ?: $configuration->default }}" data-vv-as="&quot;{{ __('helpdesk::admin.config-edit-default') }}&quot;" />
                                <span class="control-error" v-if="errors.has('default')">@{{ errors.first('default') }}</span>
                            </div>

                        </div>
                    </accordian>

                </div>
            </div>
        </form>
    </div>
@stop