<div class="m-portlet__body">

    <div class="form-group m-form__group {{ $errors->has('id_mupel') ? 'has-error' : '' }}">
        {!! Form::label('id_mupel', 'Mupel') !!}
        {!! Form::select('id_mupel', $list_mupel, null, ['class' => 'form-control m-input m-input--square select2', 'id' => 'm_select2_1']) !!}
        {!! $errors->first('id_mupel', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('email') ? 'has-error' : '' }}">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Email']) !!}
        {!! $errors->first('email', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('no_telp') ? 'has-error' : '' }}">
        {!! Form::label('no_telp', 'No Telp') !!}
        {!! Form::text('no_telp', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'No Telp']) !!}
        {!! $errors->first('no_telp', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('nama') ? 'has-error' : '' }}">
        {!! Form::label('nama', 'Nama Jemaat Induk') !!}
        {!! Form::text('nama', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Nama']) !!}
        {!! $errors->first('nama', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('nama_kmj') ? 'has-error' : '' }}">
        {!! Form::label('nama_kmj', 'Nama KMJ') !!}
        {!! Form::text('nama_kmj', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Nama KMJ']) !!}
        {!! $errors->first('nama_kmj', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('email_kmj') ? 'has-error' : '' }}">
        {!! Form::label('email_kmj', 'Email KMJ') !!}
        {!! Form::text('email_kmj', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Email KMJ']) !!}
        {!! $errors->first('email_kmj', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('no_telp_kmj') ? 'has-error' : '' }}">
        {!! Form::label('no_telp_kmj', 'No Telp KMJ') !!}
        {!! Form::text('no_telp_kmj', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'No Telp KMJ']) !!}
        {!! $errors->first('no_telp_kmj', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('alamat_desa_kelurahan') ? 'has-error' : '' }}">
        {!! Form::label('alamat_desa_kelurahan', 'Alamat Lengkap') !!}
        {!! Form::textarea('alamat_desa_kelurahan', null, ['class' => 'form-control m-input m-input--square textarea', 'placeholder' => 'Alamat Lengkap', 'rows' => '5']) !!}
        {!! $errors->first('alamat_desa_kelurahan', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('id_propinsi') ? 'has-error' : '' }}">
        {!! Form::label('id_propinsi', 'Propinsi') !!}
        {!! Form::text('id_propinsi', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Propinsi']) !!}
        {!! $errors->first('id_propinsi', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('id_kabupaten') ? 'has-error' : '' }}">
        {!! Form::label('id_kabupaten', 'Kabupaten') !!}
        {!! Form::text('id_kabupaten', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Kabupaten']) !!}
        {!! $errors->first('id_kabupaten', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('id_kecamatan') ? 'has-error' : '' }}">
        {!! Form::label('id_kecamatan', 'Kecamatan', ['class' => 'control-label']) !!}
        {!! Form::text('id_kecamatan', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Kecamatan']) !!}
        {!! $errors->first('id_kecamatan', '<p style="color:red">:message</p>') !!}
    </div>

</div>

<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        {!! Form::button('<i class="fa fa-send"></i> Simpan', ['class'=>'btn btn-metal btn-success', 'type' => 'submit', 'id' => 'assignmentSubmit']) !!}
    </div>
</div>