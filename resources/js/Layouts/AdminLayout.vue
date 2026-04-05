<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const auth = computed(() => page.props.auth)

const navItems = [
    { label: '商品管理', route: 'admin.products.index' },
    { label: '訂單管理', route: 'admin.orders.index' },
]
</script>

<template>
    <div class="min-h-screen bg-[#F5F4F0] font-sans flex">

        <!-- 側邊欄 -->
        <aside class="fixed top-0 left-0 h-full w-56 bg-[#1C1C1C] flex flex-col z-50">
            <!-- Logo -->
            <div class="px-8 py-8 border-b border-white/10">
                <Link :href="route('home')" class="font-serif text-xl text-white tracking-tight">Shop</Link>
                <p class="text-xs text-gray-500 mt-1 tracking-widest uppercase">Admin</p>
            </div>

            <!-- 導覽 -->
            <nav class="flex-1 px-4 py-8 space-y-1">
                <Link v-for="item in navItems" :key="item.route"
                    :href="route(item.route)"
                    class="flex items-center px-4 py-3 text-sm rounded-sm transition"
                    :class="$page.url.startsWith('/' + item.route.replace('admin.', 'admin/').replace('.index', ''))
                        ? 'bg-white/10 text-white'
                        : 'text-gray-400 hover:text-white hover:bg-white/5'">
                    {{ item.label }}
                </Link>
            </nav>

            <!-- 底部 -->
            <div class="px-8 py-6 border-t border-white/10 space-y-3">
                <Link :href="route('home')"
                    class="block text-xs text-gray-500 hover:text-white transition tracking-wide">
                    ← 返回前台
                </Link>
                <Link :href="route('logout')" method="post" as="button"
                    class="block text-xs text-gray-500 hover:text-white transition tracking-wide">
                    登出
                </Link>
            </div>
        </aside>

        <!-- 主內容區 -->
        <div class="ml-56 flex-1 flex flex-col min-h-screen">
            <!-- 頂部列 -->
            <header class="bg-white border-b border-gray-100 px-10 py-4 flex justify-between items-center">
                <h2 class="text-sm text-gray-400 tracking-wide">{{ $page.props.auth.user?.name }}</h2>
                <div class="flex items-center gap-6 text-xs text-gray-400">
                    <Link :href="route('home')" class="hover:text-[#1C1C1C] transition">前往前台 →</Link>
                </div>
            </header>

            <!-- Flash Message -->
            <div v-if="$page.props.flash?.success"
                class="mx-10 mt-6 bg-green-50 border border-green-200 text-green-700 text-sm px-6 py-3">
                {{ $page.props.flash.success }}
            </div>
            <div v-if="$page.props.flash?.error"
                class="mx-10 mt-6 bg-red-50 border border-red-200 text-red-500 text-sm px-6 py-3">
                {{ $page.props.flash.error }}
            </div>

            <!-- 頁面內容 -->
            <main class="flex-1 p-10">
                <slot />
            </main>

            <footer class="px-10 py-6 text-xs text-gray-300 border-t border-gray-100">
                © 2025 Shop Admin
            </footer>
        </div>
    </div>
</template>
