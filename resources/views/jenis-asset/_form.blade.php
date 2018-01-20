<div class="form-group {{ $errors->has('nama') ? 'has-error' : '' }}">
	{!! Form::label('nama', 'Nama Jenis Aset', ['class' => 'control-label']) !!}
	{!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama']) !!}
	{!! $errors->first('nama', '<p class="m--font-danger">:message</p>') !!}
</div>

<div class="form-group">
	{!! Form::button('<i class="fa fa-send"></i> Simpan', ['class'=>'btn btn-flat btn-success', 'type' => 'submit']) !!}
</div>