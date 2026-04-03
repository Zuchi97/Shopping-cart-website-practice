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
        <section class="min-h-[90vh] flex items-center px-8 bg-[#FAF8F5]">
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div>
                    <p class="text-xs tracking-widest uppercase text-gray-400 mb-6">新品上市</p>
                    <h1 class="font-serif text-6xl md:text-7xl text-[#1C1C1C] leading-tight mb-8">
                        精選好物<br>一次擁有
                    </h1>
                    <p class="text-gray-400 text-lg mb-10 font-light">嚴選品質，讓每一次購物都成為享受。</p>
                    <a href="#products"
                        class="bg-[#1C1C1C] text-white px-10 py-4 text-xs tracking-widest uppercase hover:bg-gray-800 transition inline-block">
                        立即選購
                    </a>
                </div>
                <div class="aspect-square bg-gray-100 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800"
                        class="w-full h-full object-cover" alt="Hero">
                </div>
            </div>
        </section>

        <!-- Products -->
        <section id="products" class="py-24 px-8 bg-white">
            <div class="max-w-6xl mx-auto">
                <h2 class="font-serif text-4xl mb-16 text-[#1C1C1C]">所有商品</h2>

                <div v-if="products.data.length === 0" class="text-center py-24 text-gray-400">
                    目前沒有商品
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <div v-for="product in products.data" :key="product.id" class="group">
                        <div class="aspect-square bg-gray-50 overflow-hidden mb-4">
                            <img :src="product.image || 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400'"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                :alt="product.name">
                        </div>
                        <h3 class="font-medium text-[#1C1C1C] mb-1">{{ product.name }}</h3>
                        <p class="text-gray-400 text-sm mb-4">NT$ {{ Number(product.price).toLocaleString() }}</p>
                        <button @click="addToCart(product.id)"
                            class="w-full border border-[#1C1C1C] text-[#1C1C1C] text-xs tracking-widest uppercase py-3 hover:bg-[#1C1C1C] hover:text-white transition">
                            加入購物車
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
