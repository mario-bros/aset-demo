@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Form Jemaat
@endsection

@section('contentheader_title')
    Jemaat Induk
@endsection

@section('script-stats')
<script>

$(document).ready(function() {

    function addNewCollectionInput($additionalInputElem, $selectInputElem, $popUpModalElem, urlRequest) {

        let inputAdditionalVal = $additionalInputElem.val();

        $.ajax({
            url: urlRequest,
            data: {
                inputAdditionalVal: inputAdditionalVal
            },
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(function( data ) {

            if (data.isValid == 'true') {
                $selectInputElem.html(data.input_template);
                $popUpModalElem.modal('hide');
            } else {
                alert('data yang dimaksud sudah ada');
                $popUpModalElem.modal('hide');
            }

        });
    }



    $('#add-jenis-aset').click( function () {

        let $additionalInputElem = $('#jenis-aset-additional');
        let $selectInputElem = $('#jenis_aset_input');
        let $popUpModalElem = $('#m_modal_jenis_aset');
        let urlRequest = "{{ url('aset-jemaat/add-jenis-aset') }}";

        addNewCollectionInput($additionalInputElem, $selectInputElem, $popUpModalElem, urlRequest);
    });



    $('#add-status-kelola').click( function () {

        let $additionalInputElem = $('#status-kelola-additional');
        let $selectInputElem = $('#status_kelola_input');
        let $popUpModalElem = $('#m_modal_status_kelola');
        let urlRequest = "{{ url('aset-jemaat/add-status-kelola') }}";

        addNewCollectionInput($additionalInputElem, $selectInputElem, $popUpModalElem, urlRequest);
    });

    $('#add-keberadaan-dokumen').click( function () {

        let $additionalInputElem = $('#keberadaan-dokumen-additional');
        let $selectInputElem = $('#keberadaan_dokumen_input');
        let $popUpModalElem = $('#m_modal_keberadaan_dokumen');
        let urlRequest = "{{ url('aset-jemaat/add-keberadaan-dokumen') }}";

        addNewCollectionInput($additionalInputElem, $selectInputElem, $popUpModalElem, urlRequest);
    })



    let checkedIDStatusKepemilikanHGB = checkedIDStatusKepemilikanHM = checkedIDStatusKepemilikanHP = checkedIDStatusKepemilikanGirik = checkedIDStatusKepemilikanLainLain = 0;

    if ( $('input[type="radio"][name="status_kepemilikan"]').is(':checked') ) {
        checkedStatusKepemilikanVal = $('input[type="radio"][name="status_kepemilikan"]:checked').val()

        if (checkedStatusKepemilikanVal == "status_kepemilikan_hm") {
            checkedIDStatusKepemilikanHM++

            if (checkedIDStatusKepemilikanHM == 1) {
                let $inputMasaBerlakuHM = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("status_kepemilikan_hm", "Masa Berlaku HGBS") !!}' +
                                                '{!! Form::text("status_kepemilikan_hm", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Masa Berlaku HM"]) !!}' +
                                                '{!! $errors->first("status_kepemilikan_hm", "<p class=\'m--font-danger\'>:message</p>") !!}' +
                                            '</div>';

                $('input[type="radio"][name="status_kepemilikan"]:checked').parent().append($inputMasaBerlakuHM)
            }
        } else if (checkedStatusKepemilikanVal == "status_kepemilikan_hgb") {
            checkedIDStatusKepemilikanHGB++

            if (checkedIDStatusKepemilikanHGB == 1) {
                let $inputMasaBerlakuHGB = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("status_kepemilikan_hgb", "Masa Berlaku HGBS") !!}' +
                                                '{!! Form::text("status_kepemilikan_hgb", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Masa Berlaku HGB"]) !!}' +
                                                '{!! $errors->first("status_kepemilikan_hgb", "<p class=\'m--font-danger\'>:message</p>") !!}' +
                                            '</div>';

                $('input[type="radio"][name="status_kepemilikan"]:checked').parent().append($inputMasaBerlakuHGB)
            }
        } else if (checkedStatusKepemilikanVal == "status_kepemilikan_hp") {
            checkedIDStatusKepemilikanHP++

            if (checkedIDStatusKepemilikanHP == 1) {
                let $inputMasaBerlakuHP = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("status_kepemilikan_hp", "Masa Berlaku HGBS") !!}' +
                                                '{!! Form::text("status_kepemilikan_hp", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Masa Berlaku HP"]) !!}' +
                                                '{!! $errors->first("status_kepemilikan_hp", "<p class=\'m--font-danger\'>:message</p>") !!}' +
                                            '</div>';

                $('input[type="radio"][name="status_kepemilikan"]:checked').parent().append($inputMasaBerlakuHP)
            }
        } else if (checkedStatusKepemilikanVal == "status_kepemilikan_girik") {
            checkedIDStatusKepemilikanGirik++

            if (checkedIDStatusKepemilikanGirik == 1) {
                let $inputMasaBerlakuGirik = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("status_kepemilikan_girik", "Masa Berlaku HGBS") !!}' +
                                                '{!! Form::text("status_kepemilikan_girik", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Masa Berlaku Girik"]) !!}' +
                                                '{!! $errors->first("status_kepemilikan_girik", "<p class=\'m--font-danger\'>:message</p>") !!}' +
                                            '</div>';

                $('input[type="radio"][name="status_kepemilikan"]:checked').parent().append($inputMasaBerlakuGirik)
            }
        } else if (checkedStatusKepemilikanVal == "status_kepemilikan_lain_lain") {
            checkedIDStatusKepemilikanLainLain++

            if (checkedIDStatusKepemilikanLainLain == 1) {
                let $inputMasaBerlakuLainLain = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("status_kepemilikan_lain_lain", "Masa Berlaku HGBS") !!}' +
                                                '{!! Form::text("status_kepemilikan_lain_lain", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Masa Berlaku Lain - Lain"]) !!}' +
                                                '{!! $errors->first("status_kepemilikan_lain_lain", "<p class=\'m--font-danger\'>:message</p>") !!}' +
                                            '</div>';

                $('input[type="radio"][name="status_kepemilikan"]:checked').parent().append($inputMasaBerlakuLainLain)
            }
        }
    }

    $('input[type="radio"][name="status_kepemilikan"]').click( function() {

        if ( $(this).attr('id') == "StatusKepemilikanHM" ) {
            checkedIDStatusKepemilikanHM++

            if (checkedIDStatusKepemilikanHM == 1) {
                let $inputMasaBerlakuHM = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("status_kepemilikan_hm", "Masa Berlaku HM") !!}' +
                                                '{!! Form::text("status_kepemilikan_hm", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Masa Berlaku HM"]) !!}' +
                                            '</div>';

                $(this).parent().append($inputMasaBerlakuHM)
            }
        } else if ( $(this).attr('id') == "StatusKepemilikanHGB" ) {
            checkedIDStatusKepemilikanHGB++

            if (checkedIDStatusKepemilikanHGB == 1) {
                let $inputMasaBerlakuHGB = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("status_kepemilikan_hgb", "Masa Berlaku HGB") !!}' +
                                                '{!! Form::text("status_kepemilikan_hgb", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Masa Berlaku HGB"]) !!}' +
                                            '</div>';

                $(this).parent().append($inputMasaBerlakuHGB)
            }
        } else if ( $(this).attr('id') == "StatusKepemilikanHP" ) {
            checkedIDStatusKepemilikanHP++

            if (checkedIDStatusKepemilikanHP == 1) {
                let $inputMasaBerlakuHP = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("status_kepemilikan_hp", "Masa Berlaku HP") !!}' +
                                                '{!! Form::text("status_kepemilikan_hp", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Masa Berlaku HP"]) !!}' +
                                            '</div>';

                $(this).parent().append($inputMasaBerlakuHP)
            }
        } else if ( $(this).attr('id') == "StatusKepemilikanGirik" ) {
            checkedIDStatusKepemilikanGirik++

            if (checkedIDStatusKepemilikanGirik == 1) {
                let $inputMasaBerlakuGirik = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("status_kepemilikan_girik", "Masa Berlaku Girik") !!}' +
                                                '{!! Form::text("status_kepemilikan_girik", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Masa Berlaku Girik"]) !!}' +
                                            '</div>';

                $(this).parent().append($inputMasaBerlakuGirik)
            }
        } else if ( $(this).attr('id') == "StatusKepemilikanLainLain" ) {
            checkedIDStatusKepemilikanLainLain++

            if (checkedIDStatusKepemilikanLainLain == 1) {
                let $inputMasaBerlakuLainLain = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("status_kepemilikan_lain_lain", "Masa Berlaku lain - lain") !!}' +
                                                '{!! Form::text("status_kepemilikan_lain_lain", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Masa Berlaku Lain - lain"]) !!}' +
                                            '</div>';

                $(this).parent().append($inputMasaBerlakuLainLain)
            }
        }
    });



    let checkedIDAtasNamaJemaat = 0;

    if ( $('input[type="radio"][name="atas_nama"]').is(':checked') ) {
        checkedAtasNamaJemaatVal = $('input[type="radio"][name="status_nama"]:checked').val()

        if (checkedAtasNamaJemaatVal == "gpib_setempat") {
            checkedIDAtasNamaJemaat++

            if (checkedIDAtasNamaJemaat == 1) {
                let $inputAtasNamaJemaat = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("atas_nama_jemaat", "Atas Nama Jemaat") !!}' +
                                                '{!! Form::text("atas_nama_jemaat", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Atas Nama Jemaat"]) !!}' +
                                                '{!! $errors->first("atas_nama_jemaat", "<p class=\'m--font-danger\'>:message</p>") !!}' +
                                            '</div>';

                $('input[type="radio"][name="atas_nama"]:checked').parent().append($inputAtasNamaJemaat)
            }
        }
    }

    $('input[type="radio"][name="atas_nama"]').click( function() {
        
        if ( $(this).attr('id') == "GPIBSetempat" ) {

            checkedIDAtasNamaJemaat++
            if (checkedIDAtasNamaJemaat == 1) {
                let $inputAtasNamaJemaat = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("atas_nama_jemaat", "Atas Nama Jemaat") !!}' +
                                                '{!! Form::text("atas_nama_jemaat", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Atas Nama Jemaat"]) !!}' +
                                            '</div>';

                $(this).parent().append($inputAtasNamaJemaat)
            }
            
        }
    });



    let checkedIDAtasNamaPribadi = 0;

    if ( $('input[type="radio"][name="atas_nama"]').is(':checked') ) {
        checkedAtasNamaPribadiVal = $('input[type="radio"][name="status_nama"]:checked').val()

        if (checkedAtasNamaPribadiVal == "pribadi") {
            checkedIDAtasNamaPribadi++

            if (checkedIDAtasNamaPribadi == 1) {
                let $inputAtasNamaPribadi = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("atas_nama_pribadi", "Atas Nama Pribadi") !!}' +
                                                '{!! Form::text("atas_nama_pribadi", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Atas Nama Pribadi"]) !!}' +
                                                '{!! $errors->first("atas_nama_pribadi", "<p class=\'m--font-danger\'>:message</p>") !!}' +
                                            '</div>';

                $('input[type="radio"][name="atas_nama"]:checked').parent().append($inputAtasNamaPribadi)
            }
        }
    }

    $('input[type="radio"][name="atas_nama"]').click( function() {
        
        if ( $(this).attr('id') == "AtasNamaPribadi" ) {

            checkedIDAtasNamaPribadi++
            if (checkedIDAtasNamaPribadi == 1) {
                let $inputAtasNamaPribadi = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("atas_nama_pribadi", "Atas Nama Pribadi") !!}' +
                                                '{!! Form::text("atas_nama_pribadi", null, ["class" => "form-control m-input m-input--square", "placeholder" => "Atas Nama Pribadi"]) !!}' +
                                            '</div>';

                $(this).parent().append($inputAtasNamaPribadi)
            }
            
        }
    });



    let checkedIDPunyaDokumenIMB = 0;

    if ( $('input[type="radio"][name="warna_status_kepemilikan_dokumen_imb"]').is(':checked') ) {
        checkedPunyaDokumenIMBVal = $('input[type="radio"][name="warna_status_kepemilikan_dokumen_imb"]:checked').val()

        if (checkedPunyaDokumenIMBVal == "PunyaDokumenIMB") {
            checkedIDPunyaDokumenIMB++

            if (checkedIDPunyaDokumenIMB == 1) {
                let $inputPunyaDokumenIMB = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("no_tgl_penerbitan_imb", "No Tanggal Penerbitan IMB") !!}' +
                                                '{!! Form::text("no_tgl_penerbitan_imb", null, ["class" => "form-control m-input m-input--square", "placeholder" => "No Tanggal Penerbitan IMB"]) !!}' +
                                                '{!! $errors->first("no_tgl_penerbitan_imb", "<p class=\'m--font-danger\'>:message</p>") !!}' +
                                            '</div>';

                $('input[type="radio"][name="warna_status_kepemilikan_dokumen_imb"]:checked').parent().append($inputPunyaDokumenIMB)
            }
        }
    }

    $('input[type="radio"][name="warna_status_kepemilikan_dokumen_imb"]').click( function() {
        
        if ( $(this).attr('id') == "PunyaDokumenIMB" ) {

            checkedIDPunyaDokumenIMB++
            if (checkedIDPunyaDokumenIMB == 1) {
                let $inputPunyaDokumenIMB = '<div class="form-group m-form__group">' +
                                                '{!! Form::label("no_tgl_penerbitan_imb", "No Tanggal Penerbitan IMB") !!}' +
                                                '{!! Form::text("no_tgl_penerbitan_imb", null, ["class" => "form-control m-input m-input--square", "placeholder" => "No Tanggal Penerbitan IMB"]) !!}' +
                                            '</div>';

                $(this).parent().append($inputPunyaDokumenIMB)
            }
            
        }
    })

    $('#m_select2_1').change( function () {
        let listJemaatIndukVal = $(this).val()

        let $kodeAsetElem = $('#kode_aset');
        let urlRequest = "{{ url('aset-jemaat/generate-new-kode-aset') }}";

        $.ajax({
            url: urlRequest,
            data: {
                listJemaatIndukID: listJemaatIndukVal
            },
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done( function(data) {
            $kodeAsetElem.val(data.new_kode_aset)
        })
    });
});
</script>
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

        {!! Form::open(['route' => 'aset-jemaat.store', 'files' => true, 'class' => "m-form m-form--fit m-form--label-align-right"]) !!}
            @include('aset-jemaat._form')
        {!! Form::close() !!}
    </div>
    <!--end::Portlet-->

</div>
@stop