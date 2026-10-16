<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { 
    LayoutDashboard, 
    FolderGit2, 
    Wrench, 
    Milestone, 
    Mail, 
    Settings, 
    ExternalLink, 
    CheckCircle2, 
    Terminal,
    User
} from 'lucide-vue-next';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen bg-slate-100 dark:bg-[#0B0F17] text-slate-900 dark:text-slate-100 transition-colors">
        
        <!-- Navigation Bar -->
        <nav class="border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-[#0E131F] sticky top-0 z-40 shadow-sm backdrop-blur-md">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    
                    <div class="flex items-center gap-6">
                        <!-- Brand -->
                        <Link :href="route('dashboard')" class="flex items-center gap-2.5 font-bold tracking-tight">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-cyan-500 p-[1px]">
                                <div class="w-full h-full bg-slate-900 rounded-[11px] flex items-center justify-center text-white">
                                    <Terminal class="w-4 h-4 text-indigo-400" />
                                </div>
                            </div>
                            <span class="font-extrabold text-slate-900 dark:text-white text-base">
                                Admin<span class="text-indigo-500">Panel</span>
                            </span>
                        </Link>

                        <!-- Desktop Navigation Links -->
                        <div class="hidden space-x-1 sm:flex items-center">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </NavLink>
                            <NavLink :href="route('admin.projects.index')" :active="route().current('admin.projects.*')">
                                Projects
                            </NavLink>
                            <NavLink :href="route('admin.skills.index')" :active="route().current('admin.skills.*')">
                                Skills
                            </NavLink>
                            <NavLink :href="route('admin.experiences.index')" :active="route().current('admin.experiences.*')">
                                Experience
                            </NavLink>
                            <NavLink :href="route('admin.messages.index')" :active="route().current('admin.messages.*')">
                                Messages
                            </NavLink>
                            <NavLink :href="route('admin.settings.edit')" :active="route().current('admin.settings.*')">
                                Portfolio Settings
                            </NavLink>
                        </div>
                    </div>

                    <!-- Right Controls -->
                    <div class="hidden sm:flex sm:items-center sm:gap-3">
                        
                        <!-- View Public Website -->
                        <a 
                            :href="route('portfolio')" 
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/60 hover:bg-indigo-100 dark:hover:bg-indigo-900/60 transition-colors"
                        >
                            <span>Live Site</span>
                            <ExternalLink class="w-3.5 h-3.5" />
                        </a>

                        <!-- User Profile Dropdown -->
                        <div class="relative ms-2">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-xl">
                                        <button
                                            type="button"
                                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-white transition-colors"
                                        >
                                            <div class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs">
                                                {{ $page.props.auth.user.name.charAt(0) }}
                                            </div>
                                            <span>{{ $page.props.auth.user.name }}</span>
                                            <svg class="h-4 w-4 fill-current text-slate-400" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">
                                        Account Security
                                    </DropdownLink>
                                    <DropdownLink :href="route('admin.settings.edit')">
                                        Profile Bio & Contacts
                                    </DropdownLink>
                                    <div class="border-t border-slate-100 dark:border-slate-700"></div>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger Button -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="p-2 rounded-xl text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800"
                        >
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

            <!-- Mobile Navigation -->
            <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden border-t border-slate-200 dark:border-slate-800 p-4 space-y-2 bg-white dark:bg-[#0E131F]">
                <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Dashboard
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('admin.projects.index')" :active="route().current('admin.projects.*')">
                    Projects
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('admin.skills.index')" :active="route().current('admin.skills.*')">
                    Skills
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('admin.experiences.index')" :active="route().current('admin.experiences.*')">
                    Experience
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('admin.messages.index')" :active="route().current('admin.messages.*')">
                    Messages
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('admin.settings.edit')" :active="route().current('admin.settings.*')">
                    Portfolio Settings
                </ResponsiveNavLink>

                <div class="pt-4 border-t border-slate-200 dark:border-slate-800 space-y-2">
                    <a :href="route('portfolio')" target="_blank" class="block w-full py-2 text-center text-sm font-semibold rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-500">
                        View Public Website
                    </a>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        <div v-if="$page.props.flash?.success" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 flex items-center gap-3">
                <CheckCircle2 class="w-5 h-5 text-emerald-500 shrink-0" />
                <span class="text-sm font-medium">{{ $page.props.flash.success }}</span>
            </div>
        </div>

        <!-- Page Heading Slot -->
        <header v-if="$slots.header" class="border-b border-slate-200 dark:border-slate-800/60 bg-white/60 dark:bg-[#0E131F]/60 backdrop-blur-md">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex items-center justify-between">
                <slot name="header" />
            </div>
        </header>

        <!-- Main Content -->
        <main class="py-8">
            <slot />
        </main>

    </div>
</template>
