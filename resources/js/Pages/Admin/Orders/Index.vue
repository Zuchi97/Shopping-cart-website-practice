<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'

defineProps({ orders: Object })

const statusLabels = {
    pending:    '待處理',
    processing: '處理中',
    completed:  '已完成',
    cancelled:  '已取消',
}

const statusColors = {
    pending:    'bg-amber-50 text-amber-700 border-amber-200',
    processing: 'bg-blue-50 text-blue-700 border-blue-200',
    completed:  'bg-green-50 text-green-700 border-green-200',
    cancelled:  'bg-red-50 text-red-400 border-red-200',
}

function updateStatus(order, status) {
    router.patch(route('admin.orders.update', order.id), { status })
}
</script>

<template>
    <AdminLayout>
        <div class="flex justify-between items-center mb-10">
            <h1 class="font-serif text-4xl text-[#1C1C1C]">訂單管理</h1>
        </div>

        <!-- 統計卡片 -->
        <div class="grid grid-cols-4 gap-6 mb-10">
            <div v-for="(label, key) in statusLabels" :key="key"
                class="bg-white border border-gray-100 p-6">
                <p class="text-xs tracking-widest uppercase text-gray-400 mb-2">{{ label }}</p>
                <p class="font-serif text-3xl text-[#1C1C1C]">
                    {{ orders.data.filter(o => o.status === key).length }}
                </p>
            </div>
        </div>

        <!-- 訂單列表 -->
        <div class="bg-white border border-gray-100">
            <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-gray-50 text-xs tracking-widest uppercase text-gray-400 border-b border-gray-100">
                <div class="col-span-2">訂單編號</div>
                <div class="col-span-2">會員</div>
                <div class="col-span-3">商品</div>
                <div class="col-span-2">總計</div>
                <div class="col-span-1">狀態</div>
                <div class="col-span-2 text-right">更新狀態</div>
            </div>

            <div v-if="orders.data.length === 0" class="px-6 py-16 text-center text-gray-400">
                目前沒有訂單
            </div>

            <div v-for="order in orders.data" :key="order.id"
                class="grid grid-cols-12 gap-4 px-6 py-5 items-center border-b border-gray-50 hover:bg-gray-50 transition">
                <div class="col-span-2">
                    <p class="font-medium text-sm text-[#1C1C1C]">#{{ String(order.id).padStart(6, '0') }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ new Date(order.created_at).toLocaleDateString('zh-TW') }}
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-[#1C1C1C]">{{ order.user.name }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ order.user.email }}</p>
                </div>
                <div class="col-span-3">
                    <div v-for="item in order.items" :key="item.id"
                        class="text-xs text-gray-500 leading-relaxed">
                        {{ item.product.name }} × {{ item.quantity }}
                    </div>
                </div>
                <div class="col-span-2">
                    <p class="font-medium text-sm text-[#1C1C1C]">
                        NT$ {{ Number(order.total).toLocaleString() }}
                    </p>
                </div>
                <div class="col-span-1">
                    <span class="text-xs px-2 py-1 border rounded-sm"
                        :class="statusColors[order.status]">
                        {{ statusLabels[order.status] }}
                    </span>
                </div>
                <div class="col-span-2 flex justify-end">
                    <select @change="updateStatus(order, $event.target.value)"
                        :value="order.status"
                        class="text-xs border border-gray-200 px-3 py-2 text-gray-500 focus:outline-none focus:border-[#1C1C1C] transition bg-transparent cursor-pointer">
                        <option value="pending">待處理</option>
                        <option value="processing">處理中</option>
                        <option value="completed">已完成</option>
                        <option value="cancelled">已取消</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 分頁 -->
        <div v-if="orders.last_page > 1" class="mt-8 flex justify-center gap-2">
            <a v-for="page in orders.last_page" :key="page"
                :href="`/admin/orders?page=${page}`"
                class="w-10 h-10 flex items-center justify-center text-sm border transition"
                :class="page === orders.current_page
                    ? 'bg-[#1C1C1C] text-white border-[#1C1C1C]'
                    : 'border-gray-200 text-gray-400 hover:border-[#1C1C1C]'">
                {{ page }}
            </a>
        </div>
    </AdminLayout>
</template>
