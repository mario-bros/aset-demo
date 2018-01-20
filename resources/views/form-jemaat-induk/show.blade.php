@inject('Request', 'Illuminate\Http\Request')

@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Detail Jemaat Induk
@endsection

@section('contentheader_title')
    Aset Jemaat
@endsection

@section('main-content')
    <div class="m-content">

        <!--begin::Portlet-->
        <div class="m-portlet">

            <div class="m-portlet__body">

                <!--begin::Section-->
                <div class="m-section">

                    <div class="m-section__sub">
                        <header class="panel-heading">
                            @can('edit-jemaat', $jemaat_induk)
                                <a href="{{ route('form-jemaat-induk.edit', $jemaat_induk->id) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Edit</a>
                            @endcan
                        </header>
                    </div>

                    <div class="m-section__content">


                        <div class="table-responsive">
                            <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                <thead>
                                <tr>
                                    <th>Data Jemaat {{ $jemaat_induk->nama }}</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="font-weight: bold">Mupel</td>
                                        <td>{{ $jemaat_induk->mupel->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold">Email</td>
                                        <td>{{ $jemaat_induk->alamat_persil_desa_kelurahan }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold">No Telp</td>
                                        <td>{{ $jemaat_induk->no_telp }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold">Nama KMJ</td>
                                        <td>{{ $jemaat_induk->nama_kmj }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold">No Telp KMJ</td>
                                        <td>{{ $jemaat_induk->no_telp_kmj }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold">Alamat</td>
                                        <td>{{ $jemaat_induk->alamat_desa_kelurahan }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold">Kecamatan</td>
                                        <td>{{ $jemaat_induk->id_kecamatan }}</td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight: bold">Kabupaten</td>
                                        <td>{{ $jemaat_induk->id_kabupaten }}</td>
                                    </tr>
                                    <tr>
                                        <<td style="font-weight: bold">Propinsi</td>
                                        <td>{{ $jemaat_induk->id_propinsi }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="m-section__sub">
                        <header class="panel-heading">
                            @can('edit-jemaat', $jemaat_induk)
                            <a href="{{ route('form-jemaat-induk.edit', $jemaat_induk->id) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Edit</a>
                            @endcan
                        </header>
                    </div>
                </div>
                <!--end::Section-->

            </div>
            <!--end::Form-->
        </div>
        <!--end::Portlet-->

    </div>
@stop