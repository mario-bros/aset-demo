@inject('JemaatInduk', 'App\Models\JemaatInduk')
@inject('Request', 'Illuminate\Http\Request')

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

            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                        <a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                            All
                        </a>
                        <div class="m-dropdown__wrapper">
                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 36.5px;"></span>
                            <div class="m-dropdown__inner">
                                <div class="m-dropdown__body">
                                    <div class="m-dropdown__content">
                                        <ul class="m-nav">
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                    <span class="m-nav__link-text">Activity</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                    <span class="m-nav__link-text">Messages</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                    <span class="m-nav__link-text">FAQ</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                    <span class="m-nav__link-text">Support</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="m-portlet__body">

            <!--begin::Section-->
            <div class="m-section">
                <div class="m-section__sub">
                    <header class="panel-heading">

                        @can('create-new-jemaat')
                            <a href="{{ route('form-jemaat-induk.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Jemaat Induk Baru</a>
                        @endcan

                        <div class="m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light m-list-search m-list-search--skin-light" style="float: right; width: 25rem;">

                            <div class="m-dropdown__wrapper">
                                <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                <div class="m-dropdown__inner ">
                                    <div class="m-dropdown__header">
                                        {!! Form::open(['route' => 'form-jemaat-induk.search', 'class' => "m-list-search__form", 'id' => "search_form", 'method' => "GET"]) !!}
                                            <div class="m-list-search__form-wrapper" >
                                                
                                                <div class="form-group m-form__group" style="float: left; width: 50%">
                                                    <input type="text" name="search_key" class="form-control m-input m-input--air m-input--pill" placeholder="Search" value="{{ $Request->get('search_key') }}">
                                                </div>

                                                <div class="form-group m-form__group" style="float: left; width: 50%">
                                                    <select class="form-control m-input" name="category" id="test">
                                                        <option value="">Cari Berdasarkan</option>
                                                        <option value="{{ $JemaatInduk::FIELD_NAMA_MUPEL_FILTER }}" >Nama Mupel</option>
                                                        <option value="{{ $JemaatInduk::FIELD_NAMA_JEMAAT_FILTER }}">Nama Jemaat</option>
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
                        {{ $jemaat_induk->appends($_GET)->links() }}
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Mupel</th>
                                <th>Nama Jemaat</th>
                                <th>Nama KMJ</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($jemaat_induk as $idx => $item)
                                <tr>
                                    <th scope="row">{{ $jemaat_induk->perPage() * ($jemaat_induk->currentPage() - 1) + ($idx+1) }}</th>
                                    <td>{{ $item->mupel->nama }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{!! $item->nama_kmj !!}</td>
                                    <td>
                                        <div class="panel-footer text-right">

                                            @can('edit-jemaat', $item)
                                                <a href="{{ route('form-jemaat-induk.edit', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                            @endcan

                                            @can('delete-jemaat', $item)
                                                {!! Form::open(['route' => ['form-jemaat-induk.destroy', $item->id], 'method' => 'delete', 'class' => 'element-inline']) !!}
                                                    {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-sm warning-delete', 'type' => 'submit', 'data-title' => $item->nama]) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="panel panel-default">
                                            <div class="panel-body text-center">
                                                Tidak ada data jemaat induk sama sekali. <a href="{{ route('form-jemaat-induk.create') }}" class="btn-link">Buat data.</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="m-section__content float-right">
                        {{ $jemaat_induk->appends($_GET)->links() }}
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