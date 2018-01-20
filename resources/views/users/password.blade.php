@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Form Change Password
@endsection

@section('contentheader_title')
    Users
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
                        Change your password
                    </h3>
                </div>
            </div>
        </div>

        {!! Form::open(['route' => 'change.password', 'class' => "m-form m-form--fit m-form--label-align-right", "autocomplete" => "off"]) !!}
            @include('users._password_form')
        {!! Form::close() !!}
    </div>
    <!--end::Portlet-->

</div>
@stop