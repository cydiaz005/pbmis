<script src="{{asset('theme-alte3/plugins/jquery/jquery.min.js')}}"></script>
<style>
    button.bg-gray-800 {
        background: #EF8D42;
        margin-left: 0;
    }

    .hover\:bg-gray-700:hover {
        background: #c58250 !important;
    }

    .text-green-500 {
        color: var(--ocd-primary);
    }
</style>
<div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1 flex justify-between">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile photo.
            </p>
        </div>

        <div class="px-4 sm:px-0">

        </div>
    </div>


    <div class="mt-5 md:mt-0 md:col-span-2">
        <form enctype="multipart/form-data" method="POST" action="/user/{{auth()->user()->id}}/change-profile-photo">
            @method("PUT")
            @csrf
            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                <div class="grid grid-cols-6 gap-6">
                    <!-- Profile Photo -->
                    <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                        <!-- Profile Photo File Input -->
                        <input name="image" id="photo-input" type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            ">

                        <label class="block font-medium text-sm text-gray-700" for="photo">
                            Photo
                        </label>


                        <!-- Current Profile Photo -->

                        <div class="mt-2" x-show="! photoPreview">
                            @if(isset($user->profilePhoto))
                            <img src="{{ asset('public/images/'.$user->profilePhoto->url) }}" alt="" class="rounded-full h-20 w-20 object-cover">
                            @else
                            <img src="https://ui-avatars.com/api/?name={{$user->firstname}}&background=0D8ABC&color=fff" alt="User Image">
                            @endif
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div class="mt-2" x-show="photoPreview" style="display: none;">
                            <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center" x-bind:style="'background-image: url(\'' + photoPreview + '\');'" style="background-image: url('null');">
                            </span>
                        </div>
                        <label for="photo-input"  class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition mt-2 mr-2">
                            Select A New Photo
                        </label>

                        {{-- <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition mt-2 mr-2" x-on:click.prevent="$refs.photo.click()">
                            Select A New Photo
                        </button> --}}

                        @if(isset($user->profilePhoto))
                        {{-- <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition mt-2" wire:click="deleteProfilePhoto">
                    Remove Photo
                </button> --}}
                        @endif

                        <div class="mt-3">
                            <!-- Firstname -->
                            <div class="col-span-6 sm:col-span-4 mt-4">
                                <x-jet-label for="name" value="{{ __('Name') }}" />
                                <span>{{$user->firstname . ' ' . $user->lastname}}</span>
                                <x-jet-input-error for="name" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                <div x-data="{ shown: false, timeout: null }" x-init="window.livewire.find('eJ4Ol3ivCmbPDlZsRM3F').on('saved', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000);  })" x-show.transition.out.opacity.duration.1500ms="shown" x-transition:leave.opacity.duration.1500ms="" style="display: none;" class="text-sm text-gray-600 mr-3">
                    Saved.
                </div>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" wire:loading.attr="disabled" wire:target="photo">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    $("#li_account").addClass('active');
</script>