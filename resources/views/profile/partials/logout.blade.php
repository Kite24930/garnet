<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Logout') }}
        </h2>
    </header>

    <form method="post" action="{{ route('logout') }}" class="">
        @csrf
        <x-primary-button>{{ __('Logout') }}</x-primary-button>
    </form>
</section>
