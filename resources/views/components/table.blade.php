@props(['columns', 'dataUrl'])

<div {{ $attributes->merge(['x-data' => "tableComponent({ columns: ".json_encode($columns).", dataUrl: '{$dataUrl}' })"]) }}>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                @foreach ($columns as $col)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $col['header'] }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" x-ref="tbody">
            <!-- Rows will be injected by Alpine controller -->
        </tbody>
    </table>

    <div class="mt-4 flex justify-between">
        <button x-on:click="prevPage()" x-bind:disabled="!canPrev" class="px-4 py-2 bg-gray-200 rounded">Previous</button>
        <span x-text="page"></span>
        <button x-on:click="nextPage()" x-bind:disabled="!canNext" class="px-4 py-2 bg-gray-200 rounded">Next</button>
    </div>
</div> 