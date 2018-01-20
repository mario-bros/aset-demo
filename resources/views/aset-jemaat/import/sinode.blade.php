@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ $page_title }}
@endsection

@section('contentheader_title')
    {{ $page_title }}
@endsection



@section('main-content')
<div class="m-content">

    <!--begin::Portlet-->
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        {{ $page_title }}
                    </h3>
                </div>
            </div>
        </div>

        {!! Form::open(['route' => 'aset-jemaat.import.sinode', 'files' => true, 'class' => "m-form m-form--fit m-form--label-align-right"]) !!}
            @include('aset-jemaat._import_form')
        {!! Form::close() !!}
    </div>
    <!--end::Portlet-->
</div>
@stop