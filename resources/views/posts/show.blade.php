<x-default-layout>
    <x-slot:title>
        @if ($post->title)
            {{ __('ui.posts.show.title', [
                'post_title' => $post->title,
                'first_name' => $post->user->first_name,
                'last_name' => $post->user->last_name,
            ]) }}
        @else
            {{ __('ui.posts.show.title_without_post_title', [
                'first_name' => $post->user->first_name,
                'last_name' => $post->user->last_name,
            ]) }}
        @endif
    </x-slot>

    <x-slot:description>
        @if ($post->title)
            {{ __('ui.posts.show.description', [
                'post_title' => $post->title,
                'first_name' => $post->user->first_name,
                'last_name' => $post->user->last_name,
            ]) }}
        @else
            {{ __('ui.posts.show.description_without_post_title', [
                'first_name' => $post->user->first_name,
                'last_name' => $post->user->last_name,
            ]) }}
        @endif
    </x-slot>

    <article class="bg-white dark:bg-neutral-800 rounded-lg shadow-md p-6">
        <header class="mb-6">
            @if ($post->title)
                <h1 class="text-3xl font-bold dark:text-white mb-2">
                    {{ $post->title }}
                </h1>
            @endif

            <p class="text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ url('@' . $post->user->username) }}">
                    {{ __('ui.posts.show.author', [
                        'first_name' => $post->user->first_name,
                        'last_name' => $post->user->last_name,
                    ]) }}
                </a>
                ·
                <span title="{{ $post->created_at->isoFormat('LLLL') }}">
                    {{ $post->created_at->diffForHumans() }}
                </span>
                @can('update', $post)
                    ·
                    <a href="{{ url('/posts/' . $post->id . '/edit') }}">
                        {{ __('ui.posts.edit.title_without_post_title') }}
                    </a>
                @endcan
                ·
                <span class="font-semibold">
                    {{ trans_choice('ui.posts.likes_count', count($post->likes)) }}
                </span>
            </p>
        </header>

        <div class="mb-4">
            <p class="mt-4 dark:text-gray-300">
                {{ $post->content }}
            </p>
        </div>

                <footer class="pt-4 border-t border-gray-200 dark:border-gray-700">
            @auth
                <form method="POST" action="{{ url('/likes/' . $post->id) }}" class="mb-4">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-wrap justify-between gap-2">
                        <button type="submit" name="reaction" value="like"
                            class="w-12 h-12 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer {{ $reaction === 'like' ? 'ring-2 ring-teal-600 dark:ring-purple-900' : '' }}">
                            👍
                        </button>
                        <button type="submit" name="reaction" value="love"
                            class="w-12 h-12 rounded-full cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 {{ $reaction === 'love' ? 'ring-2 ring-teal-600 dark:ring-purple-900' : '' }}">
                            ❤️
                        </button>
                        <button type="submit" name="reaction" value="haha"
                            class="w-12 h-12 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer {{ $reaction === 'haha' ? 'ring-2 ring-teal-600 dark:ring-purple-900' : '' }}">
                            😂
                        </button>
                        <button type="submit" name="reaction" value="wow"
                            class="w-12 h-12 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer {{ $reaction === 'wow' ? 'ring-2 ring-teal-600 dark:ring-purple-900' : '' }}">
                            😮
                        </button>
                        <button type="submit" name="reaction" value="sad"
                            class="w-12 h-12 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer {{ $reaction === 'sad' ? 'ring-2 ring-teal-600 dark:ring-purple-900' : '' }}">
                            😢
                        </button>
                        <button type="submit" name="reaction" value="angry"
                            class="w-12 h-12 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer {{ $reaction === 'angry' ? 'ring-2 ring-teal-600 dark:ring-purple-900' : '' }}">
                            😡
                        </button>
                    </div>
                </form>
            @endauth
            <ul class="flex flex-wrap gap-2">
                @forelse ($post->likes as $user)
                    <li class="flex items-center gap-1 text-sm text-gray-600 dark:text-gray-400">
                        <a href="{{ url('@' . $user->username) }}" class="font-semibold hover:underline">
                            {{ '@' . $user->username }}
                        </a>
                        <span>
                            @if ($user->pivot->reaction === 'like')
                                👍
                            @elseif($user->pivot->reaction === 'love')
                                ❤️
                            @elseif($user->pivot->reaction === 'haha')
                                😂
                            @elseif($user->pivot->reaction === 'wow')
                                😮
                            @elseif($user->pivot->reaction === 'sad')
                                😢
                            @elseif($user->pivot->reaction === 'angry')
                                😡
                            @endif
                        </span>
                    </li>
                @empty
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        {{ trans_choice('ui.posts.likes_count', 0) }}
                    </span>
                @endforelse
            </ul>
        </footer>
    </article>

    <section class="mt-6">
        <h2 class="text-xl font-bold dark:text-white mb-4">
            {{ trans_choice('ui.posts.comments.count', count($post->comments)) }}
        </h2>

        @forelse ($post->comments->sortByDesc('created_at') as $comment)
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md p-4 mb-3">
                <div class="flex items-center justify-between mb-2">
                    <a href="{{ url('@' . $comment->user->username) }}" class="font-semibold text-sm dark:text-white hover:underline">
                        {{ '@' . $comment->user->username }}
                    </a>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500 dark:text-gray-400" title="{{ $comment->created_at->isoFormat('LLLL') }}">
                            {{ $comment->created_at->diffForHumans() }}
                        </span>
                        @can('delete', $comment)
                            <form method="POST" action="{{ url('/posts/' . $post->id . '/comments/' . $comment->id) }}"
                                onsubmit="return confirm('{{ __('ui.posts.comments.delete_confirm') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:underline cursor-pointer">
                                    {{ __('ui.posts.comments.delete') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
                <p class="text-sm dark:text-gray-300">{{ $comment->content }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ trans_choice('ui.posts.comments.count', 0) }}
            </p>
        @endforelse

        <div class="mt-6">
            @auth
                <form method="POST" action="{{ url('/posts/' . $post->id . '/comments') }}" class="bg-white dark:bg-neutral-800 rounded-lg shadow-md p-4">
                    @csrf
                    <div class="mb-3">
                        <label for="content" class="block text-sm font-medium dark:text-white mb-1">
                            {{ __('ui.posts.comments.form.label') }}
                        </label>
                        <textarea
                            id="content"
                            name="content"
                            rows="3"
                            placeholder="{{ __('ui.posts.comments.form.placeholder') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-sm dark:bg-neutral-700 dark:text-white"
                        >{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="text-sm bg-amber-500 bg-amber-700 text-white px-4 py-2 rounded-md hover:opacity-90 cursor-pointer">
                        {{ __('ui.posts.comments.form.submit') }}
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <a href="{{ route('login') }}" class="underline">{{ __('ui.posts.comments.login_to_comment') }}</a>
                </p>
            @endguest
        </div>
    </section>
</x-default-layout>