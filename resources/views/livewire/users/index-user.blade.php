<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    @if (session()->has('success'))
        {!! display_message(session('success'), 'success') !!}
    @endif

    @if (session()->has('error'))
        {!! display_message(session('error'), 'error') !!}
    @endif

    <div class="flex justify-between items-center mb-4 gap-4 rounded-xl p-4 overflow-x-auto">
        <div class="flex justify-end">
            <a href="{{ route('users.create') }}" wire:navigate
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white rounded-md">Create
                User</a>
        </div>
        <div class="flex gap-3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name or email"
                class="px-4 py-2 rounded-md border dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white" />
            <select wire:model.live.debounce.300ms="filterRole"
                class="px-4 py-2 rounded-md border dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                <option value="">All Roles</option>
                <option value="Super Admin">Super Admin</option>
                <option value="Admin">Admin</option>
                <option value="Creator">Creator</option>
                <option value="Guest">Guest</option>
            </select>
        </div>
    </div>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (count((array) $selectedUsers) > 0)
                <div class="bg-slate-900 text-white rounded-xl p-4 mb-4 flex items-center justify-between gap-4">
                    <div>Selected: {{ count((array) $selectedUsers) }}</div>
                    <button wire:click="deleteBulk"
                        class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Delete
                        All</button>
                    <select wire:change="changeRoleBulk($event.target.value)"
                        class="px-4 py-2 rounded-md border dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        <option value="">Change Role</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Admin">Admin</option>
                        <option value="Creator">Creator</option>
                        <option value="Guest">Guest</option>
                    </select>
                </div>
            @endif
            <div class="overflow-x-auto shadow-md rounded-xl">
                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3"><input type="checkbox" wire:click="toggleSelectAll"></th>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Role</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr wire:key="user-{{ $user->id }}"
                                class="{{ in_array($user->id, $selectedUsers) ? 'bg-indigo-50 dark:bg-indigo-900' : 'bg-white dark:bg-gray-900' }}">
                                <td class="px-6 py-4">
                                    <input type="checkbox" wire:model="selectedUsers" value="{{ $user->id }}">
                                </td>
                                <td class="px-6 py-4">{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <select wire:change="changeRole({{ $user->id }}, $event.target.value)"
                                        class="px-2 py-1 rounded-md bg-white dark:bg-gray-800 text-black dark:text-white border border-gray-300 dark:border-gray-700">
                                        <option value="Super Admin" @selected($user->role === 'Super Admin')>Super Admin</option>
                                        <option value="Admin" @selected($user->role === 'Admin')>Admin</option>
                                        <option value="Creator" @selected($user->role === 'Creator')>Creator</option>
                                        <option value="Guest" @selected($user->role === 'Guest')>Guest</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('users.edit', $user->id) }}" wire:navigate
                                        class="text-blue-600 hover:underline">Edit</a>
                                    |
                                    <button wire:click="delete({{ $user->id }})"
                                        class="text-red-600 hover:underline">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
