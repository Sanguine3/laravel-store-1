import { Grid, html } from 'gridjs';
import 'gridjs/dist/theme/mermaid.css';
import { getCategories } from './api';

(async function () {
  const wrapper = document.getElementById('categories-table');
  if (!wrapper) return;

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  // Fetch paginated categories JSON
  const response = await getCategories();
  const items = response.data || response; // Laravel wraps data

  // Prepare data rows: [id, name, description, products_count, slug]
  const data = items.map(item => [
    item.id,
    item.name,
    item.description,
    item.products_count,
    item.slug,
  ]);

  // Initialize Grid.js
  new Grid({
    columns: [
      { id: 'id', name: 'ID', hidden: true },
      { id: 'name', name: 'Name' },
      { id: 'description', name: 'Description' },
      { id: 'products_count', name: 'Products' },
      { id: 'slug', name: 'Slug' },
      {
        name: 'Actions',
        formatter: (cell, row) => html(
          `<a href="/admin/categories/${row.cells[0].data}/edit" class="text-blue-500 hover:underline mr-2">Edit</a>` +
          `<form action="/admin/categories/${row.cells[0].data}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">` +
          `<input type="hidden" name="_token" value="${csrfToken}">` +
          `<input type="hidden" name="_method" value="DELETE">` +
          `<button type="submit" class="text-red-600 hover:underline">Delete</button>` +
          `</form>`
        )
      }
    ],
    data,
    search: true,
    sort: true,
    pagination: {
      enabled: true,
      limit: 15
    }
  }).render(wrapper);
})(); 