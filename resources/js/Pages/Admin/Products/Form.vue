<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'

const props = defineProps({ product: Object })

const form = useForm({
    name:        props.product?.name        || '',
    description: props.product?.description || '',
    price:       props.product?.price       || '',
    stock:       props.product?.stock       || 0,
    category:    props.product?.category    || '',
    image:       props.product?.image       || '',
})

function submit() {
    if (props.product) {
        form.put(route('admin.products.update', props.product.id))
    } else {
        form.post(route('admin.products.store'))
    }
}
</script>

<template>
    <AppLayout>
        <div class="max-w-2xl mx-auto px-8 py-16">
            <div class="flex items-center gap-4 mb-12">
                <Link :href="route('admin.products.index')"
                    class="text-gray-400 hover:text-[#1C1C1C] transition text-sm">← 返回列表</Link>
                <h1 class="font-serif text-4xl text-[#1C1C1C]">
                    {{ product ? '編輯商品' : '新增商品' }}
                </h1>
            </div>

            <form @submit.prevent="submit" class="space-y-8">
                <!-- 商品名稱 -->
                <div>
                    <label class="block text-xs tracking-widest uppercase text-gray-400 mb-3">商品名稱</label>
                    <input v-model="form.name" type="text"
                        class="w-full border border-gray-200 px-4 py-3 text-sm text-[#1C1C1C] focus:outline-none focus:border-[#1C1C1C] transition bg-transparent"
                        placeholder="輸入商品名稱">
                    <p v-if="form.errors.name" class="text-red-400 text-xs mt-2">{{ form.errors.name }}</p>
                </div>

                <!-- 商品描述 -->
                <div>
                    <label class="block text-xs tracking-widest uppercase text-gray-400 mb-3">商品描述</label>
                    <textarea v-model="form.description" rows="4"
                        class="w-full border border-gray-200 px-4 py-3 text-sm text-[#1C1C1C] focus:outline-none focus:border-[#1C1C1C] transition bg-transparent resize-none"
                        placeholder="輸入商品描述"></textarea>
                </div>

                <!-- 價格 & 庫存 -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs tracking-widest uppercase text-gray-400 mb-3">價格 (NT$)</label>
                        <input v-model="form.price" type="number" min="0"
                            class="w-full border border-gray-200 px-4 py-3 text-sm text-[#1C1C1C] focus:outline-none focus:border-[#1C1C1C] transition bg-transparent"
                            placeholder="0">
                        <p v-if="form.errors.price" class="text-red-400 text-xs mt-2">{{ form.errors.price }}</p>
                    </div>
                    <div>
                        <label class="block text-xs tracking-widest uppercase text-gray-400 mb-3">庫存數量</label>
                        <input v-model="form.stock" type="number" min="0"
                            class="w-full border border-gray-200 px-4 py-3 text-sm text-[#1C1C1C] focus:outline-none focus:border-[#1C1C1C] transition bg-transparent"
                            placeholder="0">
                        <p v-if="form.errors.stock" class="text-red-400 text-xs mt-2">{{ form.errors.stock }}</p>
                    </div>
                </div>

                <!-- 分類 -->
                <div>
                    <label class="block text-xs tracking-widest uppercase text-gray-400 mb-3">分類</label>
                    <input v-model="form.category" type="text"
                        class="w-full border border-gray-200 px-4 py-3 text-sm text-[#1C1C1C] focus:outline-none focus:border-[#1C1C1C] transition bg-transparent"
                        placeholder="例如：配件、居家、服飾">
                </div>

                <!-- 圖片網址 -->
                <div>
                    <label class="block text-xs tracking-widest uppercase text-gray-400 mb-3">圖片網址</label>
                    <input v-model="form.image" type="url"
                        class="w-full border border-gray-200 px-4 py-3 text-sm text-[#1C1C1C] focus:outline-none focus:border-[#1C1C1C] transition bg-transparent"
                        placeholder="https://...">
                    <!-- 圖片預覽 -->
                    <div v-if="form.image" class="mt-4 w-32 h-32 bg-gray-100 overflow-hidden">
                        <img :src="form.image" class="w-full h-full object-cover" alt="預覽">
                    </div>
                </div>

                <!-- 送出按鈕 -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" :disabled="form.processing"
                        class="bg-[#1C1C1C] text-white px-12 py-4 text-xs tracking-widest uppercase hover:bg-gray-800 transition disabled:opacity-50">
                        {{ product ? '更新商品' : '新增商品' }}
                    </button>
                    <Link :href="route('admin.products.index')"
                        class="border border-gray-200 text-gray-400 px-8 py-4 text-xs tracking-widest uppercase hover:border-[#1C1C1C] hover:text-[#1C1C1C] transition">
                        取消
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
