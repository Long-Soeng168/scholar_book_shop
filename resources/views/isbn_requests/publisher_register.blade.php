@extends('layouts.isbn')

@section('content')
    <script src="https://www.google.com/recaptcha/api.js"></script>
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

        ::-webkit-scrollbar {
            display: none;
            overflow-y: scroll;
            /* Add the ability to scroll */
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }


        .container_login_form {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .screen {
            /* background: linear-gradient(90deg, #5D54A4, #7C78B8); */
            background-color: white;
            position: relative;
            /* height: 600px; */
            width: 100%;
            box-shadow: 0px 0px 24px #5C5696;
        }

        .screen::-webkit-scrollbar {
            display: none;
        }

        .screen__content::-webkit-scrollbar {
            display: none;
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
            width: 100%;
            padding: 30px;
            /* padding-top: 110px; */
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
            width: 100%;
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
    </style>

    <main class="flex mb-20 overflow-x-hidden">
        <div class="flex-1 max-w-lg px-4 pt-20 mx-auto">
            <div class="pb-10 screen">
                <p class="pt-4 text-3xl font-bold text-center text-slate-600">{{ __('messages.register') }}</p>
                <div class="">
                    <form id="register-form" class="login" method="POST" action="{{ url('/publisher_register') }}">
                        @csrf
                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input type="text" class="login__input" placeholder="{{ __('messages.email') }}"
                                name="email" value="{{ old('email') }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-lock"></i>
                            <input type="password" name="password" class="login__input"
                                placeholder="{{ __('messages.password') }}">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-lock"></i>
                            <input type="password" name="password_confirmation" class="login__input"
                                placeholder="{{ __('messages.confirmPassword') }}">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input type="text" class="login__input" placeholder="{{ __('messages.name') }}"
                                name="name" value="{{ old('name') }}">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input type="text" class="login__input" placeholder="{{ __('messages.address') }}"
                                name="address" value="{{ old('address') }}">
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input type="text" class="login__input" placeholder="{{ __('messages.phone') }}"
                                name="phone" value="{{ old('phone') }}">
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input type="text" class="login__input" placeholder="{{ __('messages.facebookName') }}"
                                name="facebookName" value="{{ old('facebookName') }}">
                            <x-input-error :messages="$errors->get('facebookName')" class="mt-2" />
                        </div>
                        <div class="">
                            <x-input-label for="userType" :value="__('messages.userType')" />
                            <x-select-option class="block w-full mt-1" id="userType" name="user_type">
                                <option value="">{{ __('messages.select') }}</option>
                                <option value="publisher" {{ old('user_type') == 'publisher' ? 'selected' : '' }}>
                                    {{ __('messages.publisher') }}
                                </option>
                                <option value="author" {{ old('user_type') == 'author' ? 'selected' : '' }}>
                                    {{ __('messages.author') }}
                                </option>
                                <option value="librarian" {{ old('user_type') == 'librarian' ? 'selected' : '' }}>
                                    {{ __('messages.librarian') }}
                                </option>
                                <option value="individual" {{ old('user_type') == 'individual' ? 'selected' : '' }}>
                                    {{ __('messages.individual') }}
                                </option>
                            </x-select-option>
                            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
                        </div>
                        <section class="mt-8">
                            <x-input-label class="text-xl font-bold" for="publicationsEachYear" :value="__('messages.publicationsEachYear')" />
                            <p class="mt-2 text-sm">Estimate the quantity of publications you produce each year:</p>
                            <div class="flex flex-wrap items-start gap-4 mt-4">
                                <label class="flex items-center space-x-2 whitespace-nowrap">
                                    <input type="radio" name="publicationsEachYear" value="less_than_1"
                                        class="border rounded"
                                        {{ old('publicationsEachYear') == 'less_than_1' ? 'checked' : '' }}>
                                    <span> {{ __('messages.lessThan1') }}</span>
                                </label>
                                <label class="flex items-center space-x-2 whitespace-nowrap">
                                    <input type="radio" name="publicationsEachYear" value="1_to_2" class="border rounded"
                                        {{ old('publicationsEachYear') == '1_to_2' ? 'checked' : '' }}>
                                    <span>1 - 2</span>
                                </label>
                                <label class="flex items-center space-x-2 whitespace-nowrap">
                                    <input type="radio" name="publicationsEachYear" value="3_to_10" class="border rounded"
                                        {{ old('publicationsEachYear') == '3_to_10' ? 'checked' : '' }}>
                                    <span>3 - 10</span>
                                </label>
                                <label class="flex items-center space-x-2 whitespace-nowrap">
                                    <input type="radio" name="publicationsEachYear" value="more_than_10"
                                        class="border rounded"
                                        {{ old('publicationsEachYear') == 'more_than_10' ? 'checked' : '' }}>
                                    <span> {{ __('messages.moreThan10') }}</span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('publicationsEachYear')" class="mt-2" />
                        </section>

                        <button class="button login__submit" class="g-recaptcha"
                            data-sitekey="6Le9fWcqAAAAAMHTv_-wYgdIBJdAh6gGniNbHCE8" data-callback='onSubmit'
                            data-action='submit'>
                            <span class="button__text"> {{ __('messages.signUpNow') }}</span>
                            <i class="button__icon fas fa-chevron-right"></i>
                        </button>
                    </form>
                    <h3 class="flex justify-end px-8 mt-10">
                        <a class="flex gap-2 text-sm text-purple-900 rounded-md focus:outline-none whitespace-nowrap"
                            href="{{ url('admin_login') }}">
                            <span>{{ __('messages.alreadyHasAccount') }} </span>
                            <strong class="underline hover:underline-offset-4"> {{ __('messages.login') }}</strong>
                        </a>
                    </h3>
                    {{-- <div class="social-login">
                        <h3>log in via</h3>
                        <div class="social-icons">
                            <a href="#" class="social-login__icon fab fa-instagram"></a>
                            <a href="#" class="social-login__icon fab fa-facebook"></a>
                            <a href="#" class="social-login__icon fab fa-twitter"></a>
                        </div>
                    </div> --}}
                </div>
                {{-- <div class="screen__background ">
                    <span class="screen__background__shape screen__background__shape4"></span>
                    <span class="screen__background__shape screen__background__shape3"></span>
                    <span class="screen__background__shape screen__background__shape2"></span>
                    <span class="screen__background__shape screen__background__shape1"></span>
                </div> --}}
            </div>
            <div class="flex justify-center">
                <p class="py-4 text-xl text-white hover:underline">
                    <a href="https://alphalib.org/">
                        By : Alphalib
                    </a>
                </p>
            </div>
        </div>
    </main>


    <script>
        function onSubmit(token) {
            document.getElementById("register-form").submit();
        }
    </script>
@endsection
