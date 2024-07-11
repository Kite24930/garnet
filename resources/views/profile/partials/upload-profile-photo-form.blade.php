<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __("Upload Profile Photo")}}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile photo.")}}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form action="{{ route('profile.icon') }}" method="POST" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        <div>
            <x-input-label for="icon" :value="__('Profile Photo')" />
            @if(auth()->user()->icon)
                <img id="iconPreview" src="{{ asset('storage/account/'.auth()->user()->id.'/'.auth()->user()->icon) }}" alt="{{ auth()->user()->name }}" class="w-20 h-20 rounded-full" />
            @else
                <img id="iconPreview" src="{{ asset('storage/person-circle.svg') }}" alt="{{ auth()->user()->name }}" class="w-20 h-20 rounded-full" />
            @endif
            <input type="file" name="icon" id="icon" class="mt-1 block w-full text-gray-600" required autofocus autocomplete="icon" />
            <x-input-error class="mt-2" :messages="$errors->get('icon')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'icon-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    <script>
        document.getElementById('icon').addEventListener('change', (e) => {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('iconPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
</section>
