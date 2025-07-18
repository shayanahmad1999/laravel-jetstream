<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div class="flex justify-end">
            <a href="{{ route('posts.create') }}" wire:navigate
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white rounded-md">Create
                Post</a>
        </div>
    </div>
    @if (session()->has('success'))
        {!! display_message(session('success'), 'success') !!}
    @endif

    @if (session()->has('error'))
        {!! display_message(session('error'), 'error') !!}
    @endif
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <div
                class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6 border border-gray-200 dark:border-gray-700 mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">🔍 Search & Filter</h2>

                <div class="flex flex-col md:flex-row gap-4">
                    <input type="text" wire:model.live.debounce.500ms="search"
                        placeholder="Search title or content..."
                        class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 
                   bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 
                   placeholder-gray-400 dark:placeholder-gray-500 shadow-sm 
                   focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                   transition-all duration-300" />

                    <input type="text" wire:model.live.debounce.500ms="userFilter"
                        placeholder="Filter by author name..."
                        class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 
                   bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 
                   placeholder-gray-400 dark:placeholder-gray-500 shadow-sm 
                   focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                   transition-all duration-300" />
                </div>
            </div>


            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($posts as $post)
                    <div
                        class="flex flex-col sm:flex-row items-start gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <!-- Post Image -->
                        <div
                            class="w-full sm:w-32 h-32 bg-gray-100 dark:bg-gray-700 rounded overflow-hidden flex items-center justify-center">
                            @if ($post->image)
                                <img src="{{ asset($post->image) }}" alt="Post Image"
                                    class="object-cover w-full h-full">
                            @else
                                <span class="text-sm text-gray-400 dark:text-gray-500">No Image</span>
                            @endif
                        </div>

                        <!-- Post Content -->
                        <div class="flex-1">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                <a href="{{ route('posts.edit', $post->slug) }}" wire:navigate>{{ $post->title }}</a>
                            </h2>
                            <p class="mt-1 text-gray-700 dark:text-gray-300 line-clamp-3">
                                {{ $post->content }}
                            </p>

                            <!-- Meta info -->
                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400 space-x-2">
                                <span>👤 {{ $post->user->name }}</span>
                                <span>🏷️ {{ $post->team->name }}</span>
                                <span wire:click="updateStatus({{ $post->id }})"
                                    wire:loading.class="opacity-50 cursor-not-allowed"
                                    class="inline-block px-2 py-0.5 text-xs rounded-full cursor-pointer
                        {{ $post->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </div>
                        </div>
                        @can('delete', $post)
                            <a wire:click="delete({{ $post->id }})" wire:navigate
                                wire:confirm="Are you sure want to delete!"
                                class="cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                        @endcan
                        |
                        @can('view', $post)
                            <a href="{{ route('posts.view', $post->slug) }}" wire:navigate
                                wire:confirm="Are you sure want to delete!"
                                class="cursor-pointer font-medium text-cyan-600 dark:text-cyan-500 hover:underline">View</a>
                        @endcan
                        |
                        <a href="{{ route('posts.edit', $post->slug) }}" wire:navigate
                            class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </div>
                @empty
                    <p class="p-4 text-gray-500 dark:text-gray-400">No posts yet.</p>
                @endforelse
            </div>
            <div class="p-2 mt-6">{{ $posts->links() }}</div>
        </div>
    </div>
</div>
