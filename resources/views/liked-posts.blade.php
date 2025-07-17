<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liked Posts') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @forelse ($posts as $post)
                <div class="border rounded-xl p-4 bg-white dark:bg-gray-800 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center mb-2">
                        <div
                            class="h-10 w-10 rounded-full bg-gray-300 dark:bg-neutral-700 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($post->user?->name, 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $post->user?->name }}
                            </p>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">
                        {{ $post->title }}
                    </h3>
                    <p class="text-gray-800 dark:text-gray-200 mb-3">
                        {{ $post->content }}
                    </p>
                    <div class="mt-3 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 transition {{ $post->liked ? 'text-red-500 fill-red-500' : 'text-gray-400' }}"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                     2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09
                     C13.09 3.81 14.76 3 16.5 3
                     19.58 3 22 5.42 22 8.5
                     c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                        <span class="text-sm text-gray-600 dark:text-gray-300">{{ $post->likes_count }}</span>
                    </div>
                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                        <strong>Liked by:</strong>
                        @foreach ($post->postLikes as $like)
                            {{ $like->user->name ?? 'Unknown' }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </div>
                </div>
            @empty
                <div
                    class="border text-center text-white mt-8 ml-8 rounded-xl p-4 bg-white dark:bg-gray-800 dark:border-gray-700 shadow-sm">
                    No Post Available
                </div>
            @endforelse
        </div>
        <div class="p-2 mt-6">{{ $posts->links() }}</div>
    </div>
</x-app-layout>
