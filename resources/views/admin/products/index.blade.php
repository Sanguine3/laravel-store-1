<x-layouts.admin>
    @if (session('status'))
        <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 px-4 py-2 rounded bg-red-100 text-red-800 border border-red-300">
            {{ session('error') }}
        </div>
    @endif
    <div class="flex flex-col gap-6">
        <div class="flex justify-end">
            <x-button href="{{ route('admin.products.create') }}" variant="warning">
                Add New Product
            </x-button>
        </div>
        <!-- Grid.js Products Table -->
        <div id="products-table" class="overflow-x-auto"></div>
    </div>
</x-layouts.admin>
