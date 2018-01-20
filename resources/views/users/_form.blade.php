<div class="m-portlet__body">

    <div class="form-group m-form__group {{ $errors->has('name') ? 'has-error' : '' }}">
        {!! Form::label('nama', 'Nama User') !!}
        {!! Form::text('name', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Nama']) !!}
        {!! $errors->first('name', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('email') ? 'has-error' : '' }}">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Email']) !!}
        {!! $errors->first('email', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('password_baru') ? 'has-error' : '' }}">
        {!! Form::label('password_baru', 'Password Baru') !!}
        {!! Form::password('password_baru', ['class' => 'form-control m-input m-input--square']) !!}
        {!! $errors->first('password_baru', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('password_baru_confirmation') ? 'has-error' : '' }}">
        {!! Form::label('password_baru_confirmation', 'Konfirmasi Password Baru') !!}
        {!! Form::password('password_baru_confirmation', ['class' => 'form-control m-input m-input--square']) !!}
        {!! $errors->first('password_baru_confirmation', '<p style="color:red">:message</p>') !!}
    </div>

</div>

<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        {!! Form::button('<i class="fa fa-send"></i> Simpan', ['class'=>'btn btn-metal btn-success', 'type' => 'submit', 'id' => 'assignmentSubmit']) !!}
    </div>
</div>