<x-layouts.admin :title="__('Users')">
    <div class="flex flex-col gap-6">
        <!-- Search and Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    id="user-search"
                    placeholder="Search users..."
                    icon="magnifying-glass"
                    clearable
                    class="w-full"
                />
            </div>
            <flux:dropdown class="min-w-[160px] md:min-w-[200px] w-full sm:w-auto" placement="bottom-start">
                <flux:button icon:trailing="chevron-down" color="outline" class="w-full flex justify-between">
                    {{ $roleFilter === '' ? 'All Roles' : ucfirst($roleFilter) }}
                </flux:button>
                <flux:menu>
                    <flux:menu.radio.group wire:model.live="roleFilter">
                        <flux:menu.radio value="">All Roles</flux:menu.radio>
                        <flux:menu.radio value="admin">Admin</flux:menu.radio>
                        <flux:menu.radio value="customer">Customer</flux:menu.radio>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>
        </div>
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
                        <tr wire:key="user-{{ $user->id }}">
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
                                <flux:badge size="sm" inset="top bottom" @class="[
                                    'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' => ($user->status ?? '') === 'active',
                                    'bg-zinc-100 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-400' => ($user->status ?? '') !== 'active',
                                ]">
                                    {{ ucfirst($user->status ?? 'Unknown') }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <flux:button href="{{ route('admin.users.edit', $user->id) }}" as="a" color="warning" size="sm" icon="pencil" tooltip="Edit" class="mr-1 !bg-yellow-400 !text-zinc-900 hover:!bg-yellow-500 focus:!ring-yellow-300" />
                                <flux:button wire:click="delete({{ $user->id }})" color="danger" size="sm" icon="trash" tooltip="Delete" square wire:loading.attr="disabled" wire:target="delete" class="!bg-red-600 !text-white hover:!bg-red-700 focus:!ring-red-400" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination Summary (always shown) -->
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
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
            @if ($users->hasPages())
                <div>
                    {{ $users->links() }}
                </div>
            @endif
        </div>
        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
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
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>
</x-layouts.admin>
