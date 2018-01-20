@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" >
        <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <a href="{{ url('/home') }}">
                        <img src="{{ url('assets/demo/demo3/media/img/logo/logo.png') }}" width="200rem" height="200rem" >
                    </a>
                </div>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            {{ trans('adminlte_lang::message.siginsession') }}
                        </h3>
                    </div>

                    <form class="m-login__form m-form" action="" method="post">
                        {{ csrf_field() }}

                        <div class="form-group m-form__group">
                            {!! Form::label('', 'Username', ['class' => "col-form-label col-lg-3 col-sm-12", 'style' => "color: white"]) !!}
                            <input class="form-control m-input" type="text" placeholder="Username" name="name" autocomplete="off">
                        </div>

                        <div class="form-group m-form__group">
                        {!! Form::label('', 'Password', ['class' => "col-form-label col-lg-3 col-sm-12", 'style' => "color: white"]) !!}
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
                        </div>
                        <div class="row m-login__form-sub">
                            <div class="col m--align-left m-login__form-left">
                                <label class="m-checkbox  m-checkbox--light" style="color: black">
                                    <input type="checkbox" name="remember">Remember me
                                    <span></span>
                                </label>
                            </div>
                            <div class="col m--align-right m-login__form-right" >
                                <a href="javascript:;" id="m_login_forget_password" class="m-link" style="color: black">
                                    Forget Password ?
                                </a>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <!-- button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                Sign In
                            </button -->

                            <button class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary" style="background-color: #9816f4; border-color: #9816f4; color: black">
                                Sign In
                            </button>
                        </div>
                    </form>

                </div>

                <div class="m-login__forget-password">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            {{ trans('adminlte_lang::message.forgotpassword') }}
                        </h3>
                        <div class="m-login__desc">
                            Enter your email to reset your password:
                        </div>
                    </div>
                    <form class="m-login__form m-form" action="">
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_forget_password_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                Request
                            </button>
                            &nbsp;&nbsp;
                            <button id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->
@stop
