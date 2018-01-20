@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Form User
@endsection

@section('contentheader_title')
    Users
@endsection

@section('script-stats')
<script>
$('#id_role').change( function(e) {
    let urlRequest = "{{ url('users/get-mupel-jemaat-by-role') }}"
    let $targetInputElem = $('#access_data')

    $.ajax({
        url: urlRequest,
        data: {
            inputVal: $(this).val()
        },
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .done( function(data) {
        $targetInputElem.html(data.input_template)

        if (data.role_selected == 'jemaat') {
            $('#m_select2_2').select2({
                placeholder: "Pilih Mupel"
            });

            $('#m_select2_3').select2({
                placeholder: "Pilih Jemaat"
            });


            filterJemaatByMupel();

        } else if (data.role_selected == 'mupel') {
            $('#m_select2_1').select2({
                placeholder: "Pilih Mupel"
            });
        }
        
    });
})

function filterJemaatByMupel() {
    $('#m_select2_2').change( function(e) {

        let urlRequest = "{{ url('aset-jemaat/get-jemaat-by-mupel') }}"
        let $targetInputElem = $('#m_select2_3')

        $.ajax({
            url: urlRequest,
            data: {
                inputVal: $(this).val()
            },
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done( function(data) {
            $targetInputElem.html(data.input_template)

        });
    })
}
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

        {!! Form::open(['route' => 'users.store', 'class' => "m-form m-form--fit m-form--label-align-right", "autocomplete" => "off"]) !!}
            @include('users._create_form', ['list_roles' => $list_roles])
        {!! Form::close() !!}
    </div>
    <!--end::Portlet-->

</div>
@stop