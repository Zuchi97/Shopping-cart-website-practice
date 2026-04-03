<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({ cart: Object, products: Array, total: Number })

function remove(productId) {
    router.delete(route('cart.remove', productId))
}
function checkout() {
    router.post(route('orders.store'))
}
</script>

<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-8 py-16">
            <h1 class="font-serif text-4xl text-[#1C1C1C] mb-12">購物車</h1>

            <div v-if="products.length === 0" class="text-center py-24 text-gray-400">
                <p class="text-lg mb-8">購物車是空的</p>
                <a :href="route('home')"
                    class="bg-[#1C1C1C] text-white px-10 py-4 text-xs tracking-widest uppercase hover:bg-gray-800 transition inline-block">
                    繼續購物
                </a>
            </div>

            <div v-else>
                <div class="border-t border-gray-100">
                    <div v-for="product in products" :key="product.id"
                        class="flex items-center gap-6 py-8 border-b border-gray-100">
                        <div class="w-24 h-24 bg-gray-50 flex-shrink-0 overflow-hidden">
                            <img :src="product.image || 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200'"
                                class="w-full h-full object-cover" :alt="product.name">
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-[#1C1C1C] mb-1">{{ product.name }}</h3>
                            <p class="text-gray-400 text-sm">NT$ {{ Number(product.price).toLocaleString() }}</p>
                        </div>
                        <div class="text-sm text-gray-500">
                            數量：{{ cart[product.id] }}
                        </div>
                        <div class="font-medium text-[#1C1C1C] w-24 text-right">
                            NT$ {{ Number(product.price * cart[product.id]).toLocaleString() }}
                        </div>
                        <button @click="remove(product.id)"
                            class="text-gray-300 hover:text-red-400 transition text-xl ml-4">✕</button>
                    </div>
                </div>

                <div class="mt-8 flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">訂單總計</p>
                        <p class="font-serif text-3xl text-[#1C1C1C]">NT$ {{ Number(total).toLocaleString() }}</p>
                    </div>
                    <button @click="checkout"
                        class="bg-[#1C1C1C] text-white px-12 py-4 text-xs tracking-widest uppercase hover:bg-gray-800 transition">
                        結帳
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
