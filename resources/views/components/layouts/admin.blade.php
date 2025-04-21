<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <!-- Horizontal Header Bar -->
        <flux:header sticky class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <!-- Left side: Logo and Navigation -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2" wire:navigate>
                    <x-app-logo />
                    <span class="text-lg font-semibold text-zinc-900 dark:text-white">Admin</span>
                </a>

                <!-- Main Navigation -->
                <nav class="hidden md:flex">
                    <ul class="flex space-x-4">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700' }}"
                               wire:navigate>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.products*') ? 'bg-blue-600 text-white' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700' }}"
                               wire:navigate>
                                Products
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.categories*') ? 'bg-blue-600 text-white' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700' }}"
                               wire:navigate>
                                Categories
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.orders') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.orders*') ? 'bg-blue-600 text-white' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700' }}"
                               wire:navigate>
                                Orders
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.users*') ? 'bg-blue-600 text-white' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700' }}"
                               wire:navigate>
                                Users
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <flux:spacer />

            <!-- Right side: User Menu -->
            <flux:dropdown position="bottom" align="end">
                @auth
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />
                @else
                <flux:profile
                    :name="__('Guest')"
                    initials="G"
                    icon-trailing="chevron-down"
                />
                @endauth

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        @auth
                                            {{ auth()->user()->initials() }}
                                        @else
                                            G
                                        @endauth
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    @auth
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    @else
                                        <span class="truncate font-semibold">{{ __('Guest') }}</span>
                                        <span class="truncate text-xs">{{ __('Not logged in') }}</span>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    @auth
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('admin.profile')" icon="user" wire:navigate>{{ __('View Profile') }}</flux:menu.item>
                            <flux:menu.item :href="route('admin.settings')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    @else
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('login')" icon="arrow-right-end-on-rectangle" wire:navigate>{{ __('Log In') }}</flux:menu.item>
                        </flux:menu.radio.group>
                    @endauth
                </flux:menu>
            </flux:dropdown>

            <!-- Mobile Navigation Toggle -->
            <flux:dropdown position="bottom" align="end" class="md:hidden">
                <button class="p-2 rounded-md text-zinc-700 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <flux:menu class="w-[200px]">
                    <flux:menu.item :href="route('admin.dashboard')" wire:navigate>Dashboard</flux:menu.item>
                    <flux:menu.item :href="route('admin.products')" wire:navigate>Products</flux:menu.item>
                    <flux:menu.item :href="route('admin.categories')" wire:navigate>Categories</flux:menu.item>
                    <flux:menu.item :href="route('admin.orders')" wire:navigate>Orders</flux:menu.item>
                    <flux:menu.item :href="route('admin.users')" wire:navigate>Users</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-6">
            @if(isset($title))
                <h1 class="text-2xl font-bold mb-6 dark:text-white">{{ $title }}</h1>
            @endif

            {{ $slot }}
        </div>

        @fluxScripts
    </body>
</html>
