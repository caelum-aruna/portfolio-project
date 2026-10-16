<script setup>
import { ref } from 'vue';
import { 
    ArrowRight, 
    Download, 
    Sparkles, 
    Check, 
    Copy, 
    Code2, 
    Layers, 
    Briefcase,
    ExternalLink
} from 'lucide-vue-next';

const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

const isCopied = ref(false);

const copyEmail = () => {
    if (props.profile.email) {
        navigator.clipboard.writeText(props.profile.email);
        isCopied.value = true;
        setTimeout(() => {
            isCopied.value = false;
        }, 2500);
    }
};
</script>

<template>
    <section id="hero" class="relative pt-32 pb-20 md:pt-44 md:pb-32 overflow-hidden">
        <!-- Ambient Background Glow Gradients -->
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[600px] h-[350px] md:w-[900px] md:h-[450px] bg-gradient-to-tr from-indigo-600/20 via-cyan-500/15 to-purple-600/10 rounded-full blur-[120px] pointer-events-none -z-10"></div>
        <div class="absolute top-1/2 right-0 w-[400px] h-[400px] bg-cyan-500/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>
        <div class="absolute top-3/4 left-0 w-[400px] h-[400px] bg-purple-500/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Left Column: Intro & Headline -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    
                    <!-- Availability Pill Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs sm:text-sm font-semibold tracking-wide backdrop-blur-md shadow-sm">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span>{{ profile.availability || 'Available for Freelance & Full-time' }}</span>
                    </div>

                    <!-- Main Headline -->
                    <div class="space-y-2">
                        <p class="text-sm sm:text-base font-mono uppercase tracking-widest text-indigo-600 dark:text-indigo-400 font-semibold">
                            {{ profile.greeting || 'Hello, I am' }}
                        </p>
                        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.1]">
                            <span>{{ profile.name?.split(' ')[0] || 'Ikbal' }}</span>
                            <span class="block bg-gradient-to-r from-indigo-600 via-purple-600 to-cyan-500 bg-clip-text text-transparent">
                                {{ profile.name?.split(' ').slice(1).join(' ') || 'Muhammad' }}
                            </span>
                        </h1>
                    </div>

                    <!-- Role Tagline -->
                    <div class="inline-block px-3.5 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-950/50 border border-indigo-200 dark:border-indigo-800 text-indigo-700 dark:text-indigo-300 font-mono text-sm sm:text-base font-semibold">
                        &lt;{{ profile.role || 'Full Stack Developer' }} /&gt;
                    </div>

                    <!-- Bio Description -->
                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                        {{ profile.description || 'I build modern, responsive, and scalable web applications with the Laravel & Vue.js ecosystem, turning complex concepts into high-impact digital experiences.' }}
                    </p>

                    <!-- Action Buttons -->
                    <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-4">
                        <a 
                            href="#projects" 
                            class="group relative inline-flex items-center gap-2.5 px-6 py-3.5 rounded-xl text-base font-semibold text-white shadow-xl shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] overflow-hidden"
                        >
                            <span class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-indigo-500 to-cyan-500"></span>
                            <span class="relative flex items-center gap-2">
                                View Projects
                                <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                            </span>
                        </a>

                        <a 
                            href="#contact" 
                            class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl text-base font-semibold text-slate-700 dark:text-slate-200 bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 hover:border-indigo-500/50 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-sm transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]"
                        >
                            Contact Me
                        </a>

                        <a 
                            :href="profile.resume_url || '#'" 
                            download
                            class="inline-flex items-center gap-2 px-4 py-3.5 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 transition-colors"
                        >
                            <Download class="w-4 h-4" />
                            <span>Download CV</span>
                        </a>
                    </div>

                    <!-- Email Quick-Copy & Social Media -->
                    <div class="pt-6 border-t border-slate-200/80 dark:border-slate-800/80 flex flex-wrap items-center justify-center lg:justify-start gap-6">
                        <!-- Quick Copy Email -->
                        <button 
                            @click="copyEmail" 
                            type="button"
                            class="group flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 text-xs font-mono text-slate-600 dark:text-slate-400 hover:border-indigo-500/40 transition-colors"
                            :title="isCopied ? 'Copied!' : 'Click to copy email'"
                        >
                            <Check v-if="isCopied" class="w-3.5 h-3.5 text-emerald-500" />
                            <Copy v-else class="w-3.5 h-3.5 text-slate-400 group-hover:text-indigo-400 transition-colors" />
                            <span>{{ isCopied ? 'Copied to clipboard!' : (profile.email || 'ikbal@email.com') }}</span>
                        </button>

                        <!-- Social Icon Badges -->
                        <div class="flex items-center gap-3">
                            <a 
                                v-if="profile.socials?.github" 
                                :href="profile.socials.github" 
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="GitHub Profile"
                                class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-800 bg-white/60 dark:bg-slate-900/60 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-indigo-500 hover:border-indigo-500/50 hover:scale-110 transition-all duration-200"
                            >
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                            </a>
                            <a 
                                v-if="profile.socials?.linkedin" 
                                :href="profile.socials.linkedin" 
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="LinkedIn Profile"
                                class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-800 bg-white/60 dark:bg-slate-900/60 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-indigo-500 hover:border-indigo-500/50 hover:scale-110 transition-all duration-200"
                            >
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            <a 
                                v-if="profile.socials?.instagram" 
                                :href="profile.socials.instagram" 
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Instagram Profile"
                                class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-800 bg-white/60 dark:bg-slate-900/60 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-pink-500 hover:border-pink-500/50 hover:scale-110 transition-all duration-200"
                            >
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Profile Visual & Floating Cards -->
                <div class="lg:col-span-5 relative flex items-center justify-center">
                    
                    <!-- Glow Behind Avatar Card -->
                    <div class="absolute inset-0 rounded-3xl bg-gradient-to-tr from-indigo-500/20 via-purple-500/20 to-cyan-400/20 blur-2xl -z-10"></div>
                    
                    <!-- Main Avatar Card -->
                    <div class="relative w-full max-w-[360px] sm:max-w-[400px] p-2 sm:p-3 rounded-3xl bg-gradient-to-b from-white/90 via-slate-100/80 to-white/50 dark:from-slate-800/80 dark:via-slate-900/80 dark:to-[#0B0F17]/90 border border-slate-200/90 dark:border-slate-800/90 shadow-2xl backdrop-blur-xl group">
                        
                        <!-- Image Container -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[4/5] bg-slate-900/10 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/50">
                            <img 
                                :src="profile.hero_image || '/images/hero-image.png'" 
                                :alt="profile.name || 'Ikbal Muhammad'"
                                class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out"
                                onerror="this.src='/images/hero-image.png'"
                            />
                            
                            <!-- Bottom Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

                            <!-- Bottom Tag inside Image -->
                            <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-white text-xs">
                                <div class="flex items-center gap-2 bg-slate-900/70 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10">
                                    <Sparkles class="w-3.5 h-3.5 text-amber-400" />
                                    <span class="font-medium">Laravel & Vue 3 Enthusiast</span>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Badge 1: Tech Stack Badge (Top Right) -->
                        <div class="absolute -top-5 -right-3 sm:-right-6 px-3.5 py-2 rounded-2xl bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-700 shadow-xl backdrop-blur-xl flex items-center gap-2.5 animate-bounce [animation-duration:4s]">
                            <div class="w-8 h-8 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center font-mono font-bold text-xs">
                                <Code2 class="w-4 h-4" />
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-mono tracking-wider text-slate-500 dark:text-slate-400">Stack</p>
                                <p class="text-xs font-bold text-slate-900 dark:text-white">Laravel + Inertia</p>
                            </div>
                        </div>

                        <!-- Floating Badge 2: Experience / Projects (Bottom Left) -->
                        <div class="absolute -bottom-6 -left-3 sm:-left-6 px-4 py-2.5 rounded-2xl bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-700 shadow-xl backdrop-blur-xl flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center">
                                <Briefcase class="w-4 h-4" />
                            </div>
                            <div>
                                <p class="text-xs font-extrabold text-slate-900 dark:text-white">15+ Completed</p>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400">Web Projects & APIs</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</template>
