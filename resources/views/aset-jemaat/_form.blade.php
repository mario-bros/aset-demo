<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="m-portlet__body">

    <div class="form-group m-form__group {{ $errors->has('id_jemaat_induk') ? 'has-error' : '' }}">
        {!! Form::label('id_jemaat_induk', 'Jemaat Induk') !!}
        {!! Form::select('id_jemaat_induk', $list_jemaat_induk, null, ['class' => 'form-control m-input m-input--square select2', 'id' => 'm_select2_1']) !!}
        {!! $errors->first('id_jemaat_induk', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('kode_aset') ? 'has-error' : '' }}">
        {!! Form::label('kode_aset', 'Kode Aset') !!}
        {!! Form::text('kode_aset', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Kode Aset', 'readonly' => ($aset_jemaat->isDirty() == true) ? true : false,'id' => 'kode_aset']) !!}
        {!! $errors->first('kode_aset', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('jenis_asset') ? 'has-error' : '' }}">
        {!! Form::label('jenis_asset', 'Jenis Aset') !!}
        {!! Form::select('jenis_asset', $list_jenis_aset, null, ['class' => 'form-control m-input m-input--square select2', 'id' => 'jenis_aset_input']) !!}
        {!! $errors->first('jenis_asset', '<p style="color:red">:message</p>') !!}
        <br/><br/>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#m_modal_jenis_aset" >Tambah Jenis Aset</button>

        <!--begin::Modal-->
        <div class="modal fade" id="m_modal_jenis_aset" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Jenis Aset Baru</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form >
                            <div class="form-group">
                                <label for="recipient-name" class="form-control-label">Input:</label>
                                <input type="text" class="form-control" id="jenis-aset-additional" >
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="add-jenis-aset">Add Jenis Aset</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal-->
    </div>

    <div class="form-group m-form__group {{ $errors->has('alamat_desa_kelurahan') ? 'has-error' : '' }}">
        {!! Form::label('alamat_persil_desa_kelurahan', 'Alamat Desa Kelurahan') !!}
        {!! Form::textarea('alamat_persil_desa_kelurahan', null, ['class' => 'form-control m-input m-input--square textarea', 'placeholder' => 'Alamat Desa Kelurahan', 'rows' => '5']) !!}
        {!! $errors->first('alamat_persil_desa_kelurahan', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('kecamatan_persil') ? 'has-error' : '' }}">
        {!! Form::label('kecamatan_persil', 'Kecamatan') !!}
        {!! Form::text('kecamatan_persil', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Kecamatan']) !!}
        {!! $errors->first('kecamatan_persil', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('kabupaten_persil') ? 'has-error' : '' }}">
        {!! Form::label('kabupaten_persil', 'Kabupaten') !!}
        {!! Form::text('kabupaten_persil', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Kabupaten']) !!}
        {!! $errors->first('kabupaten_persil', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('propinsi_persil') ? 'has-error' : '' }}">
        {!! Form::label('propinsi_persil', 'Propinsi') !!}
        {!! Form::text('kabupaten_persil', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Propinsi']) !!}
        {!! $errors->first('kabupaten_persil', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('tanggal_terbit_surat_ukur') ? 'has-error' : '' }}">
        {!! Form::label('tanggal_terbit_surat_ukur', 'Tanggal Terbit Surat Ukur') !!}
        {!! Form::text('tanggal_terbit_surat_ukur', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Tanggal Terbit Surat Ukur']) !!}
        {!! $errors->first('tanggal_terbit_surat_ukur', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('no_surat_ukur') ? 'has-error' : '' }}">
        {!! Form::label('no_surat_ukur', 'No Surat Ukur') !!}
        {!! Form::text('no_surat_ukur', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'No Surat Ukur']) !!}
        {!! $errors->first('no_surat_ukur', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('luas_tanah') ? 'has-error' : '' }}">
        {!! Form::label('luas_tanah', 'Luas Tanah') !!}
        {!! Form::text('luas_tanah', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Luas Tanah']) !!}
        {!! $errors->first('luas_tanah', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group }}">
        {!! Form::label('status_kepemilikan', 'Status Kepemilikan') !!}

        <div class="m-radio-list">
            <label class="m-radio m-radio--state-success">
                {{ Form::radio('status_kepemilikan', "status_kepemilikan_hm", null, ['class' => 'form-control m-input m-input--square', 'id' => "StatusKepemilikanHM", 'checked' => ($aset_jemaat->status_kepemilikan == $aset_jemaat::$statusKepemilikanEnums['status_kepemilikan_hm']) ? true : false]) }} Hak Milik
                <span></span>
            </label>

            <label class="m-radio m-radio--state-success">
                {{ Form::radio('status_kepemilikan', "status_kepemilikan_hgb", null, ['class' => 'form-control m-input m-input--square', 'id' => "StatusKepemilikanHGB", 'checked' => ($aset_jemaat->status_kepemilikan == $aset_jemaat::$statusKepemilikanEnums['status_kepemilikan_hgb']) ? true : false]) }} HGB
                <span></span>
            </label>


            <label class="m-radio m-radio--state-success">
                {{ Form::radio('status_kepemilikan', "status_kepemilikan_hp", null, ['class' => 'form-control m-input m-input--square', 'id' => "StatusKepemilikanHP", 'checked' => ($aset_jemaat->status_kepemilikan == $aset_jemaat::$statusKepemilikanEnums['status_kepemilikan_hp']) ? true : false]) }} Hak Pakai
                <span></span>
            </label>

            <label class="m-radio m-radio--state-success">
                {{ Form::radio('status_kepemilikan', "status_kepemilikan_girik", null, ['class' => 'form-control m-input m-input--square', 'id' => "StatusKepemilikanGirik", 'checked' => ($aset_jemaat->status_kepemilikan == $aset_jemaat::$statusKepemilikanEnums['status_kepemilikan_girik']) ? true : false]) }} Girik
                <span></span>
            </label>

            <label class="m-radio m-radio--state-success">
                {{ Form::radio('status_kepemilikan', "status_kepemilikan_lain_lain", null, ['class' => 'form-control m-input m-input--square', 'id' => "StatusKepemilikanLainLain", 'checked' => ($aset_jemaat->status_kepemilikan == $aset_jemaat::$statusKepemilikanEnums['status_kepemilikan_lain_lain']) ? true : false]) }} Lain-lain
                <span></span>
            </label>
        </div>

        {!! $errors->first('status_kepemilikan', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('tgl_pengeluaran_sertifikat_surat') ? 'has-error' : '' }}">
        {!! Form::label('tgl_pengeluaran_sertifikat_surat', 'Tanggal Pengeluaran Sertifikat Surat') !!}
        {!! Form::text('tgl_pengeluaran_sertifikat_surat', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Tanggal Pengeluaran Sertifikat Surat']) !!}
        {!! $errors->first('tgl_pengeluaran_sertifikat_surat', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group }}">
        {!! Form::label('atas_nama', 'Atas Nama') !!}

        <div class="m-radio-list">
            <label class="m-radio m-radio--state-success">
                {{ Form::radio('atas_nama', "gpib", null, ['class' => 'form-control m-input m-input--square', 'id' => "GPIB", 'checked' => ($aset_jemaat->atas_nama == $aset_jemaat::$atasNamaEnums['gpib']) ? true : false]) }} GPIB
                <span></span>
            </label>

            <label class="m-radio m-radio--state-success">
                {{ Form::radio('atas_nama', "gpib_setempat", null, ['class' => 'form-control m-input m-input--square', 'id' => "GPIBSetempat", 'checked' => ($aset_jemaat->atas_nama == $aset_jemaat::$atasNamaEnums['gpib_setempat']) ? true : false]) }} GPIB Setempat
                <span></span>
            </label>

            <label class="m-radio m-radio--state-success">
                {{ Form::radio('atas_nama', "pribadi", null, ['class' => 'form-control m-input m-input--square', 'id' => "AtasNamaPribadi", 'checked' => ($aset_jemaat->atas_nama == $aset_jemaat::$atasNamaEnums['pribadi']) ? true : false]) }} Pribadi
                <span></span>
            </label>

            <label class="m-radio m-radio--state-success">
                {{ Form::radio('atas_nama', "bukan_milik_gpib", null, ['class' => 'form-control m-input m-input--square', 'id' => "BukanMilikGPIB", 'checked' => ($aset_jemaat->atas_nama == $aset_jemaat::$atasNamaEnums['bukan_milik_gpib']) ? true : false]) }} Bukan Milik GPIB
                <span></span>
            </label>

            <label class="m-radio m-radio--state-success">
                @if ( @$model )
                    {{ Form::radio('atas_nama', "tanpa_status_kepemilikan", null, ['class' => 'form-control m-input m-input--square', 'id' => "TanpaStatusKepemilikan", 'checked' => ($aset_jemaat->atas_nama == $aset_jemaat::$atasNamaEnums['tanpa_status_kepemilikan']) ? true : false]) }} Tanpa Status Kepemilikan
                @else
                    {{ Form::radio('atas_nama', "tanpa_status_kepemilikan", null, ['class' => 'form-control m-input m-input--square', 'id' => "TanpaStatusKepemilikan", 'checked' => true ]) }} Tanpa Status Kepemilikan
                @endif
                <span></span>
            </label>
        </div>

        {!! $errors->first('atas_nama', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('asal') ? 'has-error' : '' }}">
        {!! Form::label('asal', 'Asal') !!}
        {!! Form::textarea('asal', null, ['class' => 'form-control m-input m-input--square textarea', 'placeholder' => 'Asal', 'rows' => '5']) !!}
        {!! $errors->first('asal', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('masa_berlaku_hgb') ? 'has-error' : '' }}">
        {!! Form::label('masa_berlaku_hgb', 'Masa Berakhir HGB') !!}
        {!! Form::date('masa_berlaku_hgb', null, ['class' => 'form-control m-input', 'placeholder' => 'Masa Berakhir HGB']) !!}
        {!! $errors->first('masa_berlaku_hgb', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('nama_bangunan') ? 'has-error' : '' }}">
        {!! Form::label('nama_bangunan', 'Nama Bangunan') !!}
        {!! Form::text('nama_bangunan', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Nama Bangunan']) !!}
        {!! $errors->first('nama_bangunan', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('warna_status_pos_pelkes') ? 'has-error' : '' }}">
        {!! Form::label('status_pos_pelkes', 'Status Pos Pelkes', ['style' => "color: #00B0F0"]) !!}

        <div class="m-radio-list">
            <label class="m-radio m-radio--state-success">
                {{ Form::radio('warna_status_pos_pelkes', "00B0F0", null, ['class' => 'form-control m-input m-input--square']) }} Punya Pos Pelkes
                <span></span>
            </label>

            <label class="m-radio m-radio--state-success">
                {{ Form::radio('warna_status_pos_pelkes', "000000", null, ['class' => 'form-control m-input m-input--square']) }} Bukan punya pos pelkes
                <span></span>
            </label>
        </div>

        {!! $errors->first('warna_status_pos_pelkes', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('warna_status_kepemilikan_dokumen_imb') ? 'has-error' : '' }}">
        {!! Form::label('warna_status_kepemilikan_dokumen_imb', 'Status Kepemilikan Dokumen IMB', ['style' => "color: #00B050"]) !!}

        <div class="m-radio-list">
            <label class="m-radio m-radio--state-success">
                {{ Form::radio('warna_status_kepemilikan_dokumen_imb', "00B050", null, ['class' => 'form-control m-input m-input--square', 'id' => "PunyaDokumenIMB"]) }} Punya IMB
                <span></span>
            </label>

            <label class="m-radio m-radio--state-success">
                {{ Form::radio('warna_status_kepemilikan_dokumen_imb', "000000", null, ['class' => 'form-control m-input m-input--square']) }} Belum Punya IMB
                <span></span>
            </label>
        </div>

        {!! $errors->first('warna_status_kepemilikan_dokumen_imb', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('njop') ? 'has-error' : '' }}">
        {!! Form::label('njop', 'NJOP') !!}
        {!! Form::text('njop', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'NJOP']) !!}
        {!! $errors->first('njop', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('status_kelola') ? 'has-error' : '' }}">
        {!! Form::label('status_kelola', 'Status Kelola') !!}
        {!! Form::text('status_kelola', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Status Kelola']) !!}
        {!! $errors->first('status_kelola', '<p class="m--font-danger">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('keberadaan_dokumen') ? 'has-error' : '' }}">
        {!! Form::label('keberadaan_dokumen', 'Keberadaan Dokumen') !!}
        {!! Form::select('keberadaan_dokumen', $list_keberadaan_dokumen, null, ['class' => 'form-control m-input m-input--square select2', 'id' => 'keberadaan_dokumen_input']) !!}
        {!! $errors->first('keberadaan_dokumen', '<p class="m--font-danger">:message</p>') !!}
        <br/><br/>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#m_modal_keberadaan_dokumen" >Tambah Keberadaan Dokumen</button>

        <!--begin::Modal-->
        <div class="modal fade" id="m_modal_keberadaan_dokumen" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Data keberadaan dokumen Baru</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form >
                            <div class="form-group">
                                <label for="recipient-name" class="form-control-label">Input:</label>
                                <input type="text" class="form-control" id="keberadaan-dokumen-additional" >
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="add-keberadaan-dokumen">Add Keberadaan Dokumen</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal-->
    </div>

    <div class="form-group m-form__group {{ $errors->has('keterangan') ? 'has-error' : '' }}">
        {!! Form::label('keterangan', 'Keterangan') !!}
        {!! Form::textarea('keterangan', null, ['class' => 'form-control m-input m-input--square textarea', 'placeholder' => 'Keterangan', 'rows' => '5']) !!}
        {!! $errors->first('keterangan', '<p class="m--font-danger">:message</p>') !!}
    </div>
    <!-- div class="form-group {{-- $errors->has('file') ? 'has-error' : '' --}}">
        {{-- !! Form::label('file', 'File', ['class' => 'control-label']) !! --}}
        {{-- !! Form::file('file', ['id' => 'file']) !! --}}
        {{-- !! $errors->first('file', '<p class="m--font-danger">:message</p>') !! --}}
        {{-- @if(isset($model) && $assignment->file)
            <p><i class="fa fa-paperclip"></i> {{ $assignment->file }}</p>
        @endif
        --}}
    </div -->

    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            {!! Form::button('<i class="fa fa-send"></i> Simpan', ['class'=>'btn btn-metal btn-success', 'type' => 'submit', 'id' => 'assignmentSubmit']) !!}
        </div>
    </div>
</div>