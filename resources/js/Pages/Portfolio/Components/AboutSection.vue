<script setup>
import { 
    User, 
    MapPin, 
    Mail, 
    GraduationCap, 
    Award, 
    ShieldCheck, 
    Zap, 
    Cpu
} from 'lucide-vue-next';

const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

const defaultStats = [
    { label: 'Years Experience', value: '2+', icon: Zap, iconBg: 'bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200' },
    { label: 'Completed Projects', value: '15+', icon: Award, iconBg: 'bg-zinc-100 dark:bg-zinc-800 text-indigo-600 dark:text-indigo-400' },
    { label: 'Tech Stacks', value: '12+', icon: Cpu, iconBg: 'bg-zinc-100 dark:bg-zinc-800 text-blue-600 dark:text-blue-400' },
    { label: 'Code Quality', value: '100%', icon: ShieldCheck, iconBg: 'bg-zinc-100 dark:bg-zinc-800 text-emerald-600 dark:text-emerald-400' },
];

const highlights = [
    {
        title: 'Modern SPA Architecture',
        desc: 'Specialized in building full-stack Single Page Applications utilizing Laravel and Inertia.js with Vue 3 Composition API.',
    },
    {
        title: 'Performant Relational Databases',
        desc: 'Proficient in designing normalized schema architectures, query optimization, indexing, and transactional data integrity.',
    },
    {
        title: 'Clean, Maintainable Code',
        desc: 'Following SOLID principles, repository/service patterns, modular component design, and automated testing conventions.',
    },
];
</script>

<template>
    <section id="about" class="py-24 relative bg-zinc-50 dark:bg-zinc-900/50 border-y border-zinc-200 dark:border-zinc-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-zinc-200 text-xs font-mono font-semibold uppercase tracking-wider">
                    <User class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" />
                    <span>About Me</span>
                </div>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold text-zinc-900 dark:text-white tracking-tight">
                    Bridging Clean Backend Architecture with Intuitive Frontend Design
                </h2>
                <p class="font-sans text-base sm:text-lg text-zinc-600 dark:text-zinc-400 leading-relaxed">
                    Passionate developer dedicated to engineering reliable digital solutions and seamless user experiences.
                </p>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                
                <!-- Left: Biography and Philosophy -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="p-8 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm space-y-6">
                        <h3 class="font-heading text-xl sm:text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                            <span>Engineering Web Solutions That Deliver Real Value</span>
                        </h3>

                        <p class="font-sans text-zinc-600 dark:text-zinc-300 leading-relaxed">
                            {{ profile.about_bio_1 || "I'm Ikbal, a dedicated Full Stack Developer based in Indonesia. I specialize in engineering clean, performant, and maintainable web applications that bridge intuitive design with rock-solid server architecture." }}
                        </p>

                        <p class="font-sans text-zinc-600 dark:text-zinc-300 leading-relaxed">
                            {{ profile.about_bio_2 || "With a strong foundation in modern PHP (Laravel), Vue 3 Composition API, Inertia.js, and relational database design, I enjoy tackling complex challenges from database optimization to smooth micro-interactions." }}
                        </p>

                        <!-- Key Information Pills -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                            <div class="flex items-center gap-3 text-sm text-zinc-700 dark:text-zinc-300">
                                <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 flex items-center justify-center shrink-0">
                                    <MapPin class="w-4 h-4 text-indigo-500" />
                                </div>
                                <div>
                                    <span class="text-[11px] text-zinc-400 block font-mono">Location</span>
                                    <span class="font-semibold font-sans">{{ profile.location || 'Indonesia' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-sm text-zinc-700 dark:text-zinc-300">
                                <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 flex items-center justify-center shrink-0">
                                    <GraduationCap class="w-4 h-4 text-indigo-500" />
                                </div>
                                <div>
                                    <span class="text-[11px] text-zinc-400 block font-mono">Education</span>
                                    <span class="font-semibold font-sans">Informatics Engineering</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-sm text-zinc-700 dark:text-zinc-300">
                                <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 flex items-center justify-center shrink-0">
                                    <Mail class="w-4 h-4 text-indigo-500" />
                                </div>
                                <div>
                                    <span class="text-[11px] text-zinc-400 block font-mono">Direct Email</span>
                                    <span class="font-semibold font-sans">{{ profile.email || 'ikbal@email.com' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-sm text-zinc-700 dark:text-zinc-300">
                                <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 flex items-center justify-center shrink-0">
                                    <ShieldCheck class="w-4 h-4 text-emerald-500" />
                                </div>
                                <div>
                                    <span class="text-[11px] text-zinc-400 block font-mono">Work Status</span>
                                    <span class="font-semibold text-emerald-600 dark:text-emerald-400 font-sans">Available</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Highlights Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div 
                            v-for="(h, idx) in highlights" 
                            :key="idx" 
                            class="p-5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm"
                        >
                            <h4 class="font-heading font-bold text-zinc-900 dark:text-white text-sm mb-1.5">{{ h.title }}</h4>
                            <p class="font-sans text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed">{{ h.desc }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Stats & Visual Graphic -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div 
                            v-for="(stat, idx) in defaultStats" 
                            :key="idx"
                            class="p-6 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm"
                        >
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3" :class="stat.iconBg">
                                <component :is="stat.icon" class="w-5 h-5" />
                            </div>
                            <p class="font-heading text-3xl sm:text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight">
                                {{ stat.value }}
                            </p>
                            <p class="font-mono text-xs font-medium text-zinc-400 mt-1 uppercase tracking-wider">
                                {{ stat.label }}
                            </p>
                        </div>
                    </div>

                    <!-- Tech Stack Showcase Graphic -->
                    <div class="rounded-2xl bg-zinc-900 border border-zinc-800 p-6 shadow-sm space-y-4 text-white">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono uppercase tracking-wider text-zinc-400">Tech Stack Overview</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-zinc-800 text-zinc-300 border border-zinc-700">Modern Architecture</span>
                        </div>
                        <img 
                            src="/images/tech-stack.png" 
                            alt="Ikbal Tech Stack Ecosystem" 
                            class="w-full h-auto rounded-xl border border-zinc-800 object-contain max-h-48"
                            onerror="this.style.display='none'"
                        />
                        <p class="font-sans text-xs text-zinc-400">
                            Integrated frameworks and database technologies used for enterprise-grade web applications.
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </section>
</template>
