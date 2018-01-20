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
                    <h2 class="panel-title text-bold">Edit Data jenis aset</h2>
                </header>
                <div class="panel-body">
                    {!! Form::model($jenis_asset, ['route' => ['jenis-aset.update', $jenis_asset], 'method' =>'put']) !!}
                        @include('jenis-asset._form', ['model' => $jenis_asset])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

</div>
@stop