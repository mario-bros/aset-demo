@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Form Jenis Aset
@endsection


@section('main-content')
<div class="container-fluid spark-screen">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <header class="panel-heading">
                    <a href="{{ route('jenis-aset.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>Jenis Aset Baru</a>
                </header>
                <div class="panel-body">
                    @forelse($jenis_asset as $item)
                        <div class="panel panel-primary panel-sm">
                            <header class="panel-heading">
                                <h2 class="panel-title text-bold">{{ $item->nama }}</h2>
                            </header>
                            <div class="panel-footer text-right">
                                <a href="{{ route('jenis-aset.edit', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                {!! Form::open(['route' => ['jenis-aset.destroy', $item->id], 'method' => 'delete', 'class' => 'element-inline']) !!}
                                    {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-sm warning-delete', 'type' => 'submit', 'data-title' => $item->nama]) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @empty
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                Tidak ada data jenis aset. <a href="{{ route('jenis-aset.create') }}" class="btn-link">Buat data.</a>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="panel-footer">
                    <div class="pull-right nomargin-paginator">
                        {{ $jenis_asset->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop