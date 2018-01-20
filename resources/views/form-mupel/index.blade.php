@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Form Mupel
@endsection

@section('contentheader_title')
    Mupel
@endsection



@section('main-content')
<div class="m-content">

    <!--begin::Portlet-->
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">{{ $page_title }}</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin::Section-->
            <div class="m-section">
                <div class="m-section__sub">
                    <header class="panel-heading">
                        <a href="{{ route('form-mupel.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Mupel Baru</a>
                    </header>
                </div>
                <div class="m-section__content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Mupel</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($mupel as $idx => $item)
                                <tr>
                                    <th scope="row">{{ $mupel->perPage() * ($mupel->currentPage() - 1) + ($idx+1) }}</th>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('form-mupel.edit', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                            {!! Form::open(['route' => ['form-mupel.destroy', $item->id], 'method' => 'delete', 'class' => 'element-inline']) !!}
                                            {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-sm warning-delete', 'type' => 'submit', 'data-title' => $item->nama]) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="panel panel-default">
                                            <div class="panel-body text-center">
                                                Tidak ada data mupel sama sekali. <a href="{{ route('form-mupel.create') }}" class="btn-link">Buat data.</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="m-section__content float-right">
                        {{ $mupel->links() }}
                    </div>
                </div>
            </div>
            <!--end::Section-->

        </div>
        <!--end::Form-->
    </div>
    <!--end::Portlet-->
</div>
@stop