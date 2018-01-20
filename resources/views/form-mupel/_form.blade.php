<div class="m-portlet__body">

    <div class="form-group m-form__group {{ $errors->has('nama') ? 'has-error' : '' }}">
        {!! Form::label('nama', 'Nama Mupel') !!}
        {!! Form::text('nama', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Nama']) !!}
        {!! $errors->first('nama', '<p class="m--font-danger">:message</p>') !!}
    </div>

</div>

<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        {!! Form::button('<i class="fa fa-send"></i> Simpan', ['class'=>'btn btn-metal btn-success', 'type' => 'submit', 'id' => 'assignmentSubmit']) !!}
    </div>
</div>