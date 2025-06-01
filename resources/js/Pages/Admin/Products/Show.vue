<template>
  <AdminLayout :title="product ? product.name : 'Product Details'">
    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header with back button and actions -->
        <div class="mb-6 flex justify-between items-center">
          <div class="flex items-center">
            <Link 
              :href="route('admin.products.index')" 
              class="text-gray-500 hover:text-gray-700 mr-4"
            >
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
            </Link>
            <h1 class="text-2xl font-semibold text-gray-900">
              {{ product ? product.name : 'Product Details' }}
            </h1>
          </div>
          <div class="space-x-2">
            <Link 
              :href="route('admin.products.edit', product.id)" 
              class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
              Edit Product
            </Link>
          </div>
        </div>

        <!-- Main content -->
        <div v-if="product" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
              <!-- Left column - Product Image -->
              <div class="lg:col-span-1">
                <div class="bg-gray-100 rounded-lg overflow-hidden">
                  <img 
                    v-if="product.image" 
                    :src="product.image" 
                    :alt="product.name"
                    class="w-full h-64 object-cover"
                  >
                  <div v-else class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-400">
                    <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="mt-6 grid grid-cols-2 gap-4">
                  <div class="bg-gray-50 p-4 rounded-lg text-center">
                    <dt class="text-sm font-medium text-gray-500">Price</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">
                      {{ formatCurrency(product.price) }}
                    </dd>
                  </div>
                  <div class="bg-gray-50 p-4 rounded-lg text-center">
                    <dt class="text-sm font-medium text-gray-500">In Stock</dt>
                    <dd class="mt-1 text-lg font-semibold" :class="{
                      'text-green-600': product.stock_quantity > 10,
                      'text-yellow-600': product.stock_quantity > 0 && product.stock_quantity <= 10,
                      'text-red-600': product.stock_quantity === 0
                    }">
                      {{ product.stock_quantity !== null ? product.stock_quantity : 'N/A' }}
                    </dd>
                  </div>
                </div>
                
                <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                  <dt class="text-sm font-medium text-gray-500">Status</dt>
                  <dd class="mt-1">
                    <span 
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                      :class="{
                        'bg-green-100 text-green-800': product.is_published,
                        'bg-gray-100 text-gray-800': !product.is_published
                      }"
                    >
                      {{ product.is_published ? 'Published' : 'Draft' }}
                    </span>
                  </dd>
                </div>
              </div>
              
              <!-- Right column - Product Details -->
              <div class="lg:col-span-2">
                <div class="space-y-6">
                  <!-- Basic Information -->
                  <div>
                    <h2 class="text-lg font-medium text-gray-900">Product Information</h2>
                    <dl class="mt-4 space-y-4">
                      <div class="border-t border-gray-200 pt-4">
                        <dt class="text-sm font-medium text-gray-500">SKU</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ product.sku || 'N/A' }}</dd>
                      </div>
                      <div class="border-t border-gray-200 pt-4">
                        <dt class="text-sm font-medium text-gray-500">Category</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                          <Link 
                            v-if="product.category"
                            :href="route('admin.categories.show', product.category.id)" 
                            class="text-indigo-600 hover:text-indigo-800"
                          >
                            {{ product.category.name }}
                          </Link>
                          <span v-else>Uncategorized</span>
                        </dd>
                      </div>
                      <div class="border-t border-gray-200 pt-4">
                        <dt class="text-sm font-medium text-gray-500">Slug</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ product.slug }}</dd>
                      </div>
                    </dl>
                  </div>
                  
                  <!-- Description -->
                  <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-medium text-gray-900">Description</h2>
                    <div class="mt-4 prose max-w-none">
                      <p v-if="product.description" class="text-gray-700 whitespace-pre-line">{{ product.description }}</p>
                      <p v-else class="text-gray-500 italic">No description provided.</p>
                    </div>
                  </div>
                  
                  <!-- Additional Details -->
                  <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-medium text-gray-900">Additional Information</h2>
                    <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ formatDate(product.created_at) }}</dd>
                      </div>
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Updated At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ formatDate(product.updated_at) }}</dd>
                      </div>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div v-else class="text-center py-12">
          <p class="text-gray-500">Loading product details...</p>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  product: {
    type: Object,
    required: true
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
