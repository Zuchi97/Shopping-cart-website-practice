<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const auth = computed(() => page.props.auth)
const cartCount = computed(() => {
    const cart = page.props.cart || {}
    return Object.keys(cart).length
})
</script>

<template>
    <div class="min-h-screen bg-[#FAF8F5] font-sans">
        <!-- Navbar -->
        <nav class="fixed top-0 w-full bg-[#FAF8F5]/90 backdrop-blur-sm z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <Link :href="route('home')" class="font-serif text-2xl tracking-tight text-[#1C1C1C]">
                    Shop
                </Link>
                <div class="flex items-center gap-8 text-sm text-[#1C1C1C]">
                    <Link :href="route('home')" class="hover:text-gray-400 transition">商品</Link>
                    <template v-if="auth.user">
                        <Link :href="route('cart.index')" class="hover:text-gray-400 transition relative">
                            購物車
                            <span v-if="cartCount > 0"
                                class="ml-1 bg-[#1C1C1C] text-white text-xs rounded-full px-2 py-0.5">
                                {{ cartCount }}
                            </span>
                        </Link>
                        <Link :href="route('orders.index')" class="hover:text-gray-400 transition">訂單</Link>
                        <Link :href="route('logout')" method="post" as="button"
                            class="hover:text-gray-400 transition">登出</Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')" class="hover:text-gray-400 transition">登入</Link>
                        <Link :href="route('register')"
                            class="bg-[#1C1C1C] text-white px-5 py-2 text-xs tracking-widest uppercase hover:bg-gray-800 transition">
                            註冊
                        </Link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Flash Message -->
        <div v-if="$page.props.flash?.success"
            class="fixed top-20 right-6 bg-[#1C1C1C] text-white text-sm px-6 py-3 z-50 shadow-lg">
            {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash?.error"
            class="fixed top-20 right-6 bg-red-600 text-white text-sm px-6 py-3 z-50 shadow-lg">
            {{ $page.props.flash.error }}
        </div>

        <!-- Content -->
        <main class="pt-16">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="mt-24 border-t border-gray-100 py-12 text-center text-sm text-gray-400">
            © 2025 Shop. All rights reserved.
        </footer>
    </div>
</template>
