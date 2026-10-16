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
    LogIn,
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
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        :class="[
            isScrolled 
                ? 'py-3 bg-white/70 dark:bg-[#0B0F17]/80 backdrop-blur-xl border-b border-slate-200/80 dark:border-slate-800/80 shadow-lg shadow-black/5 dark:shadow-black/20' 
                : 'py-5 bg-transparent'
        ]"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Brand / Logo -->
                <a href="#hero" class="group flex items-center gap-2.5 font-bold text-xl tracking-tight">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-cyan-400 p-[1px] shadow-lg shadow-indigo-500/20 group-hover:shadow-indigo-500/40 transition-all duration-300 group-hover:scale-105">
                        <div class="w-full h-full bg-slate-900 rounded-[11px] flex items-center justify-center text-white">
                            <Terminal class="w-5 h-5 text-indigo-400 group-hover:rotate-12 transition-transform duration-300" />
                        </div>
                    </div>
                    <span class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-800 dark:from-white dark:via-slate-100 dark:to-slate-300 bg-clip-text text-transparent text-xl font-extrabold tracking-tight">
                        Ikbal<span class="text-indigo-500">.dev</span>
                    </span>
                    <span class="flex h-2 w-2 relative -top-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-1 bg-slate-100/80 dark:bg-slate-900/60 p-1.5 rounded-full border border-slate-200/80 dark:border-slate-800 backdrop-blur-md shadow-inner">
                    <a 
                        v-for="item in navLinks" 
                        :key="item.name" 
                        :href="item.href"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200"
                        :class="[
                            activeSection === item.href.replace('#', '')
                                ? 'bg-white dark:bg-indigo-600 text-slate-900 dark:text-white shadow-sm'
                                : 'text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white hover:bg-white/50 dark:hover:bg-slate-800/50'
                        ]"
                    >
                        {{ item.name }}
                    </a>
                </nav>

                <!-- Right Actions: Theme Toggle, Auth, Contact CTA -->
                <div class="flex items-center gap-3">
                    <!-- Theme Toggle Button -->
                    <button 
                        @click="toggleTheme" 
                        type="button"
                        aria-label="Toggle Dark Mode"
                        class="p-2.5 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-100/80 dark:bg-slate-900/80 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-400 dark:hover:border-indigo-500/50 transition-all duration-300 shadow-sm"
                    >
                        <Sun v-if="isDark" class="w-4 h-4 transition-transform rotate-0 hover:rotate-90 duration-300 text-amber-400" />
                        <Moon v-else class="w-4 h-4 transition-transform rotate-0 hover:-rotate-12 duration-300 text-indigo-600" />
                    </button>

                    <!-- Admin Dashboard / Login Link -->
                    <template v-if="canLogin">
                        <Link 
                            v-if="auth?.user" 
                            :href="route('dashboard')"
                            class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-800/90 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors"
                        >
                            <LayoutDashboard class="w-3.5 h-3.5 text-indigo-400" />
                            <span>Dashboard</span>
                        </Link>
                        <Link 
                            v-else 
                            :href="route('login')"
                            class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
                        >
                            <LogIn class="w-3.5 h-3.5" />
                            <span>Admin</span>
                        </Link>
                    </template>

                    <!-- Contact CTA Button -->
                    <a 
                        href="#contact" 
                        class="relative group hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white overflow-hidden shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]"
                    >
                        <span class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-indigo-500 to-cyan-500 group-hover:opacity-90 transition-opacity"></span>
                        <span class="relative flex items-center gap-1.5">
                            Hire Me
                            <ArrowUpRight class="w-4 h-4 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" />
                        </span>
                    </a>

                    <!-- Mobile Menu Hamburger -->
                    <button 
                        @click="isMobileMenuOpen = !isMobileMenuOpen"
                        type="button"
                        class="md:hidden p-2.5 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-100/80 dark:bg-slate-900/80 text-slate-700 dark:text-slate-300"
                        aria-label="Toggle Mobile Menu"
                    >
                        <X v-if="isMobileMenuOpen" class="w-5 h-5" />
                        <Menu v-else class="w-5 h-5" />
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Drawer -->
            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0 -translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-2"
            >
                <div 
                    v-if="isMobileMenuOpen" 
                    class="md:hidden mt-3 p-4 rounded-2xl bg-white/95 dark:bg-[#0B0F17]/95 border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-2xl space-y-2"
                >
                    <a 
                        v-for="item in navLinks" 
                        :key="item.name" 
                        :href="item.href"
                        @click="isMobileMenuOpen = false"
                        class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-colors"
                        :class="[
                            activeSection === item.href.replace('#', '')
                                ? 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold'
                                : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/60'
                        ]"
                    >
                        {{ item.name }}
                    </a>

                    <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-2">
                        <Link 
                            v-if="canLogin && auth?.user" 
                            :href="route('dashboard')"
                            class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-medium bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200"
                        >
                            <LayoutDashboard class="w-4 h-4 text-indigo-500" />
                            Admin Dashboard
                        </Link>
                        <Link 
                            v-else-if="canLogin" 
                            :href="route('login')"
                            class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-medium border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300"
                        >
                            <LogIn class="w-4 h-4" />
                            Admin Login
                        </Link>
                        <a 
                            href="#contact" 
                            @click="isMobileMenuOpen = false"
                            class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-indigo-600 to-cyan-500 text-white shadow-md shadow-indigo-500/20"
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
