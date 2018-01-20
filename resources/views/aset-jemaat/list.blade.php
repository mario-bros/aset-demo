@inject('JemaatInduk', 'App\Models\JemaatInduk')
@inject('Request', 'Illuminate\Http\Request')

@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ $page_title }}
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

                    <div class="m-section__content">
                        <div class="m-section__content float-right">
                            {{ $aset_jemaat->appends($_GET)->links() }}
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Jemaat</th>
                                    <th>Kode aset</th>
                                    <th>Jenis aset</th>
                                    <th>Alamat aset</th>
                                    <th>Kecamatan</th>
                                    <th>Kabupaten</th>
                                    <th>Propinsi</th>
                                    <th>Tanggal terbit surat ukur</th>
                                    <th>No surat ukur</th>
                                    <th>Luas tanah</th>
                                    <th>Status kepemilikan</th>
                                    <th>Tanggal pengeluaran sertifikat</th>
                                    <th>Atas nama</th>
                                    <th>Asal</th>
                                    <th>Masa berakhir HGB</th>
                                    <th>Nama bangunan</th>
                                    <th>Luas bangunan</th>
                                    <th>No tanggal penerbitan IMB</th>
                                    <th>NJOP</th>
                                    <th>Status kelola</th>
                                    <th>Keberadaan dokumen</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($aset_jemaat as $idx => $item)
                                    <tr>
                                        <th scope="row">{{ $idx+1 }}</th>
                                        <td>{{ $item->jemaat->nama }}</td>
                                        <td>{{ $item->kode_aset }}</td>
                                        <td>{!! $item->jenis_asset !!}</td>
                                        <td>{!! $item->alamat_persil_desa_kelurahan !!}</td>
                                        <td>{!! $item->kecamatan_persil !!}</td>
                                        <td>{!! $item->kabupaten_persil !!}</td>
                                        <td>{!! $item->propinsi_persil !!}</td>
                                        <td>{!! $item->tanggal_terbit_surat_ukur !!}</td>
                                        <td>{!! $item->no_surat_ukur !!}</td>
                                        <td>{!! $item->luas_tanah !!}</td>
                                        <td>
                                            {!! $item->status_kepemilikan !!} 
                                            @php
                                            if ( $item->status_kepemilikan ) {
                                                $flippedStatusKepemilikanEnums = array_flip($item::$statusKepemilikanEnums);
                                                $status_kepemilikan_variant = $flippedStatusKepemilikanEnums[$item->status_kepemilikan];

                                                echo "( " . $item->$status_kepemilikan_variant . " )";  
                                            }
                                            @endphp
                                        </td>
                                        <td>{!! $item->tanggal_pengeluaran_sertifikat_surat !!}</td>
                                        <td>{!! $item->atas_nama !!}</td>
                                        <td>{!! $item->asal !!}</td>
                                        <td>{!! $item->masa_berlaku_hgb !!}</td>
                                        <td>{!! $item->nama_bangunan !!}</td>
                                        <td>{!! $item->luas_bangunan !!}</td>
                                        <td>{!! $item->no_tgl_penerbitan_imb !!}</td>
                                        <td>{!! $item->njop !!}</td>
                                        <td>{!! $item->status_kelola !!}</td>
                                        <td>{!! $item->keberadaan_dokumen !!}</td>
                                        <td>{!! $item->keterangan !!}</td>
                                        <td>
                                            <div class="panel-footer text-right">

                                                <a href="{{ route('aset-jemaat.edit', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>

                                                {!! Form::open(['route' => ['aset-jemaat.destroy', $item->id], 'method' => 'delete', 'class' => 'element-inline']) !!}
                                                {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-sm warning-delete', 'type' => 'submit', 'data-title' => $item->kode_aset]) !!}
                                                {!! Form::close() !!}


                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="29">
                                            <div class="panel panel-default">
                                                <div class="panel-body text-center">
                                                    Tidak ada data aset jemaat. <a href="{{ route('aset-jemaat.create') }}" class="btn-link">Buat data baru.</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="m-section__content float-right">
                            {{ $aset_jemaat->appends($_GET)->links() }}
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