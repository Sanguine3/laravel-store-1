<x-layouts.admin :title="__('Users')">
    <div class="flex flex-col gap-6">
         @if (session('status'))
            <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-800 border border-green-300">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error')) {{-- Add error display --}}
            <div class="mb-4 px-4 py-2 rounded bg-red-100 text-red-800 border border-red-300">
                {{ session('error') }}
            </div>
        @endif
        <!-- Search and Filters Form -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
             <div class="flex-1 flex flex-col sm:flex-row sm:items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="user-search" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                    <flux:input
                        name="search"
                        id="user-search"
                        placeholder="Search name or email..."
                        icon="magnifying-glass"
                        clearable
                        class="w-full"
                        value="{{ $search ?? '' }}"
                    />
                </div>
                <!-- Role Filter -->
                <div class="min-w-[160px] md:min-w-[200px] w-full sm:w-auto" x-data="{ openRole: false, selectedRole: '{{ $roleFilter ?? '' }}' }">
                    <label for="role-filter-button" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Role</label>
                    <input type="hidden" name="role" x-model="selectedRole">
                    <div class="relative">
                        <flux:button id="role-filter-button" type="button" icon:trailing="chevron-down" color="outline" class="w-full flex justify-between" @click="openRole = !openRole">
                            <span x-text="selectedRole === '' ? 'All Roles' : selectedRole.charAt(0).toUpperCase() + selectedRole.slice(1)">
                                {{ $roleFilter === '' ? 'All Roles' : ucfirst($roleFilter) }}
                            </span>
                        </flux:button>
                        <div x-show="openRole" @click.away="openRole = false" class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-700 shadow-lg rounded-md border border-zinc-200 dark:border-zinc-600 max-h-60 overflow-y-auto" style="display: none;">
                            <flux:menu>
                                <flux:menu.item @click="selectedRole = ''; openRole = false">All Roles</flux:menu.item>
                                @foreach($roles as $roleOption) {{-- Use $roles from controller --}}
                                    <flux:menu.item @click="selectedRole = '{{ $roleOption }}'; openRole = false">{{ ucfirst($roleOption) }}</flux:menu.item>
                                @endforeach
                            </flux:menu>
                        </div>
                    </div>
                </div>
            </div>
             <!-- Apply Filters Button -->
            <div class="flex items-stretch sm:items-end gap-2 w-full sm:w-auto">
                 <flux:button type="submit" color="primary" class="w-full sm:w-auto">Apply Filters</flux:button>
            </div>
             <!-- Add New User Button -->
             <div class="flex items-stretch sm:items-end gap-2 w-full sm:w-auto">
                <flux:button href="{{ route('admin.users.create') }}" color="warning" icon="plus" size="base" class="!bg-amber-700 !text-white !shadow-lg !ring-0 !outline-none hover:!bg-amber-800 focus:!ring-0 focus:!outline-none">
                    Add New User
                </flux:button>
             </div>
        </form>

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Joined</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
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
                                {{-- Assuming status is stored, otherwise remove this column or adapt --}}
                                <flux:badge size="sm" inset="top bottom" @class="[
                                    'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' => ($user->status ?? '') === 'active',
                                    'bg-zinc-100 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-400' => ($user->status ?? '') !== 'active',
                                ]">
                                    {{ ucfirst($user->status ?? 'Unknown') }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-1">
                                    <flux:button href="{{ route('admin.users.edit', $user->id) }}" as="a" color="warning" size="sm" icon="pencil" tooltip="Edit" class="!bg-yellow-400 !text-zinc-900 hover:!bg-yellow-500 focus:!ring-yellow-300" />
                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" color="danger" size="sm" icon="trash" tooltip="Delete" square class="!bg-red-600 !text-white hover:!bg-red-700 focus:!ring-red-400" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">No users found matching your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                 @if ($users->total() > 0)
                <div>
                    <p class="text-sm text-zinc-700 dark:text-zinc-300">
                        Showing
                        <span class="font-medium">{{ $users->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $users->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $users->total() }}</span>
                        results
                    </p>
                </div>
                @endif
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>
    <!-- Include AlpineJS if not already included globally -->
    <!-- <script src="//unpkg.com/alpinejs" defer></script> -->
</x-layouts.admin>