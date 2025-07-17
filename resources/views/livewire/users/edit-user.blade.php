<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update User') }}
        </h2>
    </x-slot>

    @if (session()->has('success'))
        {!! display_message(session('success'), 'success') !!}
    @endif

    @if (session()->has('error'))
        {!! display_message(session('error'), 'error') !!}
    @endif

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div class="flex justify-end">
            <a href="{{ route('users.index') }}" wire:navigate
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white rounded-md">View
                User</a>
        </div>
    </div>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <form wire:submit="update"
                class="mx-auto max-w-md flex flex-col gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
                <!-- Name -->
                <x-input wire:model="form.name" :label="__('Name')" type="text" required autofocus autocomplete="name"
                    :placeholder="__('Full name')" />

                <!-- Email Address -->
                <x-input wire:model="form.email" :label="__('Email address')" type="email" required autocomplete="email"
                    placeholder="email@example.com" />

                <!-- Password -->
                <x-input wire:model="form.password" :label="__('Password')" type="password" autocomplete="new-password"
                    :placeholder="__('Password')" viewable />

                <!-- Confirm Password -->
                <x-input wire:model="form.password_confirmation" :label="__('Confirm password')" type="password"
                    autocomplete="new-password" :placeholder="__('Confirm password')" viewable />

                <div class="flex items-center justify-end">
                    <x-button type="submit" variant="primary" class="w-full">
                        {{ __('Update User') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
