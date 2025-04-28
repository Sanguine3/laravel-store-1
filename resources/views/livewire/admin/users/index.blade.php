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
        <x-card>
            <div class="overflow-x-auto">
               <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700"> {{-- Added table with classes --}}
                   <thead class="bg-zinc-50 dark:bg-zinc-800"> {{-- Added thead with classes --}}
                       <tr> {{-- Added tr --}}
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">User</th> {{-- Replaced flux:table.column with th --}}
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Email</th> {{-- Replaced flux:table.column with th --}}
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Role</th> {{-- Replaced flux:table.column with th --}}
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th> {{-- Replaced flux:table.column with th --}}
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Joined</th> {{-- Replaced flux:table.column with th --}}
                           <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th> {{-- Replaced flux:table.column with th --}}
                       </tr> {{-- Closed tr --}}
                   </thead> {{-- Closed thead --}}
                   <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700"> {{-- Added tbody with classes --}}
                       @forelse($users as $user)
                           <tr wire:key="user-{{ $user->id }}"> {{-- Replaced flux:table.row with tr --}}
                               <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white"> {{-- Replaced flux:table.cell with td --}}
                                   <div class="flex items-center gap-3">
                                       <flux:avatar size="sm">
                                           {{ strtoupper(substr($user->name, 0, 2)) }}
                                       </flux:avatar>
                                       <span>{{ $user->name }}</span>
                                   </div>
                               </td> {{-- Closed td --}}
                               <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400"> {{ $user->email }} </td> {{-- Replaced flux:table.cell with td --}}
                               <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400"> {{ ucfirst($user->role ?? 'N/A') }} </td> {{-- Replaced flux:table.cell with td --}}
                               <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400"> {{-- Replaced flux:table.cell with td --}}
                                   {{-- Display status badge - adjust property/values as needed --}}
                                   <flux:badge size="sm" inset="top bottom" @class([
                                       'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' => ($user->status ?? '') === 'active',
                                       'bg-zinc-100 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-400' => ($user->status ?? '') !== 'active',
                                   ])>
                                       {{ ucfirst($user->status ?? 'Unknown') }}
                                   </flux:badge>
                               </td> {{-- Closed td --}}
                               <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400"> {{ $user->created_at->format('M d, Y') }} </td> {{-- Replaced flux:table.cell with td --}}
                               <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"> {{-- Replaced flux:table.cell with td --}}
                                    <div class="flex justify-end space-x-1">
                                        <flux:button size="sm" variant="ghost" :href="route('admin.users.edit', $user->id)" wire:navigate icon="pencil-square" />
                                        <flux:button size="sm" variant="ghost" color="danger" wire:click="delete({{ $user->id }})" wire:confirm="Are you sure you want to delete this user?" icon="trash" />
                                    </div>
                               </td> {{-- Closed td --}}
                            </tr> {{-- Closed tr --}}
                        @empty
                             <tr> {{-- Replaced flux:table.row with tr --}}
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white"> {{-- Replaced flux:table.cell with td, adjusted colspan --}}
                                     <div class="text-center py-12">
                                        <flux:icon name="users" class="h-12 w-12 mx-auto text-gray-400" />
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No users found</h3>
                                        @if($search)
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Adjust your search criteria.</p>
                                        @endif
                                     </div>
                                </td> {{-- Closed td --}}
                            </tr> {{-- Closed tr --}}
                        @endforelse
                    </tbody> {{-- Closed tbody --}}
                </table> {{-- Closed table --}}
            </div>

            <!-- Pagination -->
            @if ($users->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                 {{ $users->links() }}
            </div>
            @endif
        </x-card>
    </div>
</x-layouts.admin>
