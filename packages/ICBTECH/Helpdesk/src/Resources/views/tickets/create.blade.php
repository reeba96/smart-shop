@extends('helpdesk::layouts.master')
@section('page', trans('helpdesk::lang.create-ticket-title'))
@section('page_title', trans('helpdesk::lang.create-new-ticket'))

@section('ticketit_content')
    {!! CollectiveForm::open([
                    'route'=>$setting->grab('main_route').'.store',
                    'method' => 'POST'
                    ]) !!}
        <div class="form-group row">
            {!! CollectiveForm::label('subject', trans('helpdesk::lang.subject') . trans('helpdesk::lang.colon'), ['class' => 'col-lg-2 col-form-label']) !!}
            <div class="col-lg-10">
                {!! CollectiveForm::text('subject', null, ['class' => 'form-control', 'required' => 'required']) !!}
                <small class="form-text text-muted">{!! trans('helpdesk::lang.create-ticket-brief-issue') !!}</small>
            </div>
        </div>
        <div class="form-group row">
            {!! CollectiveForm::label('content', trans('helpdesk::lang.description') . trans('helpdesk::lang.colon'), ['class' => 'col-lg-2 col-form-label']) !!}
            <div class="col-lg-10">
                {!! CollectiveForm::textarea('content', null, ['class' => 'form-control summernote-editor', 'rows' => '5', 'required' => 'required']) !!}
                <small class="form-text text-muted">{!! trans('helpdesk::lang.create-ticket-describe-issue') !!}</small>
            </div>
        </div>
        <div class="form-row mt-5">
            <div class="form-group col-lg-4 row">
                {!! CollectiveForm::label('priority', trans('helpdesk::lang.priority') . trans('helpdesk::lang.colon'), ['class' => 'col-lg-6 col-form-label']) !!}
                <div class="col-lg-6">
                    {!! CollectiveForm::select('priority_id', $priorities, null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>
            </div>
            <div class="form-group offset-lg-1 col-lg-4 row">
                {!! CollectiveForm::label('category', trans('helpdesk::lang.category') . trans('helpdesk::lang.colon'), ['class' => 'col-lg-6 col-form-label']) !!}
                <div class="col-lg-6">
                    {!! CollectiveForm::select('category_id', $categories, null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>
            </div>
            {!! CollectiveForm::hidden('agent_id', 'auto') !!}
        </div>
        <br>
        <div class="form-group row">
            <div class="col-lg-10 offset-lg-2">
                {!! link_to_route($setting->grab('main_route').'.index', trans('helpdesk::lang.btn-back'), null, ['class' => 'btn btn-link']) !!}
                {!! CollectiveForm::submit(trans('helpdesk::lang.btn-submit'), ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    {!! CollectiveForm::close() !!}
@endsection

@section('footer')
    @include('helpdesk::tickets.partials.summernote')
@append