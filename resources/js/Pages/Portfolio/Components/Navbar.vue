<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { 
    Sun, 
    Moon, 
    Menu, 
    X, 
    Terminal, 
    ArrowUpRight,
    LayoutDashboard
} from 'lucide-vue-next';

const props = defineProps({
    canLogin: Boolean,
    auth: Object,
});

const isDark = ref(true);
const isMobileMenuOpen = ref(false);
const isScrolled = ref(false);
const activeSection = ref('hero');

const navLinks = [
    { name: 'About', href: '#about' },
    { name: 'Skills', href: '#skills' },
    { name: 'Projects', href: '#projects' },
    { name: 'Experience', href: '#experience' },
    { name: 'Contact', href: '#contact' },
];

const toggleTheme = () => {
    isDark.value = !isDark.value;
    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;

    const sections = ['hero', 'about', 'skills', 'projects', 'experience', 'contact'];
    const scrollPosition = window.scrollY + 120;

    for (const section of sections) {
        const el = document.getElementById(section);
        if (el) {
            const top = el.offsetTop;
            const height = el.offsetHeight;
            if (scrollPosition >= top && scrollPosition < top + height) {
                activeSection.value = section;
                break;
            }
        }
    }
};

onMounted(() => {
    isDark.value = document.documentElement.classList.contains('dark');
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <header 
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-200"
        :class="[
            isScrolled 
                ? 'py-3.5 bg-white/90 dark:bg-zinc-950/90 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800 shadow-sm' 
                : 'py-5 bg-transparent'
        ]"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                
                <!-- Brand / Logo -->
                <a href="#hero" class="group flex items-center gap-2.5 tracking-tight">
                    <div class="w-9 h-9 rounded-xl bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 flex items-center justify-center transition-transform group-hover:scale-105">
                        <Terminal class="w-4 h-4 text-white dark:text-zinc-900" />
                    </div>
                    <span class="font-heading font-extrabold text-xl text-zinc-900 dark:text-white tracking-tight">
                        Ikbal<span class="text-indigo-600 dark:text-indigo-400">.dev</span>
                    </span>
                    <span class="flex h-2 w-2 relative -top-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-1 bg-zinc-100 dark:bg-zinc-900 p-1 rounded-full border border-zinc-200 dark:border-zinc-800">
                    <a 
                        v-for="item in navLinks" 
                        :key="item.name" 
                        :href="item.href"
                        class="px-4 py-1.5 rounded-full text-xs font-medium font-sans transition-colors duration-150"
                        :class="[
                            activeSection === item.href.replace('#', '')
                                ? 'bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white shadow-sm font-semibold'
                                : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white'
                        ]"
                    >
                        {{ item.name }}
                    </a>
                </nav>

                <!-- Right Actions -->
                <div class="flex items-center gap-3">
                    <!-- Theme Toggle Button -->
                    <button 
                        @click="toggleTheme" 
                        type="button"
                        aria-label="Toggle Dark Mode"
                        class="p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors"
                    >
                        <Sun v-if="isDark" class="w-4 h-4 text-amber-500" />
                        <Moon v-else class="w-4 h-4 text-zinc-700" />
                    </button>

                    <!-- Admin Dashboard Link (Only visible when authenticated) -->
                    <template v-if="auth?.user">
                        <Link 
                            :href="route('dashboard')"
                            class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors border border-zinc-200 dark:border-zinc-700"
                        >
                            <LayoutDashboard class="w-3.5 h-3.5 text-indigo-500" />
                            <span>Dashboard</span>
                        </Link>
                    </template>

                    <!-- Solid High-Contrast Contact CTA Button -->
                    <a 
                        href="#contact" 
                        class="hidden sm:inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-xs font-semibold font-sans bg-zinc-900 text-white hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100 shadow-sm transition-colors active:scale-95"
                    >
                        <span>Hire Me</span>
                        <ArrowUpRight class="w-3.5 h-3.5" />
                    </a>

                    <!-- Mobile Menu Hamburger -->
                    <button 
                        @click="isMobileMenuOpen = !isMobileMenuOpen"
                        type="button"
                        class="md:hidden p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300"
                        aria-label="Toggle Mobile Menu"
                    >
                        <X v-if="isMobileMenuOpen" class="w-5 h-5" />
                        <Menu v-else class="w-5 h-5" />
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Drawer -->
            <transition
                enter-active-class="transition duration-150 ease-out"
                enter-from-class="opacity-0 -translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-2"
            >
                <div 
                    v-if="isMobileMenuOpen" 
                    class="md:hidden mt-3 p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl space-y-2"
                >
                    <a 
                        v-for="item in navLinks" 
                        :key="item.name" 
                        :href="item.href"
                        @click="isMobileMenuOpen = false"
                        class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-colors"
                        :class="[
                            activeSection === item.href.replace('#', '')
                                ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white font-semibold'
                                : 'text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800/60'
                        ]"
                    >
                        {{ item.name }}
                    </a>

                    <div class="pt-3 border-t border-zinc-200 dark:border-zinc-800 flex flex-col gap-2">
                        <Link 
                            v-if="auth?.user" 
                            :href="route('dashboard')"
                            class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200"
                        >
                            <LayoutDashboard class="w-4 h-4 text-indigo-500" />
                            Admin Dashboard
                        </Link>
                        <a 
                            href="#contact" 
                            @click="isMobileMenuOpen = false"
                            class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-semibold bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 shadow-sm"
                        >
                            Hire Me
                            <ArrowUpRight class="w-4 h-4" />
                        </a>
                    </div>
                </div>
            </transition>
        </div>
    </header>
</template>
