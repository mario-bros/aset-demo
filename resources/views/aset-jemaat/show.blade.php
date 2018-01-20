@inject('JemaatInduk', 'App\Models\JemaatInduk')
@inject('Request', 'Illuminate\Http\Request')

@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Detail Aset Jemaat
@endsection

@section('contentheader_title')
    Aset Jemaat
@endsection

@section('main-content')
<style type="text/css">
.resp-map-container{
    padding-top: 56.25%;
    position: relative;
    overflow: hidden;
}

.resp-iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}
</style>

<div class="m-content">

    <!--begin::Portlet-->
    <div class="m-portlet">

        <div class="m-portlet__body">

            <!--begin::Section-->
            <div class="m-section">

                <div class="m-section__sub">
                    <header class="panel-heading">
                        @can('edit-aset-jemaat', $aset_jemaat)
                            <a href="{{ route('aset-jemaat.edit', $aset_jemaat->id) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Edit</a>
                        @endcan
                    </header>
                </div>

                <div class="m-section__content">
                    <div class="table-responsive">
                        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                            <thead>
                            <tr>
                                <th>Data Aset Jemaat #{{ $aset_jemaat->kode_aset }}</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr >
                                    <td style="font-weight: bold">Nama Jemaat</td>
                                    <td>{{ $aset_jemaat->jemaat->nama }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Jenis Aset</td>
                                    <td>{{ $aset_jemaat->jenis_asset }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Alamat</td>
                                    <td>{{ $aset_jemaat->alamat_persil_desa_kelurahan }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Kecamatan</td>
                                    <td>{{ $aset_jemaat->kecamatan_persil }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Kabupaten</td>
                                    <td>{{ $aset_jemaat->kabupaten_persil }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Propinsi</td>
                                    <td>{{ $aset_jemaat->propinsi_persil }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Tanggal Terbit Surat Ukur</td>
                                    <td>{{ $aset_jemaat->tanggal_terbit_surat_ukur }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">No Surat Ukur</td>
                                    <td>{{ $aset_jemaat->no_surat_ukur }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Luas Tanah</td>
                                    <td>{{ $aset_jemaat->luas_tanah }}</td>
                                </tr>

                                <tr>
                                    <td style="font-weight: bold">Status Kepemilikan</td>
                                    <td>
                                        {{ $aset_jemaat->status_kepemilikan }}  
                                        @php
                                            if ( $aset_jemaat->status_kepemilikan ) {
                                                echo "( " . $aset_jemaat->$status_kepemilikan_variant . " )";
                                            }
                                        @endphp
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-weight: bold">Tanggal Pengeluaran Sertifikat</td>
                                    <td>{{ $aset_jemaat->tgl_pengeluaran_sertifikat_surat }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Atas Nama</td>
                                    <td>{{ $aset_jemaat->atas_nama }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Asal</td>
                                    <td>{{ $aset_jemaat->asal }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Masa Berakhir HGB</td>
                                    <td>{{ $aset_jemaat->masa_berlaku_hgb }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nama Bangunan</td>
                                    <td>{{ $aset_jemaat->nama_bangunan }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Luas Bangunan</td>
                                    <td>{{ $aset_jemaat->luas_bangunan }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">No Tgl Penerbitan IMB</td>
                                    <td>{{ $aset_jemaat->no_tgl_penerbitan_imb }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">NJOP</td>
                                    <td>{{ $aset_jemaat->njop }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Status Kelola</td>
                                    <td>{{ $aset_jemaat->status_kelola }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Keberadaan Dokumen</td>
                                    <td>{{ $aset_jemaat->keberadaan_dokumen }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Keterangan</td>
                                    <td>{!! $aset_jemaat->keterangan !!}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Waktu dibuat : </td>
                                    <td>{!! $aset_jemaat->created_at !!}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Waktu diupdate : </td>
                                    <td>{!! $aset_jemaat->updated_at !!}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">User yang membuat : </td>
                                    <td>{!! @$aset_jemaat->userCreatedBy->name !!}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">User yang mengupdate : </td>
                                    <td>{!! @$aset_jemaat->userUpdatedBy->name !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="m-section__sub">
                    <header class="panel-heading">
                        @can('edit-aset-jemaat', $aset_jemaat)
                        <a href="{{ route('aset-jemaat.edit', $aset_jemaat->id) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Edit</a>
                        @endcan
                    </header>
                </div>

                <div class="resp-map-container">
                    <iframe class="resp-iframe" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.291737273087!2d106.91231021414897!3d-6.225211862699696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698cb291751f89%3A0xb1cc2c3072978374!2sGereja+GPIB+Menara+Iman!5e0!3m2!1sid!2sid!4v1547368854885" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
            <!--end::Section-->

        </div>
        <!--end::Form-->
    </div>
    <!--end::Portlet-->

</div>
@stop