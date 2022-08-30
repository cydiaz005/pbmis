<style>
    .ocdlayout{
        display: table;
        table-layout: fixed;
        height: 100%;
        width: 100%;
    }
    .ocdlayout_head {
        display: table;
        table-layout: fixed;
        height: 100%;
        width: 100%;
        height: 40%;
        padding: 160px 81px 89px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        vertical-align: middle;
        position: relative;
        display: table-cell;
        text-align: center;
    }
    .ocdlayout_head:after{
        content: '';
        display: block;
        width: 0;
        height: 0;
        border-left: 28px solid transparent;
        border-right: 28px solid transparent;
        border-top: 20px solid #fff;
        border-bottom-width: 0;
        position: absolute;
        bottom: -20px;
        left: 50%;
        margin-left: -28px;
    }
    .ocdlayout .min-h-screen.flex.flex-col {
        display: table-row;
        vertical-align: top;
        height: 100%;
        background: #1c20ab;
    }
    .ocdlayout .w-full.bg-white {
        margin: 0 auto;
        margin-top: 50px;
        background: transparent;
        box-shadow: none;
        padding: 5px;
        max-width: 35rem;
    }
    .ocdlogo{
        width: 450px;
        margin: 0 auto;
    }
    .h3{
        font-size: 17px;
        font-weight: 600;
    }
    .p{
        font-size: 15px;
    }
    .d-inline-block{
        display: inline-block;
        margin-right: 5px;
    }
    button.bg-gray-800 {
        background: #EF8D42;
        margin-left: 0;
    }
    .hover\:bg-gray-700:hover {
        background: #c58250 !important;
    }
    .formtitle{
        margin: 10px 0 15px 0;
        font-weight:bold;
    }
    .forgpass{
        float:right;
        margin-right: 20px;
    }
    .text-indigo-600 {
        color: #EF8D42 !important;
    }
    @media(max-width:767px){
        .ocdlayout_head {
            padding: 50px 0;
        }
        .ocdlayout .w-full.bg-white {
            padding: 30px;
            margin-top: 15px;
        }
        .d-inline-block {
            display: block;
            margin-right: 0px;
        }
        .formtitle{
            margin-bottom: 25px;
        }
        button.bg-gray-800 {
            margin-top: 20px;
            margin-bottom: 15px;
        }
        .forgpass{
            margin-right: 0;
        }
        .ocdlayout_head:after {
            bottom: -19px;
        }
    }
    .h2 {
        font-size: 20px;
        font-weight: 700;
    }
    .system-title {
        font-size: 20px;
        font-weight: 700;
        color: #f57a1c
    }
</style>
<x-guest-layout>
    <div class="ocdlayout">
        <div class="ocdlayout_head">
            <img class="ocdlogo" src="{{ asset('images/ocd-logo.png') }}" />
            <!-- <h3 class="h3 mt-1">Republic of the Philippines</h3>
            <h3 class="h3">Department of National Defense</h3>
            <h2 class="h2">OFFICE OF THE CIVIL DEFENSE</h2> -->
            <br>
            <h3 class="system-title">PLANNING AND BUDGETING MANAGEMENT INFORMATION SYSTEM</h3>
        </div>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <!-- <x-jet-authentication-card-logo /> -->
            </x-slot>

            <x-jet-validation-errors class="mb-4" />
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="formtitle">
                    <h5 class="text-white">
                        Don't have an account?
                        <a style="text-decoration-color: #EF8D42;text-underline-offset: 5px;" 
                        class="underline" href="{{ route('register') }}">
                            Click here to Register.    
                        </a>
                    </h5>
                </div>
                <div class="d-inline-block">
                    <!-- <x-jet-label for="email" value="{{ __('Email') }}" /> -->
                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="{{ __('Email') }}" :value="old('email')" required autofocus />
                </div>

                <div class="d-inline-block mt-4">
                    <!-- <x-jet-label for="password" value="{{ __('Password') }}" /> -->
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="{{ __('Password') }}" required autocomplete="current-password" />
                </div>

                <div class="d-inline-block" style="margin-right:0;">
                    <x-jet-button class="ml-4">
                        {{ __('Log in') }}
                    </x-jet-button>
                </div>

                <div style="display:inline-block;" class="mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-white">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div style="display:inline-block;" class="forgpass mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-white" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </x-jet-authentication-card>
    </div>
</x-guest-layout>
