<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'

defineProps({ products: Object })

function destroy(id) {
    if (confirm('確定要刪除這個商品嗎？')) {
        router.delete(route('admin.products.destroy', id))
    }
}
</script>

<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto px-8 py-16">
            <div class="flex justify-between items-center mb-12">
                <h1 class="font-serif text-4xl text-[#1C1C1C]">後台管理</h1>
                <Link :href="route('admin.products.create')"
                    class="bg-[#1C1C1C] text-white px-8 py-3 text-xs tracking-widest uppercase hover:bg-gray-800 transition">
                    ＋ 新增商品
                </Link>
            </div>

            <div class="border border-gray-100">
                <!-- 表頭 -->
                <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-gray-50 text-xs tracking-widest uppercase text-gray-400 border-b border-gray-100">
                    <div class="col-span-1">圖片</div>
                    <div class="col-span-4">商品名稱</div>
                    <div class="col-span-2">分類</div>
                    <div class="col-span-2">價格</div>
                    <div class="col-span-1">庫存</div>
                    <div class="col-span-2 text-right">操作</div>
                </div>

                <!-- 商品列表 -->
                <div v-for="product in products.data" :key="product.id"
                    class="grid grid-cols-12 gap-4 px-6 py-4 items-center border-b border-gray-50 hover:bg-gray-50 transition">
                    <div class="col-span-1">
                        <div class="w-12 h-12 bg-gray-100 overflow-hidden">
                            <img :src="product.image || 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100'"
                                class="w-full h-full object-cover" :alt="product.name">
                        </div>
                    </div>
                    <div class="col-span-4">
                        <p class="font-medium text-[#1C1C1C] text-sm">{{ product.name }}</p>
                        <p class="text-gray-400 text-xs mt-1 line-clamp-1">{{ product.description }}</p>
                    </div>
                    <div class="col-span-2 text-sm text-gray-500">{{ product.category || '—' }}</div>
                    <div class="col-span-2 text-sm text-[#1C1C1C] font-medium">
                        NT$ {{ Number(product.price).toLocaleString() }}
                    </div>
                    <div class="col-span-1 text-sm" :class="product.stock > 0 ? 'text-gray-500' : 'text-red-400'">
                        {{ product.stock }}
                    </div>
                    <div class="col-span-2 flex justify-end gap-4">
                        <Link :href="route('admin.products.edit', product.id)"
                            class="text-xs tracking-wide text-gray-400 hover:text-[#1C1C1C] transition">編輯</Link>
                        <button @click="destroy(product.id)"
                            class="text-xs tracking-wide text-gray-400 hover:text-red-500 transition">刪除</button>
                    </div>
                </div>

                <div v-if="products.data.length === 0" class="px-6 py-16 text-center text-gray-400">
                    目前沒有商品
                </div>
            </div>

            <!-- 分頁 -->
            <div v-if="products.last_page > 1" class="mt-8 flex justify-center gap-2">
                <a v-for="page in products.last_page" :key="page"
                    :href="`/admin/products?page=${page}`"
                    class="w-10 h-10 flex items-center justify-center text-sm border transition"
                    :class="page === products.current_page
                        ? 'bg-[#1C1C1C] text-white border-[#1C1C1C]'
                        : 'border-gray-200 text-gray-400 hover:border-[#1C1C1C]'">
                    {{ page }}
                </a>
            </div>
        </div>
    </AppLayout>
</template>
