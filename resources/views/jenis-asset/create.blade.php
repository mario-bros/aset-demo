@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Form Jemaat
@endsection


@section('main-content')
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12">
            <div class="profile-form panel panel-default">
                <header class="panel-heading">
                    <h2 class="panel-title text-bold">{{ $page_title }}</h2>
                </header>
                <div class="panel-body">
                    {!! Form::open(['route' => 'jenis-aset.store']) !!}
                        @include('jenis-asset._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop