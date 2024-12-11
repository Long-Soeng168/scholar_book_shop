@extends('layouts.isbn')

@section('content')
    {{-- Start Form Login --}}
    <style>
        @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Raleway, sans-serif;
        }

        body {
            background: linear-gradient(90deg, #C7C5F4, #776BCC);
        }

        .container_login_form {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding-top: 20px;
        }

        .screen {
            background: linear-gradient(90deg, #5D54A4, #7C78B8);
            position: relative;
            height: 600px;
            width: 360px;
            box-shadow: 0px 0px 24px #5C5696;
        }

        .screen__content {
            z-index: 1;
            position: relative;
            height: 100%;
        }

        .screen__background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            -webkit-clip-path: inset(0 0 0 0);
            clip-path: inset(0 0 0 0);
            overflow-x: hidden;
        }

        .screen__background__shape {
            transform: rotate(45deg);
            position: absolute;
        }

        .screen__background__shape1 {
            height: 520px;
            width: 520px;
            background: #FFF;
            top: -50px;
            right: 120px;
            border-radius: 0 72px 0 0;
        }

        .screen__background__shape2 {
            height: 220px;
            width: 220px;
            background: #6C63AC;
            top: -172px;
            right: 0;
            border-radius: 32px;
        }

        .screen__background__shape3 {
            height: 540px;
            width: 190px;
            background: linear-gradient(270deg, #5D54A4, #6A679E);
            top: -24px;
            right: 0;
            border-radius: 32px;
        }

        .screen__background__shape4 {
            height: 400px;
            width: 200px;
            background: #7E7BB9;
            top: 420px;
            right: 50px;
            border-radius: 60px;
        }

        .login {
            width: 365px;
            padding: 30px;
            padding-top: 110px;
        }

        .login__field {
            padding: 20px 0px;
            position: relative;
        }

        .login__icon {
            position: absolute;
            top: 30px;
            color: #7875B5;
        }

        .login__input {
            border: none;
            border-bottom: 2px solid #D1D1D4;
            background: none;
            padding: 10px;
            padding-left: 10px;
            font-weight: 700;
            width: 75%;
            transition: .2s;
        }

        .login__input:active,
        .login__input:focus,
        .login__input:hover {
            outline: none;
            border-bottom-color: #6A679E;
        }

        .login__submit {
            background: #fff;
            font-size: 14px;
            margin-top: 30px;
            padding: 16px 20px;
            border-radius: 26px;
            border: 1px solid #D4D3E8;
            text-transform: uppercase;
            font-weight: 700;
            display: flex;
            align-items: center;
            width: 100%;
            color: #4C489D;
            box-shadow: 0px 2px 2px #5C5696;
            cursor: pointer;
            transition: .2s;
        }

        .login__submit:active,
        .login__submit:focus,
        .login__submit:hover {
            border-color: #6A679E;
            outline: none;
        }

        .button__icon {
            font-size: 24px;
            margin-left: auto;
            color: #7875B5;
        }

        .social-login {
            position: absolute;
            height: 140px;
            width: 160px;
            text-align: center;
            bottom: 0px;
            right: 0px;
            color: #fff;
        }

        .social-icons {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .social-login__icon {
            padding: 20px 10px;
            color: #fff;
            text-decoration: none;
            text-shadow: 0px 0px 8px #7875B5;
        }

        .social-login__icon:hover {
            transform: scale(1.5);
        }


        .screen__background::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .screen__background {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        @media screen and (min-width: 1333px) {

            /* Styles for screens greater than 768px */
            .container_login_form {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
            }

            .screen {
                background: linear-gradient(90deg, #5D54A4, #7C78B8);
                position: relative;
                height: 560px;
                width: 560px;
                box-shadow: 0px 0px 24px #5C5696;
            }

            .screen__content {
                z-index: 1;
                position: relative;
                height: 100%;
            }

            .screen__background {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 0;
                -webkit-clip-path: inset(0 0 0 0);
                clip-path: inset(0 0 0 0);
                overflow-x: hidden;
            }

            .screen__background__shape {
                transform: rotate(45deg);
                position: absolute;
            }

            .screen__background__shape1 {
                height: 600px;
                width: 600px;
                background: #FFF;
                top: -50px;
                right: 180px;
                border-radius: 0 72px 0 0;
            }

            .screen__background__shape2 {
                height: 220px;
                width: 220px;
                background: #6C63AC;
                top: -172px;
                right: 0;
                border-radius: 32px;
            }

            .screen__background__shape3 {
                height: 540px;
                width: 190px;
                background: linear-gradient(270deg, #5D54A4, #6A679E);
                top: -24px;
                right: 0;
                border-radius: 32px;
            }

            .screen__background__shape4 {
                height: 400px;
                width: 200px;
                background: #7E7BB9;
                top: 420px;
                right: 50px;
                border-radius: 60px;
            }

            .login {
                width: 465px;
                padding: 30px;
                padding-top: 110px;
            }

            .login__field {
                padding: 20px 0px;
                position: relative;
            }

            .login__icon {
                position: absolute;
                top: 30px;
                color: #7875B5;
            }

            .login__input {
                border: none;
                font-size: 22px;
                border-bottom: 2px solid #D1D1D4;
                background: none;
                padding: 10px;
                padding-left: 10px;
                font-weight: 700;
                width: 75%;
                transition: .2s;
            }

            .login__input:active,
            .login__input:focus,
            .login__input:hover {
                outline: none;
                border-bottom-color: #6A679E;
            }

            .login__submit {
                background: #fff;
                font-size: 22px;
                margin-top: 30px;
                padding: 16px 20px;
                border-radius: 100px;
                border: 1px solid #D4D3E8;
                text-transform: uppercase;
                font-weight: 700;
                display: flex;
                align-items: center;
                width: 75%;
                color: #4C489D;
                box-shadow: 0px 2px 2px #5C5696;
                cursor: pointer;
                transition: .2s;
            }

            .login__submit:active,
            .login__submit:focus,
            .login__submit:hover {
                border-color: #6A679E;
                outline: none;
            }

            .button__icon {
                font-size: 24px;
                margin-left: auto;
                color: #7875B5;
            }

            .social-login {
                position: absolute;
                height: 140px;
                width: 160px;
                text-align: center;
                bottom: 0px;
                right: 0px;
                color: #fff;
            }

            .social-icons {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .social-login__icon {
                padding: 20px 10px;
                color: #fff;
                text-decoration: none;
                text-shadow: 0px 0px 8px #7875B5;
            }

            .social-login__icon:hover {
                transform: scale(1.5);
            }
        }
    </style>

    <main class="flex overflow-x-hidden">
        <div class="flex-col items-center justify-center flex-1 hidden gap-6 bg-white md:flex">
            <h2 class="text-4xl lg:text-6xl text-[#5D54A4] max-w-[60ch] text-center font-bold">
                Login
            </h2>
            <img class="w-[40ch] px-8" src="{{ asset('assets/images/website_infos/logo.png') }}" alt="">
        </div>
        <div class="flex flex-col items-center flex-1 gap-4 shrink-0 container_login_form">
            <div class="screen">
                <div class="relative screen__content">
                    <form class="login" method="POST" action="{{ url('/admin_login') }}">
                        @csrf
                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input type="text" class="login__input" placeholder="{{ __('messages.email') }}"
                                name="email" value="superadmin@gmail.com" {{-- value="{{ old('email') }}" --}}>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-lock"></i>
                            <input type="password" name="password" class="login__input" name="email"
                                value="superadmin_user_@password" placeholder="{{ __('messages.password') }}">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <button class="button login__submit">
                            <span class="button__text">{{ __('messages.loginNow') }}</span>
                            <i class="button__icon fas fa-chevron-right"></i>
                        </button>
                    </form>
                    {{-- <h3 class="absolute bottom-8 right-8">
                        <a class="flex gap-2 text-sm min-[1333px]:text-lg text-white rounded-md focus:outline-none whitespace-nowrap"
                            href="{{ url('publisher_register') }}">
                            <span>{{ __('messages.dontHasAccount') }} </span>
                            <strong class="underline hover:underline-offset-4">{{ __('messages.signUp') }}</strong>
                        </a>
                    </h3> --}}
                    {{-- <div class="social-login">
                        <h3>log in via</h3>
                        <div class="social-icons">
                            <a href="#" class="social-login__icon fab fa-instagram"></a>
                            <a href="#" class="social-login__icon fab fa-facebook"></a>
                            <a href="#" class="social-login__icon fab fa-twitter"></a>
                        </div>
                    </div> --}}
                </div>
                <div class="screen__background ">
                    <span class="screen__background__shape screen__background__shape4"></span>
                    <span class="screen__background__shape screen__background__shape3"></span>
                    <span class="screen__background__shape screen__background__shape2"></span>
                    <span class="screen__background__shape screen__background__shape1"></span>
                </div>
            </div>
            <div>
                <p class="px-2 pb-1 text-xl min-[1333px]:text-2xl text-white hover:underline">
                    <a href="https://alphalib.org/">
                        By : Alphalib
                    </a>
                </p>
            </div>
        </div>
    </main>



    </div>
@endsection
