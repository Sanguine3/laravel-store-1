<x-layouts.admin :title="__('Users')">
    <div class="flex flex-col gap-6">
        @if (session('status'))
            <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-800 border border-green-300">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            {{-- Add error display --}}
            <div class="mb-4 px-4 py-2 rounded bg-red-100 text-red-800 border border-red-300">
                {{ session('error') }}
            </div>
        @endif
        <!-- Search and Filters Form -->
        <form method="GET" action="{{ route('admin.users.index') }}"
              class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4"
              x-data="{ searchTerm: '{{ $search ?? '' }}' }">
            <div class="flex-1 flex flex-col sm:flex-row sm:items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1 relative">
                    <label for="user-search" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                    <flux:input
                        name="search"
                        id="user-search"
                        placeholder="Search name or email..."
                        icon="magnifying-glass"
                        clearable
                        class="w-full"
                        value="{{ $search ?? '' }}"
                        x-model="searchTerm"
                    />
                    <span x-show="searchTerm.length > 0" x-cloak
                          class="absolute right-10 top-1/2 mt-2.5 -translate-y-1/2 text-xs text-zinc-500 dark:text-zinc-400 pr-2"
                          x-text="searchTerm.length"></span>
                </div>
                <!-- Role Filter -->
                <div class="min-w-[160px] md:min-w-[200px] w-full sm:w-auto"
                     x-data="{ openRoleFilter: false, selectedRoleFilter: '{{ $roleFilter ?? '' }}' }">
                    <label for="role-filter-button"
                           class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Role</label>
                    <input type="hidden" name="role" x-model="selectedRoleFilter">
                    <div class="relative">
                        <button @click="openRoleFilter = !openRoleFilter" type="button" id="role-filter-button"
                                class="w-full flex items-center justify-between px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm bg-white dark:bg-zinc-700 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span
                                x-text="selectedRoleFilter === '' ? 'All Roles' : selectedRoleFilter.charAt(0).toUpperCase() + selectedRoleFilter.slice(1)">
                                {{ $roleFilter === '' ? 'All Roles' : ucfirst($roleFilter) }}
                            </span>
                            <svg class="ml-2 -mr-0.5 h-4 w-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="openRoleFilter"
                             @click.away="openRoleFilter = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-700 shadow-lg rounded-md border border-zinc-200 dark:border-zinc-600 max-h-60 overflow-y-auto py-1"
                             style="display: none;">
                            <a href="#" @click.prevent="selectedRoleFilter = ''; openRoleFilter = false"
                               class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-600">All
                                Roles</a>
                            @foreach($roles as $roleOption)
                                <a href="#"
                                   @click.prevent="selectedRoleFilter = '{{ $roleOption }}'; openRoleFilter = false"
                                   class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-600">{{ ucfirst($roleOption) }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Apply Filters Button -->
            <div class="flex items-stretch sm:items-end gap-2 w-full sm:w-auto">
                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-400 dark:focus:ring-blue-600">
                    Apply Filters
                </button>
            </div>
            <!-- Add New User Button -->
            <div class="flex items-stretch sm:items-end gap-2 w-full sm:w-auto">
                <flux:button href="{{ route('admin.users.create') }}" color="warning" icon="plus" size="base"
                             class="!bg-amber-700 !text-white !shadow-lg !ring-0 !outline-none hover:!bg-amber-800 focus:!ring-0 focus:!outline-none">
                    Add New User
                </flux:button>
            </div>
        </form>

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        User
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Joined
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                            <div class="flex items-center gap-3">
                                <flux:avatar size="sm">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </flux:avatar>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ ucfirst($user->role ?? 'N/A') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                            @if($user->trashed())
                                <flux:badge size="sm" inset="top bottom" color="danger"
                                            class="!bg-red-100 dark:!bg-red-900/30 !text-red-800 dark:!text-red-400">
                                    Deleted
                                </flux:badge>
                            @else
                                {{-- Assuming status is stored, otherwise remove this column or adapt --}}
                                <flux:badge size="sm" inset="top bottom" @class="[
                                        'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' => ($user->status ?? 'active') === 'active', // Default to active if no status field
                                        'bg-zinc-100 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-400' => ($user->status ?? 'active') !== 'active',
                                    ]">
                                {{ ucfirst($user->status ?? 'Active') }} {{-- Default to Active --}}
                                </flux:badge>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center gap-1">
                                @if(!$user->trashed())
                                    <flux:button href="{{ route('admin.users.edit', $user->id) }}" as="a"
                                                 color="warning" size="sm" icon="pencil" tooltip="Edit"
                                                 class="!bg-yellow-400 !text-zinc-900 hover:!bg-yellow-500 focus:!ring-yellow-300"/>
                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" color="danger" size="sm" icon="trash"
                                                     tooltip="Delete" square
                                                     class="!bg-red-600 !text-white hover:!bg-red-700 focus:!ring-red-400"/>
                                    </form>
                                @else
                                    <!-- Restore Form -->
                                    <form action="{{ route('admin.users.restore', $user->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to restore this user?');">
                                        @csrf
                                        @method('PUT') {{-- Or POST, depending on your route definition --}}
                                        <flux:button type="submit" color="success" size="sm" tooltip="Restore"
                                                     class="!bg-green-500 !text-white hover:!bg-green-600 focus:!ring-green-400">
                                            <div class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                                                </svg>
                                                <span>Restore</span>
                                            </div>
                                        </flux:button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">No users found
                            matching your criteria.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                {{ $users->links()}}
            </div>
        @endif
    </div>
    <!-- Include AlpineJS if not already included globally -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-layouts.admin>
