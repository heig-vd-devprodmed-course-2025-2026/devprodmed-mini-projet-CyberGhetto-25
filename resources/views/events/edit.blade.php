<x-default-layout>
    <x-slot:title>
        {{ __('ui.events.edit.title') }}
    </x-slot>

    <x-slot:description>
        {{ __('ui.events.edit.description') }}
    </x-slot>

    <article class="bg-white dark:bg-slate-800 rounded-lg shadow-md p-6">
        <header class="mb-6">
            <h1 class="text-3xl font-bold dark:text-white mb-2">
                {{ __('ui.events.edit.title') }}
            </h1>
        </header>

        <form method="POST" action="{{ url('/events/' . $event->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('ui.events.form.fields.title.label') }} *
                </label>
                <input id="title" type="text" name="title" value="{{ old('title', $event->title) }}" required
                    class="w-full px-3 py-2 border rounded-md bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:border-transparent @error('title') border-red-500 focus:ring-red-500 @else border-gray-300 dark:border-gray-600 focus:ring-teal-500 dark:focus:ring-purple-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('ui.events.form.fields.description.label') }}
                </label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-3 py-2 border rounded-md bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:border-transparent @error('description') border-red-500 focus:ring-red-500 @else border-gray-300 dark:border-gray-600 focus:ring-teal-500 dark:focus:ring-purple-500 @enderror">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('ui.events.form.fields.date.label') }} *
                </label>
                <input id="date" type="datetime-local" name="date"
                    value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i')) }}" required
                    class="w-full px-3 py-2 border rounded-md bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:border-transparent @error('date') border-red-500 focus:ring-red-500 @else border-gray-300 dark:border-gray-600 focus:ring-teal-500 dark:focus:ring-purple-500 @enderror">
                @error('date')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('ui.events.form.fields.location.label') }} *
                </label>
                <input id="location" type="text" name="location"
                    value="{{ old('location', $event->location) }}" required
                    class="w-full px-3 py-2 border rounded-md bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:border-transparent @error('location') border-red-500 focus:ring-red-500 @else border-gray-300 dark:border-gray-600 focus:ring-teal-500 dark:focus:ring-purple-500 @enderror">
                @error('location')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="genre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('ui.events.form.fields.genre.label') }}
                </label>
                <input id="genre" type="text" name="genre"
                    value="{{ old('genre', $event->genre) }}"
                    class="w-full px-3 py-2 border rounded-md bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:border-transparent @error('genre') border-red-500 focus:ring-red-500 @else border-gray-300 dark:border-gray-600 focus:ring-teal-500 dark:focus:ring-purple-500 @enderror">
                @error('genre')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="poster" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('ui.events.form.fields.poster.label') }}
                </label>
                @if ($event->poster)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $event->poster) }}"
                            alt="Affiche actuelle"
                            class="h-32 object-cover rounded-md">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ __('ui.events.form.fields.poster.current') }}
                        </p>
                    </div>
                @endif
                <input type="file" id="poster" name="poster"
                    accept="image/jpeg,image/png,image/bmp,image/gif,image/webp"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-teal-500 dark:focus:ring-purple-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 dark:file:bg-purple-900 dark:file:text-purple-200 dark:hover:file:bg-purple-800">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('ui.events.form.fields.poster.help') }}
                </p>
                @error('poster')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <footer class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex gap-2">
                        <a href="{{ url('/events/' . $event->id) }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">
                            {{ __('ui.events.form.actions.cancel') }}
                        </a>
                        <button type="submit" form="delete-event-form"
                            onclick="return confirm('{{ __('ui.events.form.actions.delete_confirm') }}')"
                            class="px-4 py-2 bg-red-600 dark:bg-red-900 text-white rounded-md hover:bg-red-700 dark:hover:bg-red-800 cursor-pointer">
                            {{ __('ui.events.form.actions.delete') }}
                        </button>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 bg-teal-600 dark:bg-purple-900 text-white rounded-md hover:bg-teal-700 dark:hover:bg-purple-800 cursor-pointer">
                        {{ __('ui.events.form.actions.submit_edit') }}
                    </button>
                </div>
            </footer>
        </form>

        <form id="delete-event-form" method="POST" action="{{ url('/events/' . $event->id) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </article>
</x-default-layout>