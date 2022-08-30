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
        padding: 70px 0;
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
        max-width: 30rem;
    }
    .ocdlogo{
        width: 120px;
        margin: 0 auto;
    }
    .h3{
        font-size: 18px;
        font-weight: bold;
        margin-top: 5px;
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
    .btnreg{
        margin-right: 35px;
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
        }
        .ocdlayout_head:after {
            bottom: -19px;
        }
        .btnreg{
            margin-right: 0px;
        }
    }
</style>
<x-guest-layout>
    <div class="ocdlayout">
        <div class="ocdlayout_head">
            <img class="ocdlogo" src="{{ asset('images/logo.png') }}" />
            <h3 class="h3">Department of National Defense</h3>
            <p class="p">Republic of the Philippines</p>
        </div>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <!-- <x-jet-authentication-card-logo /> -->
            </x-slot>

            <div class="mb-4 text-sm text-white">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div>
                    <!-- <x-jet-label for="password" value="{{ __('Password') }}" /> -->
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="{{ __('Password') }}" required autocomplete="current-password" autofocus />
                </div>

                <div class="flex justify-end mt-4">
                    <x-jet-button class="ml-4">
                        {{ __('Confirm') }}
                    </x-jet-button>
                </div>
            </form>
        </x-jet-authentication-card>
    </div>
</x-guest-layout>
