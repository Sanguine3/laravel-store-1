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
        <div class="flex justify-end">
            <x-button href="{{ route('admin.users.create') }}" variant="warning">
                Add New User
            </x-button>
        </div>
        <!-- Grid.js Users Table -->
        <div id="users-table" class="overflow-x-auto"></div>
    </div>
    <!-- Include AlpineJS if not already included globally -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-layouts.admin>
