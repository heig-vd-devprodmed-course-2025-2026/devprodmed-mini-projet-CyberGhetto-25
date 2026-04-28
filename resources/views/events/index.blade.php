<x-default-layout>
    <x-slot:title>
        {{ __('ui.events.title') }}
    </x-slot>

    <x-slot:description>
        {{ __('ui.events.description') }}
    </x-slot>

    <h1 class="text-2xl font-bold dark:text-white">
        {{ __('ui.events.title') }}
    </h1>

    <p class="mt-4 dark:text-gray-300">
        {{ __('ui.events.description') }}
    </p>

    @can('create', App\Models\Event::class)
        <a href="{{ url('/events/create') }}"
            class="mt-6 block w-full px-4 py-2 bg-amber-500 bg-amber-700 text-white rounded-md hover:bg-amber-600 hover:bg-amber-600 text-center">
            {{ __('ui.events.create.title') }}
        </a>
    @endcan

    <div class="mt-8 space-y-6">
        @forelse ($events as $event)
            <x-event-card :event="$event" />
        @empty
            <p class="text-center text-gray-500 dark:text-gray-400">
                {{ __('ui.events.no_events') }}
            </p>
        @endforelse
    </div>
</x-default-layout>