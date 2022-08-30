{{-- <div  class="mt-10 p-3">
    <div class="font-semibold font-gray-700 text-lg">{{ $confirmationTitle }}</div>

    <div class="py-2">
        @if($divisionSectionId)
            Division/Section ID: {{ $divisionSectionId }}
        @endif
        @if($divisionSectionIds)
            Division/Section IDS: @json($divisionSectionIds)
        @endif
        <div class="font-normal text-gray-600">{{ $confirmationDescription }}</div>
        <div class="space-x-2 flex justify-end mt-3">
            <button class="bg-gray-200 cursor-pointer text-black border border-gray-400 px-3 py-2 m-1 rounded text-sm"
                    wire:click="cancel">
                Cancel
            </button>
            <button class="bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm"
                    wire:click="confirm">
                Confirm
            </button>
        </div>
    </div>

</div> --}}