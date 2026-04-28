<x-default-layout>
    <x-slot:title>
        {{ $event->title }}
    </x-slot>

    <x-slot:description>
        {{ $event->title }} — {{ $event->location }}
    </x-slot>

    <article class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden">
        @if ($event->poster)
            <img src="{{ asset('storage/' . $event->poster) }}"
                alt="Affiche de {{ $event->title }}"
                class="w-full h-64 object-cover">
        @endif

        <div class="p-6">
            <div class="flex items-center justify-between mb-2">
                <h1 class="text-3xl font-bold dark:text-white">
                    {{ $event->title }}
                </h1>
                @if ($event->genre)
                    <span class="text-sm px-2 py-1 bg-amber-900 text-amber-300 rounded-full">
                        {{ $event->genre }}
                    </span>
                @endif
            </div>

            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                {{ __('ui.events.show.by', ['name' => $event->user->first_name . ' ' . $event->user->last_name]) }}
                &middot;
                📅 {{ \Carbon\Carbon::parse($event->date)->isoFormat('LLLL') }}
                &middot;
                📍 {{ $event->location }}
                @can('update', $event)
                    &middot;
                    <a href="{{ url('/events/' . $event->id . '/edit') }}"
                        class="text-amber-500 text-amber-400 hover:underline">
                        {{ __('ui.events.show.edit') }}
                    </a>
                @endcan
            </p>

            @if ($event->description)
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    {{ $event->description }}
                </p>
            @endif

            {{-- Boutons de participation --}}
            @auth
                <form method="POST" action="{{ url('/attendances/' . $event->id) }}" class="mb-6">
                    @csrf
                    @method('PUT')
                    <div class="flex gap-3">
                        <button type="submit" name="status" value="going"
                            class="flex-1 px-4 py-2 rounded-md font-semibold cursor-pointer transition
                                {{ $status === 'going'
                                    ? 'bg-amber-500 bg-amber-700 text-white'
                                    : 'bg-neutral-700 text-neutral-300 hover:bg-amber-700 hover:text-white'}}">
                            {{ __('ui.events.attendance.going') }}
                        </button>
                        <button type="submit" name="status" value="interested"
                            class="flex-1 px-4 py-2 rounded-md font-semibold cursor-pointer transition
                                {{ $status === 'interested'
                                    ? 'bg-amber-500 bg-amber-700 text-white'
                                    : 'bg-neutral-700 text-neutral-300 hover:bg-amber-700 hover:text-white'}}">
                            {{ __('ui.events.attendance.interested') }}
                        </button>
                    </div>
                </form>
            @endauth

            {{-- Liste des participants --}}
            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold dark:text-white mb-3">
                    {{ trans_choice('ui.events.participants_count', count($event->attendances)) }}
                </h2>
                <ul class="flex flex-wrap gap-2">
                    @forelse ($event->attendances as $attendee)
                        <li>
                            <a href="{{ url('@' . $attendee->username) }}"
                                class="flex items-center gap-1 text-sm px-3 py-1 rounded-full hover:underline
                                    {{ $attendee->pivot->status === 'going'
                                        ? 'bg-amber-900 text-amber-300'
                                        : 'bg-neutral-700 text-neutral-300' }}">
                                {{ $attendee->pivot->status === 'going' ? '✅' : '⭐' }}
                                {{ '@' . $attendee->username }}
                            </a>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('ui.events.show.no_attendees') }}
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </article>
</x-default-layout>