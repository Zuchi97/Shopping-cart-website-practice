<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
defineProps({ orders: Array })
</script>

<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-8 py-16">
            <h1 class="font-serif text-4xl text-[#1C1C1C] mb-12">我的訂單</h1>

            <div v-if="orders.length === 0" class="text-center py-24 text-gray-400">
                <p class="text-lg mb-8">尚無訂單記錄</p>
                <a :href="route('home')"
                    class="bg-[#1C1C1C] text-white px-10 py-4 text-xs tracking-widest uppercase hover:bg-gray-800 transition inline-block">
                    開始購物
                </a>
            </div>

            <div v-else class="space-y-6">
                <div v-for="order in orders" :key="order.id"
                    class="border border-gray-100 p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-xs tracking-widest uppercase text-gray-400 mb-1">訂單編號</p>
                            <p class="font-medium text-[#1C1C1C]">#{{ String(order.id).padStart(6, '0') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs tracking-widest uppercase text-gray-400 mb-1">狀態</p>
                            <span class="bg-[#1C1C1C] text-white text-xs px-3 py-1">{{ order.status }}</span>
                        </div>
                    </div>
                    <div class="space-y-3 mb-6">
                        <div v-for="item in order.items" :key="item.id"
                            class="flex justify-between text-sm text-gray-500">
                            <span>{{ item.product.name }} × {{ item.quantity }}</span>
                            <span>NT$ {{ Number(item.price * item.quantity).toLocaleString() }}</span>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 pt-4 flex justify-between">
                        <span class="text-sm text-gray-400">總計</span>
                        <span class="font-serif text-xl text-[#1C1C1C]">NT$ {{ Number(order.total).toLocaleString() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
