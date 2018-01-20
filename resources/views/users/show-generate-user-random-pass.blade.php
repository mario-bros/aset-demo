@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Form Import Aset Jemaat
@endsection

@section('contentheader_title')
    Form Import Aset Jemaat
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
                <p>Perhatian, setelah menekan tombol 'Generate' di bawah, semua user kecuali admin akan berubah menjadi random</p>
                <br>
            </div>
        </div>

        {!! Form::open(['route' => 'users.generate-random-password', 'class' => "m-form m-form--fit m-form--label-align-right"]) !!}
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    {!! Form::button('<i class="fa fa-send"></i> Generate', ['class'=>'btn btn-metal btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <!--end::Portlet-->
</div>
@stop