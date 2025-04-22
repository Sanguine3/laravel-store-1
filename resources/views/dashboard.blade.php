<div>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("Welcome back, ") . Auth::user()?->name . "!" }}
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Total Products -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center">
                             <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 mr-4">
                                <flux:icon name="cube" class="h-6 w-6" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Total Products</p>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalProducts }}</h3>
                            </div>
                        </div>
                    </div>

                    {{-- Removed Total Categories Card --}}

                    {{-- Removed Your Orders Card --}}

                    <!-- Add more cards here if needed -->

                </div>

                {{-- Removed Featured Products Section --}}

            </div>
        </div>
</div>
