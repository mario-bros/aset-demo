<div class="m-portlet__body">

    {{ Form::hidden('access_data_type', $user->id_role) }}

    <div class="form-group m-form__group {{ $errors->has('first_name') ? 'has-error' : '' }}">
        {!! Form::label('nama depan', 'Nama Depan') !!}
        {!! Form::text('first_name', @$user_profile->first_name, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Nama Depan']) !!}
        {!! $errors->first('first_name', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('last_name') ? 'has-error' : '' }}">
        {!! Form::label('nama belakang', 'Nama Belakang') !!}
        {!! Form::text('last_name', @$user_profile->last_name, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'Nama Belakang']) !!}
        {!! $errors->first('last_name', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
        {!! Form::label('phone_number', 'No Handphone') !!}
        {!! Form::text('phone_number', @$user_profile->phone_number, ['class' => 'form-control m-input m-input--square', 'placeholder' => 'No Handphone']) !!}
        {!! $errors->first('phone_number', '<p style="color:red">:message</p>') !!}
    </div>

    <div class="form-group m-form__group {{ $errors->has('id_role') ? 'has-error' : '' }}">
        {!! Form::label('id_role', 'Roles') !!}
        {!! Form::select('id_role', $list_roles, $user_role, ['class' => 'form-control m-input m-input--square select2', 'id' => 'id_role']) !!}
        {!! $errors->first('id_role', '<p style="color:red">:message</p>') !!}
    </div>

    <div id="access_data">
    @php
        if ( $list_access_data != '' ) :
            $mode = 'mupel';
    @endphp
            @php
                if ( @$list_access_data_mupel != '' ) :
                    $mode = 'jemaat';
            @endphp
                    <div class="form-group m-form__group {{ $errors->has('access_data_mupel') ? 'has-error' : '' }}">
                        {!! Form::label('access_data_mupel',  'Mupel Jemaat') !!}
                        {!! Form::select('access_data_mupel', $list_access_data_mupel, $list_access_data_mupel_selected, ['class' => 'form-control m-input m-input--square select2', 'id' => 'm_select2_2']) !!}
                    </div>
            @php
                endif;
            @endphp

            <div class="form-group m-form__group {{ $errors->has('access_data') ? 'has-error' : '' }}">
                {!! Form::label('access_data',  'Akses Data ' . $mode ) !!}
                {!! Form::select('access_data', $list_access_data, @$user_profile->access_data[$mode], ['class' => 'form-control m-input m-input--square select2', 'id' => 'm_select2_3']) !!}
                {!! $errors->first('access_data', '<p style="color:red">:message</p>') !!}
            </div>
    @php
        endif;
    @endphp
    </div>

</div>

<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        {!! Form::button('<i class="fa fa-send"></i> Simpan', ['class'=>'btn btn-metal btn-success', 'type' => 'submit', 'id' => 'assignmentSubmit']) !!}
    </div>
</div>