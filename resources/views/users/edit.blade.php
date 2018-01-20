@inject('Role', 'App\Models\Role')

@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Form User
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
                        {{ $page_title }}
                    </h3>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="color: black">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <br><br>

        {!! Form::model($user, ['route' => ['users.update', $user], 'method' => 'put', 'role' => 'form', 'class' => "m-form m-form--fit m-form--label-align-right"]) !!}
            @include('users._form', ['model' => $user])
        {!! Form::close() !!}
    </div>
    <!--end::Portlet-->
</div>
@stop