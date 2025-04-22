<x-layouts.admin :title="__('Users')">
    <div class="flex flex-col gap-6">
        <!-- Header with Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <flux:input wire:model.live.debounce.300ms="search" id="user-search" placeholder="Search users..." icon="magnifying-glass" />
                </div>

                <flux:select wire:model.live="roleFilter" id="role-filter" class="min-w-[150px]">
                    <option selected value="">All Roles</option>
                    <option value="admin">Admin</option>
                    {{-- <option value="manager">Manager</option> --}}
                    <option value="customer">Customer</option>
                </flux:select>
            </div>

            <flux:button :href="route('admin.users.create')" wire:navigate variant="primary" icon="plus">
                Add New User
            </flux:button>
        </div>

        <!-- Users Table -->
        <flux:card>
            <div class="overflow-x-auto">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>User</flux:table.column>
                        <flux:table.column>Email</flux:table.column>
                        {{-- <x-flux::table.th>Role</x-flux::table.th> --}}
                        {{-- <x-flux::table.th>Status</x-flux::table.th> --}}
                        <flux:table.column>Joined</flux:table.column>
                        <flux:table.column align="end">Actions</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @forelse($users as $user)
                            <flux:table.row wire:key="user-{{ $user->id }}">
                                <flux:table.cell>
                                    <div class="flex items-center gap-3">
                                        <flux:avatar size="sm">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </flux:avatar>
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </flux:table.cell>
                                <flux:table.cell>
                                    {{ $user->email }}
                                </flux:table.cell>
                                {{-- Role and Status columns commented out as they require model relationships/properties --}}
                                {{--
                                <x-flux::table.td>
                                    <div class="text-sm text-zinc-900 dark:text-white">{{-- $user->role?->name ?? 'N/A' -- }}</div>
                                </x-flux::table.td>
                                <x-flux::table.td>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">Active</span>
                                </x-flux::table.td>
                                --}}
                                <flux:table.cell>
                                    {{ $user->created_at->format('M d, Y') }}
                                </flux:table.cell>
                                <flux:table.cell align="end">
                                    <div class="flex justify-end space-x-1">
                                        <flux:button size="sm" variant="ghost" :href="route('admin.users.edit', $user->id)" wire:navigate icon="pencil-square" />
                                        <flux:button size="sm" variant="ghost" color="danger" wire:click="delete({{ $user->id }})" wire:confirm="Are you sure you want to delete this user?" icon="trash" />
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                             <flux:table.row>
                                <flux:table.cell colspan="4">
                                    <div class="text-center py-12">
                                        <flux:icon name="users" class="h-12 w-12 mx-auto text-gray-400" />
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No users found</h3>
                                        @if($search)
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Adjust your search criteria.</p>
                                        @endif
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </div>

            <!-- Pagination -->
            @if ($users->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                 {{ $users->links() }}
            </div>
            @endif
        </flux:card>
    </div>
</x-layouts.admin>
