<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo/>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        <div class="text-center">Please give feedback</div>

        <form method="POST" action="{{ route('update-feedback') }}">
            @csrf
            <div>
                <x-jet-input id="feedback_id" class="block mt-1 w-full" type="hidden" name="feedback_id"
                             value="{{$feedback}}"/>
            </div>
            <div>
                <x-jet-input id="rating" class="block mt-1 w-full" type="hidden" name="rating" value="{{$rating}}"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="Review" value="{{ __('Review') }}"/>
                <x-jet-input id="review" class="block mt-1 w-full" type="review" name="review" value=""
                             required/>
            </div>


            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Submit') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
