<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    @if (session()->has('success'))
        {!! display_message(session('success'), 'success') !!}
    @endif

    @if (session()->has('danger'))
        {!! display_message(session('error'), 'error') !!}
    @endif

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div class="flex justify-end">
            <a href="{{ route('posts.index') }}" wire:navigate
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white rounded-md">View
                Post</a>
        </div>
    </div>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <form wire:submit.prevent="save"
                class="max-w-2xl mx-auto mt-8 space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Title</label>
                    <input wire:model="title" type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                        placeholder="Enter post title" />
                    @error('title')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Content</label>
                    <textarea wire:model="content" rows="5"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                        placeholder="Write your content here..."></textarea>
                    @error('content')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                    <select wire:model="status"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                    @error('status')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Featured Image</label>
                    <input wire:model="image" type="file" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md" />
                    @error('image')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror

                    @if ($image)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Image Preview:</p>
                            <img src="{{ $image->temporaryUrl() }}"
                                class="w-full max-h-64 object-contain border rounded dark:border-gray-700">
                        </div>
                    @endif
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white rounded-md">
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
