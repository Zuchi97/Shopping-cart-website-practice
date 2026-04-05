<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({ cart: Object, products: Array, total: Number })

const quantities = ref({})
props.products.forEach(p => {
    quantities.value[p.id] = props.cart[p.id]
})

function update(productId) {
    router.patch(route('cart.update', productId), {
        quantity: quantities.value[productId]
    })
}

function remove(productId) {
    router.delete(route('cart.remove', productId))
}

function checkout() {
    router.post(route('orders.store'))
}

function computedTotal() {
    return props.products.reduce((sum, p) => {
        return sum + p.price * (quantities.value[p.id] || props.cart[p.id])
    }, 0)
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
                <!-- 表頭 -->
                <div class="grid grid-cols-12 gap-4 pb-4 border-b border-gray-100 text-xs tracking-widest uppercase text-gray-400">
                    <div class="col-span-6">商品</div>
                    <div class="col-span-3 text-center">數量</div>
                    <div class="col-span-2 text-right">小計</div>
                    <div class="col-span-1"></div>
                </div>

                <!-- 商品列 -->
                <div v-for="product in products" :key="product.id"
                    class="grid grid-cols-12 gap-4 py-8 border-b border-gray-50 items-center">
                    <!-- 商品資訊 -->
                    <div class="col-span-6 flex items-center gap-5">
                        <div class="w-20 h-20 bg-gray-50 flex-shrink-0 overflow-hidden">
                            <img :src="product.image || 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200'"
                                class="w-full h-full object-cover" :alt="product.name">
                        </div>
                        <div>
                            <h3 class="font-medium text-[#1C1C1C] text-sm mb-1">{{ product.name }}</h3>
                            <p class="text-gray-400 text-xs">NT$ {{ Number(product.price).toLocaleString() }}</p>
                        </div>
                    </div>

                    <!-- 數量調整 -->
                    <div class="col-span-3 flex items-center justify-center gap-3">
                        <button
                            @click="quantities[product.id] = Math.max(1, quantities[product.id] - 1); update(product.id)"
                            class="w-8 h-8 border border-gray-200 text-gray-400 hover:border-[#1C1C1C] hover:text-[#1C1C1C] transition flex items-center justify-center text-lg leading-none">
                            −
                        </button>
                        <span class="w-8 text-center text-sm text-[#1C1C1C] font-medium">
                            {{ quantities[product.id] }}
                        </span>
                        <button
                            @click="quantities[product.id] = quantities[product.id] + 1; update(product.id)"
                            class="w-8 h-8 border border-gray-200 text-gray-400 hover:border-[#1C1C1C] hover:text-[#1C1C1C] transition flex items-center justify-center text-lg leading-none">
                            ＋
                        </button>
                    </div>

                    <!-- 小計 -->
                    <div class="col-span-2 text-right text-sm font-medium text-[#1C1C1C]">
                        NT$ {{ Number(product.price * quantities[product.id]).toLocaleString() }}
                    </div>

                    <!-- 刪除 -->
                    <div class="col-span-1 flex justify-end">
                        <button @click="remove(product.id)"
                            class="text-gray-300 hover:text-red-400 transition text-lg">✕</button>
                    </div>
                </div>

                <!-- 總計與結帳 -->
                <div class="mt-10 flex justify-between items-end">
                    <a :href="route('home')"
                        class="text-xs tracking-widest uppercase text-gray-400 hover:text-[#1C1C1C] transition">
                        ← 繼續購物
                    </a>
                    <div class="text-right">
                        <p class="text-xs tracking-widest uppercase text-gray-400 mb-2">訂單總計</p>
                        <p class="font-serif text-4xl text-[#1C1C1C] mb-6">
                            NT$ {{ Number(computedTotal()).toLocaleString() }}
                        </p>
                        <button @click="checkout"
                            class="bg-[#1C1C1C] text-white px-16 py-4 text-xs tracking-widest uppercase hover:bg-gray-800 transition">
                            結帳
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
