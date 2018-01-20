@inject('User', 'App\Models\User')
@inject('Request', 'Illuminate\Http\Request')

@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Form User
@endsection

@section('contentheader_title')
    User
@endsection

@section('script-stats')
<script>
$(document).ready(function() {

    $('#search_form select[name^="category"]').change( function () {
        $('#search_form').submit()
    });
});
</script>
@endsection

@section('main-content')
<div class="m-content">

    <!--begin::Portlet-->
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">{{ $page_title }}</h3>
                </div>
            </div>

        </div>

        <div class="m-portlet__body">

            <!--begin::Section-->
            <div class="m-section">
                <div class="m-section__sub">
                    <header class="panel-heading">

                        <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> User Baru</a>

                        <div class="m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light m-list-search m-list-search--skin-light" style="float: right; width: 25rem;">

                            <div class="m-dropdown__wrapper">
                                <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                <div class="m-dropdown__inner ">
                                    <div class="m-dropdown__header">
                                        {!! Form::open(['route' => 'users.search', 'class' => "m-list-search__form", 'id' => "search_form", 'method' => "GET"]) !!}
                                            <div class="m-list-search__form-wrapper" >

                                                <div class="form-group m-form__group" style="float: left; width: 50%">
                                                    <input type="text" name="search_key" class="form-control m-input m-input--air m-input--pill" placeholder="Search" value="{{ $Request->get('search_key') }}">
                                                </div>

                                                <div class="form-group m-form__group" style="float: left; width: 50%">
                                                    <select class="form-control m-input" name="category" id="test">
                                                        <option value="">Cari Berdasarkan</option>
                                                        <option value="{{ $User::FIELD_NAME_FILTER }}" >Nama</option>
                                                        <option value="{{ $User::FIELD_EMAIL_FILTER }}">Alamat Email</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {!! $errors->first('category', '<p style="color:red">:message</p>') !!}
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="m-dropdown__body">
                                        <div class="m-dropdown__scrollable m-scrollable" data-max-height="300" data-mobile-max-height="200">
                                            <div class="m-dropdown__content"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                </div>
                <br/><br/><br/>

                <div class="m-section__content">
                    <div class="m-section__content float-right">
                        {{ $users->appends($_GET)->links() }}
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat pada waktu</th>
                                <th>Diupdate pada waktu</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $idx => $item)
                                <tr>
                                    <th scope="row">{{ $users->perPage() * ($users->currentPage() - 1) + ($idx+1) }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{!! $item->roles()->first()->name !!}</td>
                                    <td>{!! $item->created_at !!}</td>
                                    <td>{!! $item->updated_at !!}</td>
                                    <td>
                                        <div class="form-check-inline">
                                            
                                            <a href="{{ route('users.profile', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-male"></i></a>

                                            <a href="{{ route('users.edit', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>

                                            {!! Form::open(['route' => ['users.destroy', $item->id], 'method' => 'delete', 'class' => 'element-inline']) !!}
                                                {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-sm warning-delete', 'type' => 'submit', 'data-title' => $item->name]) !!}
                                            {!! Form::close() !!}

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="panel panel-default">
                                            <div class="panel-body text-center">
                                                Tidak ada data user sama sekali. <a href="{{ route('users.create') }}" class="btn-link">Buat data.</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="m-section__content float-right">
                        {{ $users->appends($_GET)->links() }}
                    </div>
                </div>
            </div>
            <!--end::Section-->

        </div>
        <!--end::Form-->
    </div>
    <!--end::Portlet-->

</div>
@stop