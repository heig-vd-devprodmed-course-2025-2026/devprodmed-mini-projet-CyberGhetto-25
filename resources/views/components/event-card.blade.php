<article class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden">
    @if ($event->poster)
        <a href="{{ url('/events/' . $event->id) }}">
            <img src="{{ asset('storage/' . $event->poster) }}"
                alt="Affiche de {{ $event->title }}"
                class="w-full h-48 object-cover hover:opacity-90 transition">
        </a>
    @endif

    <div class="p-6">
        <div class="flex items-center justify-between mb-2">
            <a href="{{ url('/events/' . $event->id) }}" class="hover:underline">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ $event->title }}
                </h2>
            </a>
            @if ($event->genre)
                <span class="text-xs px-2 py-1 bg-teal-100 dark:bg-purple-900 text-teal-800 dark:text-purple-200 rounded-full">
                    {{ $event->genre }}
                </span>
            @endif
        </div>

        <div class="flex items-center gap-3 mb-3">
            <a href="{{ url('@' . $event->user->username) }}" class="hover:underline">
                <p class="font-semibold text-gray-900 dark:text-white">
                    {{ $event->user->first_name }} {{ $event->user->last_name }}
                </p>
            </a>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                📅 {{ \Carbon\Carbon::parse($event->date)->isoFormat('LLL') }}
            </p>
        </div>

        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
            📍 {{ $event->location }}
        </p>

        @if ($event->description)
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                {{ Str::limit($event->description, 150) }}
            </p>
        @endif

        <footer class="pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
                <span class="font-semibold">
                    {{ trans_choice('ui.events.participants_count', count($event->attendances)) }}
                </span>
                <a href="{{ url('/events/' . $event->id) }}"
                    class="px-4 py-2 bg-teal-600 dark:bg-purple-900 text-white rounded-md hover:bg-teal-700 dark:hover:bg-purple-800">
                    {{ __('ui.events.view_event') }}
                </a>
            </div>
        </footer>
    </div>
</article>