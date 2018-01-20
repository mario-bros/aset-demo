<div class="m-portlet__body">

    <div class="form-group {{ $errors->has('file') ? 'has-error' : '' }}">
        {!! Form::label('file', 'File', ['class' => 'control-label']) !!}
        {!! Form::file('file', ['id' => 'file']) !!}
        {!! $errors->first('file', '<p class="m--font-danger">:message</p>') !!}
    </div>

</div>

<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        {!! Form::button('<i class="fa fa-send"></i> Simpan', ['class'=>'btn btn-metal btn-success', 'type' => 'submit', 'id' => 'assignmentSubmit']) !!}
    </div>
</div>