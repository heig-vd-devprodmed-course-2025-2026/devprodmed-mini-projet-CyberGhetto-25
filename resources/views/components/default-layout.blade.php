<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        @isset($description)
        <meta name="description" content="{{ $description }}" />
        @endisset
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        @isset($title)
        <title>{{ $title }} - {{ config('app.name') }}</title>
        @else
        <title>{{ config('app.name') }}</title>
        @endisset

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="flex min-h-screen flex-col bg-neutral-950">
        <header class="bg-neutral-900 text-white">
            <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="h-16 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                    <a href="{{ url('/') }}"
                        class="block hover:opacity-80 transition text-amber-500 font-bold"
                        style="font-family: 'DM Sans', sans-serif; font-weight: 800;">
                        {{ config('app.name') }}
                    </a>
                    <a href="{{ url('/events') }}"
                        class="block bg-neutral-800 px-3 py-1 rounded-md hover:bg-neutral-700 text-neutral-100 text-sm">
                        {{ __('ui.events.title') }}
                    </a>
                    <a href="{{ url('/posts') }}"
                        class="block bg-neutral-800 px-3 py-1 rounded-md hover:bg-neutral-700 text-neutral-100 text-sm">
                        {{ __('ui.posts.index.title') }}
                    </a>
                </div>
                    @auth
                    <a href="{{ url('/my-profile') }}" class="block hover:opacity-80 transition">
                        <div
                            class="h-8 w-8 rounded-full overflow-hidden bg-amber-500 flex items-center justify-center">
                            @if (Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                    alt="{{ Auth::user()->username }}" class="w-full h-full object-cover">
                            @else
                                <img src="/icons/profile.svg" alt="{{ Auth::user()->username }}" class="h-8 w-8">
                            @endif
                        </div>
                    </a>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ url('/auth/login') }}"
                            class="block px-3 py-1 rounded-md text-neutral-300 hover:text-white hover:bg-neutral-800 transition text-sm">
                            {{ __('ui.auth.login.title') }}
                        </a>
                        <a href="{{ url('/auth/register') }}"
                            class="block bg-amber-500 text-neutral-900 px-3 py-1 rounded-md hover:bg-amber-600 transition text-sm font-bold">
                            {{ __('ui.auth.register.title') }}
                        </a>
                    </div>
                @endauth
                </div>
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8 sm:px-6 lg:px-8 flex-grow text-neutral-100 max-w-2xl">
            {{ $slot }}
        </main>

        <footer class="bg-neutral-900 text-neutral-400 text-sm">
            <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8">
                <div
                    class="h-16 flex flex-col items-center justify-between gap-4 sm:flex-row"
                >
                    <p class="text-center sm:text-left">
                        {{ __('ui.about.copyright', ['year' => date('Y')]) }}
                    </p>
                    <a
                        href="{{ url('/about') }}"
                        class="block hover:opacity-80 transition"
                    >
                        {{ __('ui.about.title') }}
                    </a>
                </div>
            </div>
        </footer>
    </body>
</html>