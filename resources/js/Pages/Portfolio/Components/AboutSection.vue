<script setup>
import { 
    User, 
    MapPin, 
    Mail, 
    GraduationCap, 
    Award, 
    ShieldCheck, 
    Zap, 
    Cpu, 
    ArrowRight,
    Download
} from 'lucide-vue-next';

const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

const defaultStats = [
    { label: 'Years Experience', value: '2+', icon: Zap, color: 'text-amber-500 bg-amber-500/10' },
    { label: 'Completed Projects', value: '15+', icon: Award, color: 'text-indigo-500 bg-indigo-500/10' },
    { label: 'Tech Stacks', value: '12+', icon: Cpu, color: 'text-cyan-500 bg-cyan-500/10' },
    { label: 'Code Quality', value: '100%', icon: ShieldCheck, color: 'text-emerald-500 bg-emerald-500/10' },
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
    <section id="about" class="py-24 relative overflow-hidden bg-slate-100/50 dark:bg-slate-900/40 border-y border-slate-200/80 dark:border-slate-800/80">
        <!-- Background Accents -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-xs font-mono font-semibold uppercase tracking-wider">
                    <User class="w-3.5 h-3.5" />
                    <span>About Me</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Bridging Clean Backend Architecture with Intuitive Frontend Design
                </h2>
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                    Passionate developer dedicated to engineering reliable digital solutions and seamless user experiences.
                </p>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Left: Biography and Philosophy -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="p-8 rounded-3xl bg-white dark:bg-[#0B0F17] border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                            <span>Engineering Web Solutions That Deliver Real Value</span>
                        </h3>

                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                            {{ profile.about_bio_1 || "I'm Ikbal, a dedicated Full Stack Developer based in Indonesia. I specialize in engineering clean, performant, and maintainable web applications that bridge intuitive design with rock-solid server architecture." }}
                        </p>

                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                            {{ profile.about_bio_2 || "With a strong foundation in modern PHP (Laravel), Vue 3 Composition API, Inertia.js, and relational database design, I enjoy tackling complex challenges from database optimization to smooth micro-interactions." }}
                        </p>

                        <!-- Key Information Pills -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 border-t border-slate-200 dark:border-slate-800/80">
                            <div class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-slate-800 text-indigo-500 flex items-center justify-center shrink-0">
                                    <MapPin class="w-4 h-4" />
                                </div>
                                <div>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 block font-mono">Location</span>
                                    <span class="font-semibold">{{ profile.location || 'Indonesia' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-slate-800 text-indigo-500 flex items-center justify-center shrink-0">
                                    <GraduationCap class="w-4 h-4" />
                                </div>
                                <div>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 block font-mono">Education</span>
                                    <span class="font-semibold">Informatics Engineering</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-slate-800 text-indigo-500 flex items-center justify-center shrink-0">
                                    <Mail class="w-4 h-4" />
                                </div>
                                <div>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 block font-mono">Direct Email</span>
                                    <span class="font-semibold">{{ profile.email || 'ikbal@email.com' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-500 flex items-center justify-center shrink-0">
                                    <ShieldCheck class="w-4 h-4" />
                                </div>
                                <div>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 block font-mono">Work Status</span>
                                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">Available</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Highlights Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div 
                            v-for="(h, idx) in highlights" 
                            :key="idx" 
                            class="p-5 rounded-2xl bg-white dark:bg-[#0B0F17] border border-slate-200 dark:border-slate-800/80 shadow-md hover:border-indigo-500/40 transition-colors"
                        >
                            <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-1.5">{{ h.title }}</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ h.desc }}</p>
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
                            class="p-6 rounded-3xl bg-white dark:bg-[#0B0F17] border border-slate-200 dark:border-slate-800 shadow-xl group hover:border-indigo-500/50 hover:shadow-indigo-500/10 transition-all duration-300"
                        >
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4 transition-transform group-hover:scale-110 duration-300" :class="stat.color">
                                <component :is="stat.icon" class="w-6 h-6" />
                            </div>
                            <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight group-hover:text-indigo-500 transition-colors">
                                {{ stat.value }}
                            </p>
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-wider font-mono">
                                {{ stat.label }}
                            </p>
                        </div>
                    </div>

                    <!-- Tech Stack Showcase Graphic -->
                    <div class="relative rounded-3xl overflow-hidden bg-slate-900 border border-slate-800 p-6 shadow-2xl group">
                        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-900/40 via-purple-900/20 to-cyan-900/30"></div>
                        <div class="relative z-10 space-y-4 text-white">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-mono uppercase tracking-wider text-indigo-400">Tech Stack Overview</span>
                                <span class="px-2 py-0.5 rounded text-[10px] bg-indigo-500/20 border border-indigo-500/30 text-indigo-300">Modern Stack</span>
                            </div>
                            <img 
                                src="/images/tech-stack.png" 
                                alt="Ikbal Tech Stack Ecosystem" 
                                class="w-full h-auto rounded-xl border border-white/10 group-hover:scale-[1.02] transition-transform duration-500 object-contain max-h-48"
                                onerror="this.style.display='none'"
                            />
                            <p class="text-xs text-slate-300">
                                Integrated tooling and frameworks for crafting scalable full-stack applications.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</template>
