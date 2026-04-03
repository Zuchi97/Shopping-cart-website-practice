<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { router } from '@inertiajs/vue3'

defineProps({ products: Object })

function addToCart(productId) {
    router.post(route('cart.add', productId), { quantity: 1 })
}
</script>

<template>
    <AppLayout>
        <!-- Hero -->
        <section class="relative min-h-screen flex items-center overflow-hidden bg-[#FAF8F5]">
            <!-- 背景裝飾 -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-0 right-0 w-1/2 h-full bg-[#F0EDE8]"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-8 w-full grid grid-cols-1 md:grid-cols-2 gap-16 items-center py-24">
                <div>
                    <p class="text-xs tracking-widest uppercase text-gray-400 mb-8">2025 新品系列</p>
                    <h1 class="font-serif text-6xl md:text-8xl text-[#1C1C1C] leading-none mb-8">
                        精選<br>好物
                    </h1>
                    <div class="w-12 h-px bg-[#1C1C1C] mb-8"></div>
                    <p class="text-gray-400 text-lg mb-12 font-light leading-relaxed max-w-sm">
                        嚴選每一件商品的品質與設計，<br>讓購物成為一種享受。
                    </p>
                    <div class="flex items-center gap-6">
                        <a href="#products"
                            class="bg-[#1C1C1C] text-white px-10 py-4 text-xs tracking-widest uppercase hover:bg-gray-700 transition">
                            立即選購
                        </a>
                        <a href="#products" class="text-xs tracking-widest uppercase text-gray-400 hover:text-gray-600 transition">
                            瀏覽全部 →
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="aspect-[4/5] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=900"
                            class="w-full h-full object-cover" alt="Hero">
                    </div>
                    <!-- 浮動標籤 -->
                    <div class="absolute -bottom-6 -left-6 bg-white p-6 shadow-sm">
                        <p class="text-xs tracking-widest uppercase text-gray-400 mb-1">本季精選</p>
                        <p class="font-serif text-2xl text-[#1C1C1C]">{{ products.total }} 件商品</p>
                    </div>
                </div>
            </div>

            <!-- 往下滾動提示 -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-gray-300">
                <span class="text-xs tracking-widest uppercase">Scroll</span>
                <div class="w-px h-12 bg-gray-300 animate-pulse"></div>
            </div>
        </section>

        <!-- 特色區塊 -->
        <section class="py-16 bg-white border-y border-gray-100">
            <div class="max-w-7xl mx-auto px-8 grid grid-cols-3 gap-8 text-center">
                <div>
                    <p class="text-xs tracking-widest uppercase text-gray-400 mb-2">品質保證</p>
                    <p class="font-serif text-lg text-[#1C1C1C]">嚴選商品</p>
                </div>
                <div class="border-x border-gray-100">
                    <p class="text-xs tracking-widest uppercase text-gray-400 mb-2">快速配送</p>
                    <p class="font-serif text-lg text-[#1C1C1C]">全台免運</p>
                </div>
                <div>
                    <p class="text-xs tracking-widest uppercase text-gray-400 mb-2">安心購物</p>
                    <p class="font-serif text-lg text-[#1C1C1C]">7天退換貨</p>
                </div>
            </div>
        </section>

        <!-- 商品列表 -->
        <section id="products" class="py-24 px-8 bg-[#FAF8F5]">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-end mb-16">
                    <h2 class="font-serif text-5xl text-[#1C1C1C]">所有商品</h2>
                    <p class="text-sm text-gray-400">共 {{ products.total }} 件</p>
                </div>

                <div v-if="products.data.length === 0" class="text-center py-24 text-gray-400">
                    目前沒有商品
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-8 gap-y-16">
                    <div v-for="product in products.data" :key="product.id" class="group">
                        <div class="aspect-square bg-gray-100 overflow-hidden mb-5">
                            <img :src="product.image || 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400'"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-700"
                                :alt="product.name">
                        </div>
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-medium text-[#1C1C1C] text-sm leading-tight">{{ product.name }}</h3>
                            <p class="text-gray-400 text-sm ml-4 flex-shrink-0">NT$ {{ Number(product.price).toLocaleString() }}</p>
                        </div>
                        <p class="text-gray-400 text-xs mb-4 line-clamp-1">{{ product.description }}</p>
                        <button @click="addToCart(product.id)"
                            class="w-full border border-[#1C1C1C] text-[#1C1C1C] text-xs tracking-widest uppercase py-3 hover:bg-[#1C1C1C] hover:text-white transition duration-300">
                            加入購物車
                        </button>
                    </div>
                </div>

                <!-- 分頁 -->
                <div v-if="products.last_page > 1" class="mt-16 flex justify-center gap-2">
                    <a v-for="page in products.last_page" :key="page"
                        :href="`/?page=${page}`"
                        class="w-10 h-10 flex items-center justify-center text-sm border transition"
                        :class="page === products.current_page
                            ? 'bg-[#1C1C1C] text-white border-[#1C1C1C]'
                            : 'border-gray-200 text-gray-400 hover:border-[#1C1C1C] hover:text-[#1C1C1C]'">
                        {{ page }}
                    </a>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
