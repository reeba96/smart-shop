@extends('helpdesk::layouts.master')

@section('page_title')
    {{ __('helpdesk::lang.status') }}
@stop

@section('page', trans('helpdesk::admin.status-edit-title', ['name' => ucwords($status->name)]))

@section('content') 
    <div class="content">
        <form method="POST" action="{{ route('admin.helpdesk.status.update', $status->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>

                        {{ __('helpdesk::admin.status-edit-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('helpdesk::admin.btn-save-new-status') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()
                    <input type="hidden" name="locale" value="all"/>

                    <accordian :title="'{{ __('helpdesk::admin.general') }}'" :active="true">
                        <div slot="body">

                            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('helpdesk::admin.status-create-name') }}</label>
                                <input type="text" v-validate="'required'" class="control" id="name" name="name" value="{{ old('name') ?: $status->name }}" data-vv-as="&quot;{{ __('helpdesk::admin.status-create-name') }}&quot;" v-slugify-target="'slug'"/>
                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('color') ? 'has-error' : '']">
                                <label for="color" class="required">{{ __('helpdesk::admin.status-create-color') }}</label>
                                <input type="color" v-validate="'required'" class="control" id="color" name="color" value="{{ old('color') ?: $status->color }}">
                                <span class="control-error" v-if="errors.has('color')">@{{ errors.first('color') }}</span>
                            </div>

                        </div>
                    </accordian>

                </div>
            </div>
        </form>
    </div>
@stop
