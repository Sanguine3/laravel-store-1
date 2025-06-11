import { Grid, html } from 'gridjs';
import 'gridjs/dist/theme/mermaid.css';
import { getProducts } from './api';

(async function () {
  const wrapper = document.getElementById('products-table');
  if (!wrapper) return;

  // Fetch initial products data
  const response = await getProducts();
  const items = response.data || response;

  const data = items.map(p => [
    p.id,
    p.name,
    `$${p.price.toFixed(2)}`,
    p.category?.name || '—',
    p.stock_quantity,
    p.is_published ? 'Yes' : 'No',
  ]);

  new Grid({
    columns: [
      { id: 'id', name: 'ID', hidden: true },
      { id: 'name', name: 'Product' },
      { id: 'price', name: 'Price' },
      { id: 'category', name: 'Category' },
      { id: 'stock', name: 'Stock' },
      { id: 'published', name: 'Published' },
      {
        name: 'Actions',
        formatter: (cell, row) => html(
          `<a href="/admin/products/${row.cells[0].data}/edit" class="text-blue-600 hover:underline mr-2">Edit</a>` +
          `<form action="/admin/products/${row.cells[0].data}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this product?');">` +
          `<input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').getAttribute('content')}">` +
          `<input type="hidden" name="_method" value="DELETE">` +
          `<button type="submit" class="text-red-600 hover:underline">Delete</button>` +
          `</form>`
        )
      }
    ],
    data,
    search: true,
    sort: true,
    pagination: { enabled: true, limit: 15 }
  }).render(wrapper);
})(); 