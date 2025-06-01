<template>
  <AdminLayout title="Category Details">
    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header with back button and actions -->
        <div class="mb-6 flex justify-between items-center">
          <div class="flex items-center">
            <Link 
              :href="route('admin.categories.index')" 
              class="text-gray-500 hover:text-gray-700 mr-4"
            >
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
            </Link>
            <h1 class="text-2xl font-semibold text-gray-900">Category Details</h1>
          </div>
          <div class="space-x-2">
            <Link 
              :href="route('admin.categories.edit', category.id)" 
              class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
              Edit Category
            </Link>
          </div>
        </div>

        <!-- Main content -->
        <div v-if="category" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <h2 class="text-lg font-medium text-gray-900">Basic Information</h2>
                <dl class="mt-4 space-y-4">
                  <div class="border-t border-gray-200 pt-4">
                    <dt class="text-sm font-medium text-gray-500">ID</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ category.id }}</dd>
                  </div>
                  <div class="border-t border-gray-200 pt-4">
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ category.name }}</dd>
                  </div>
                  <div class="border-t border-gray-200 pt-4">
                    <dt class="text-sm font-medium text-gray-500">Slug</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ category.slug }}</dd>
                  </div>
                  <div class="border-t border-gray-200 pt-4">
                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ formatDate(category.created_at) }}</dd>
                  </div>
                  <div class="border-t border-gray-200 pt-4">
                    <dt class="text-sm font-medium text-gray-500">Updated At</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ formatDate(category.updated_at) }}</dd>
                  </div>
                </dl>
              </div>
              
              <div>
                <h2 class="text-lg font-medium text-gray-900">Description</h2>
                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                  <p v-if="category.description" class="text-gray-700">{{ category.description }}</p>
                  <p v-else class="text-gray-500 italic">No description provided.</p>
                </div>

                <h2 class="mt-8 text-lg font-medium text-gray-900">Products in this Category</h2>
                <div v-if="category.products && category.products.length > 0" class="mt-4 space-y-2">
                  <div v-for="product in category.products" :key="product.id" class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <Link 
                      :href="route('admin.products.show', product.id)" 
                      class="text-indigo-600 hover:text-indigo-800 font-medium"
                    >
                      {{ product.name }}
                    </Link>
                    <p class="text-sm text-gray-500">
                      {{ formatCurrency(product.price) }}
                      <span v-if="product.stock_quantity !== null" class="ml-2">
                        • {{ product.stock_quantity }} in stock
                      </span>
                    </p>
                  </div>
                </div>
                <div v-else class="mt-4 p-4 bg-gray-50 rounded-lg text-gray-500">
                  No products found in this category.
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div v-else class="text-center py-12">
          <p class="text-gray-500">Loading category details...</p>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { computed } from 'vue';

const props = defineProps({
  category: {
    type: Object,
    required: true
  },
  products: {
    type: Array,
    default: () => []
  }
});

const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const formatCurrency = (amount) => {
  if (amount === null || amount === undefined) return 'N/A';
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
  }).format(amount);
};
</script>
