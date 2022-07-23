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
            <img class="ocdlogo" src="{{ asset('images/ocd-logo.png') }}" />
            
        </div>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <!-- <x-jet-authentication-card-logo /> -->
            </x-slot>

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="formtitle">
                    <h5 class="text-white">
                    {{ __('Already registered?') }}
                        <a style="text-decoration-color: #EF8D42;text-underline-offset: 5px;" 
                        class="underline" href="{{ route('login') }}">
                            Click here to Login.    
                        </a>
                    </h5>
                </div>

                <div class="mt-4" style="width:433px;">
                    <!-- <x-jet-label for="email" value="{{ __('Email') }}" /> -->
                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="{{ __('Email') }}" :value="old('email')" required />
                </div>

                <div class="d-inline-block mt-4">
                    <!-- <x-jet-label for="password" value="{{ __('Password') }}" /> -->
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="{{ __('Password') }}" required autocomplete="new-password" />
                </div>

                <div class="d-inline-block mt-4">
                    <!-- <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" /> -->
                    <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-jet-label for="terms">
                            <div class="flex items-center">
                                <x-jet-checkbox name="terms" id="terms"/>

                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-jet-label>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4 btnreg">
                    <x-jet-button class="ml-4">
                        {{ __('Register') }}
                    </x-jet-button>
                </div>
            </form>
        </x-jet-authentication-card>
    </div>
</x-guest-layout>
