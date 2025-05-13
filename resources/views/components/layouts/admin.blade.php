<x-layouts.app> {{-- Add main app layout wrapper --}}
    <div>
        <!-- Admin Navigation Bar -->
        <flux:header sticky class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 rounded-md">
            <!-- Mobile Nav: collapsible, original dropdown -->
            <div class="flex sm:hidden flex-col px-4 py-2" x-data="{ open: false }">
                <div class="flex items-center justify-between w-full">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="text-lg font-bold tracking-wide text-indigo-700 dark:text-indigo-300 select-none">Admin TM<sup class='text-xs align-super'>™</sup></a>
                    <button @click="open = !open" class="ml-auto p-2 rounded-md text-zinc-700 dark:text-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition hover:bg-zinc-100 dark:hover:bg-zinc-800" aria-label="Toggle navigation">
                        <!-- Hamburger icon (bars-2 style) -->
                        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <nav x-show="open" class="flex flex-col gap-2 mt-2" @click.away="open = false">
                    <a href="{{ route('admin.products.index') }}" wire:navigate
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.products*') ? 'bg-blue-600 text-white' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700' }}">
                        Products
                    </a>
                    <a href="{{ route('admin.categories.index') }}" wire:navigate
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.categories*') ? 'bg-blue-600 text-white' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700' }}">
                        Categories
                    </a>
                    <a href="{{ route('admin.orders.index') }}" wire:navigate
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.orders*') ? 'bg-blue-600 text-white' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700' }}">
                        Orders
                    </a>
                    <a href="{{ route('admin.users.index') }}" wire:navigate
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.users*') ? 'bg-blue-600 text-white' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700' }}">
                        Users
                    </a>
                </nav>
            </div>
            <!-- Desktop Nav -->
            <flux:navbar class="hidden sm:flex">
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="text-lg font-bold tracking-wide text-indigo-700 dark:text-indigo-300 select-none">Admin Management<sup class='text-xs align-super'>™</sup></a>
                <div class="flex-1"></div>
                <flux:navbar.item :href="route('admin.products.index')" :current="request()->routeIs('admin.products*')" wire:navigate>
                    Products
                </flux:navbar.item>
                <flux:navbar.item :href="route('admin.categories.index')" :current="request()->routeIs('admin.categories*')" wire:navigate>
                    Categories
                </flux:navbar.navbar>
                <flux:navbar.item :href="route('admin.orders.index')" :current="request()->routeIs('admin.orders*')" wire:navigate>
                    Orders
                </flux:navbar.item>
                <flux:navbar.item :href="route('admin.users.index')" :current="request()->routeIs('admin.users*')" wire:navigate>
                    Users
                </flux:navbar.item>
            </flux:navbar>
        </flux:header>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-6">
            @if(isset($title))
                <h1 class="text-2xl font-bold mb-6 dark:text-white">{{ $title }}</h1>
            @endif
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </div>
        @livewireScripts
        @fluxScripts
    </div>
</x-layouts.app> {{-- Close main app layout wrapper --}}
