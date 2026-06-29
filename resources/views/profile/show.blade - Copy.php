<x-app-layout>
  
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    @section('content')
  
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                {{-- @livewire('update-profile-photo') --}}
                @livewire('update-profile-photo')

                <x-jet-section-border />
            @endif

            <!-- Service & Division update -->
            <div class="mt-10 sm:mt-0">
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Update Service & Division</h3>
                    <p class="mt-1 text-sm text-gray-600">Change your Service Region and Division/Section.</p>

                    <form method="POST" action="{{ route('user.update.service.division') }}" class="mt-6">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Service Region</label>
                                <select name="serreg_id" class="form-input rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">-- Select Service Region --</option>
                                    @foreach (App\Models\ServiceRegion::all() as $sr)
                                        <option value="{{ $sr->id }}" @if(auth()->user()->serreg_id == $sr->id) selected @endif>{{ $sr->service_region }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Division / Section</label>
                                <select name="divsec_id" class="form-input rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">-- Select Division/Section --</option>
                                    @foreach (App\Models\DivisionSection::all() as $ds)
                                        <option value="{{ $ds->id }}" @if(auth()->user()->divsec_id == $ds->id) selected @endif>{{ $ds->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25 transition">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures() && !auth()->user()->hasRole('Super Administrator'))
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
    @endsection
    @section('script')
    <script>
        $("#li_account_setting").addClass('active');
    </script>
    @endsection
</x-app-layout>
