@extends('layouts.app', [
    'namePage' => 'Login page',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'login',
    'backgroundImage' => asset('assets') . "/img/bg14.jpg",
])

@section('content')
    <div class="content">
        <div class="container">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="header bg-gradient-primary py-10 py-lg-2 pt-lg-12">
                <div class="container">
                    <div class="header-body text-center mb-7">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-md-9">
                                <p class="text-lead text-light mt-3 mb-0">
                                    @include('alerts.migrations_check')
                                </p>
                            </div>
                            <div class="col-lg-5 col-md-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 ml-auto mr-auto">

            <div class="card card-login card-plain">
                <div class="card-header ">
                <div class="logo-container">
                    <img src="{{ asset('assets/img/now-logo.png') }}" alt="">
                </div>
                </div>
                <div class="card-body ">
                <div class="input-group no-border form-control-lg {{ $errors->has('email') ? ' has-danger' : '' }}">
                    <span class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="now-ui-icons users_circle-08"></i>
                    </div>
                    </span>
                    <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" placeholder="{{ __('Email') }}" type="email" name="email" required autofocus>
                </div>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <div class="input-group no-border form-control-lg {{ $errors->has('password') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="now-ui-icons objects_key-25"></i></i>
                    </div>
                    </div>
                    <input placeholder="Password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="{{ __('Password') }}" type="password" required>
                </div>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                </div>
                <div class="card-footer ">
                <button  type = "submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">{{ __('Get Started') }}</button>
                {{-- <div class="pull-left">
                    <h6>
                    <a href="{{ route('register') }}" class="link footer-link">{{ __('Create Account') }}</a>
                    </h6>
                </div> --}}
                {{-- <div class="pull-right">
                    <h6>
                    <a href="{{ route('password.request') }}" class="link footer-link">{{ __('Forgot Password?') }}</a>
                    </h6>
                </div> --}}
                </div>
            </div>

        </div>
        </div>
    </div>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
        demo.checkFullPageBackgroundImage();
        $(".btn-lg").click( function() {

var email = $("#email").val();
var password = $("#password").val();
var token = $("meta[name='csrf-token']").attr("content");

if(email.length == "") {

    Swal.fire({
        type: 'warning',
        title: 'Oops...',
        text: 'Alamat Email Wajib Diisi !'
    });

} else if(password.length == "") {

    Swal.fire({
        type: 'warning',
        title: 'Oops...',
        text: 'Password Wajib Diisi !'
    });

} else {

    $.ajax({

        url: "{{ route('actionlogin') }}",
        type: "POST",
        dataType: "JSON",
        cache: false,
        data: {
            "email": email,
            "password": password,
            "_token": token
        },

        success:function(response){

            if (response.success) {

                Swal.fire({
                    type: 'success',
                    title: 'Login Berhasil!',
                    text: 'Anda akan di arahkan dalam 3 Detik',
                    timer: 3000,
                    showCancelButton: false,
                    showConfirmButton: false
                })
                    .then (function() {
                        window.location.href = "{{ route('home') }}";
                    });

            } else {

                console.log(response.success);

                Swal.fire({
                    type: 'error',
                    title: 'Login Gagal!',
                    text: 'silahkan coba lagi!'
                });

            }

            console.log(response);

        },

        error:function(response){

            Swal.fire({
                type: 'error',
                title: 'Opps!',
                text: 'server error!'
            });

            console.log(response);

        }

    });

}

});
        });
    </script>
@endpush
