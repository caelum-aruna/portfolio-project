<script setup>
import { 
    Download, 
    ArrowUpRight, 
    Github, 
    Linkedin, 
    Instagram, 
    Twitter, 
    Mail, 
    MapPin, 
    Phone, 
    Sparkles, 
    FolderGit2, 
    Terminal, 
    Cpu,
    ExternalLink,
    Copy,
    Check
} from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
    viewMode: {
        type: String,
        default: 'preview',
    },
});

const emit = defineEmits(['open-file', 'download-cv']);

const codeCopied = ref(false);

const getSocialUrl = (platform) => {
    return props.profile.socials?.[platform] || '#';
};

const vueCodeString = `<template>
  <div class="developer-profile">
    <header class="hero-identity">
      <h1 class="font-heading text-4xl text-white">{{ profile.name }}</h1>
      <p class="role-title text-indigo-400">{{ profile.role }}</p>
      <span class="status-badge bg-emerald-500 text-zinc-950 font-bold">
        {{ profile.availability }}
      </span>
    </header>

    <section class="bio-narrative">
      <p>{{ profile.about_bio_1 }}</p>
      <p>{{ profile.about_bio_2 }}</p>
    </section>

    <!-- Key Metrics Grid -->
    <div class="stats-matrix grid grid-cols-2 md:grid-cols-4 gap-4">
      <MetricCard 
        v-for="stat in profile.stats" 
        :key="stat.label" 
        :value="stat.value" 
        :label="stat.label" 
      />
    </div>

    <!-- Quick Actions -->
    <div class="action-dock flex gap-3">
      <button @click="downloadResume" class="btn-primary">Download CV</button>
      <button @click="navigateTo('Contact.sh')" class="btn-outline">Contact Terminal</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const stack = ['Laravel 11', 'Vue 3', 'Inertia.js', 'Tailwind CSS', 'MySQL'];
const readyToDeploy = true;
<\/script>`;

const copyCode = () => {
    navigator.clipboard.writeText(vueCodeString);
    codeCopied.value = true;
    setTimeout(() => {
        codeCopied.value = false;
    }, 2000);
};
</script>

<template>
    <div class="flex-1 h-full overflow-y-auto bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 flex">
        
        <!-- ================= MODE 1: VISUAL PREVIEW ================= -->
        <div v-if="viewMode === 'preview'" class="w-full p-4 sm:p-8 max-w-5xl mx-auto space-y-8 font-sans">
            
            <!-- Hero Top Header -->
            <div class="border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 rounded-xl p-6 sm:p-8 relative overflow-hidden">
                <!-- Status Badge -->
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-200 dark:border-emerald-700/60 text-emerald-700 dark:text-emerald-400 text-xs font-mono font-medium mb-4">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
                    <span>{{ profile.availability || 'Available for Freelance & Full-time' }}</span>
                </div>

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="space-y-3">
                        <div class="text-xs uppercase tracking-widest text-zinc-500 dark:text-zinc-400 font-mono">
                            {{ profile.greeting || 'Hello, I am' }}
                        </div>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold font-heading text-zinc-900 dark:text-white tracking-tight">
                            {{ profile.name || 'Ikbal Muhammad' }}
                        </h1>
                        <p class="text-lg sm:text-xl text-indigo-600 dark:text-indigo-400 font-medium font-sans">
                            {{ profile.role || 'Full Stack Developer' }}
                        </p>
                        <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-300 max-w-2xl leading-relaxed">
                            {{ profile.description || profile.tagline }}
                        </p>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap lg:flex-col gap-3 shrink-0">
                        <button
                            @click="emit('download-cv')"
                            class="inline-flex items-center justify-center space-x-2 px-5 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-sm"
                        >
                            <Download class="w-4 h-4" />
                            <span>Download CV</span>
                        </button>

                        <button
                            @click="emit('open-file', 'Contact.sh')"
                            class="inline-flex items-center justify-center space-x-2 px-5 py-3 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 border border-zinc-300 dark:border-zinc-700 text-zinc-800 dark:text-white font-semibold text-sm transition-all"
                        >
                            <Terminal class="w-4 h-4 text-sky-500 dark:text-sky-400" />
                            <span>Contact Terminal</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Profile Details & Avatar Card -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left: Avatar & Meta Card -->
                <div class="lg:col-span-5 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 flex flex-col justify-between space-y-6">
                    <div>
                        <!-- Avatar Container -->
                        <div class="w-full aspect-square max-w-[280px] mx-auto rounded-xl overflow-hidden border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-950 shadow-md relative group">
                            <img 
                                v-if="profile.hero_image" 
                                :src="profile.hero_image" 
                                :alt="profile.name || 'Ikbal'" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 font-heading text-4xl font-bold">
                                IM
                            </div>
                        </div>

                        <!-- Contact Meta List -->
                        <div class="mt-6 space-y-2.5 text-xs font-mono text-zinc-600 dark:text-zinc-300 border-t border-zinc-200 dark:border-zinc-800 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-zinc-500 flex items-center space-x-1.5">
                                    <Mail class="w-3.5 h-3.5 text-zinc-400" />
                                    <span>EMAIL:</span>
                                </span>
                                <a :href="`mailto:${profile.email}`" class="text-indigo-600 dark:text-indigo-400 hover:underline truncate max-w-[170px]">
                                    {{ profile.email || 'ikbal@email.com' }}
                                </a>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-zinc-500 flex items-center space-x-1.5">
                                    <MapPin class="w-3.5 h-3.5 text-zinc-400" />
                                    <span>LOCATION:</span>
                                </span>
                                <span class="text-zinc-800 dark:text-zinc-200">{{ profile.location || 'Indonesia' }}</span>
                            </div>

                            <div v-if="profile.phone" class="flex items-center justify-between">
                                <span class="text-zinc-500 flex items-center space-x-1.5">
                                    <Phone class="w-3.5 h-3.5 text-zinc-400" />
                                    <span>PHONE:</span>
                                </span>
                                <span class="text-zinc-800 dark:text-zinc-200">{{ profile.phone }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Social Icons Row -->
                    <div class="flex items-center justify-center space-x-2 border-t border-zinc-200 dark:border-zinc-800 pt-4">
                        <a 
                            :href="getSocialUrl('github')" 
                            target="_blank" 
                            title="GitHub"
                            class="p-2.5 rounded-lg bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white border border-zinc-200 dark:border-zinc-700 transition-colors"
                        >
                            <Github class="w-4 h-4" />
                        </a>
                        <a 
                            :href="getSocialUrl('linkedin')" 
                            target="_blank" 
                            title="LinkedIn"
                            class="p-2.5 rounded-lg bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:text-blue-500 dark:hover:text-blue-400 border border-zinc-200 dark:border-zinc-700 transition-colors"
                        >
                            <Linkedin class="w-4 h-4" />
                        </a>
                        <a 
                            :href="getSocialUrl('instagram')" 
                            target="_blank" 
                            title="Instagram"
                            class="p-2.5 rounded-lg bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:text-pink-500 dark:hover:text-pink-400 border border-zinc-200 dark:border-zinc-700 transition-colors"
                        >
                            <Instagram class="w-4 h-4" />
                        </a>
                        <a 
                            :href="getSocialUrl('twitter')" 
                            target="_blank" 
                            title="X (Twitter)"
                            class="p-2.5 rounded-lg bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white border border-zinc-200 dark:border-zinc-700 transition-colors"
                        >
                            <Twitter class="w-4 h-4" />
                        </a>
                    </div>
                </div>

                <!-- Right: Bio Story & Stats Grid -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- About Narrative -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 space-y-4">
                        <div class="flex items-center space-x-2 text-xs font-mono text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                            <Sparkles class="w-3.5 h-3.5" />
                            <span>Developer Biography</span>
                        </div>
                        <h2 class="text-xl font-bold font-heading text-zinc-900 dark:text-white">
                            Architecting High-Performance Web Applications
                        </h2>
                        <div class="text-sm text-zinc-600 dark:text-zinc-300 space-y-3 leading-relaxed">
                            <p>{{ profile.about_bio_1 || profile.description }}</p>
                            <p v-if="profile.about_bio_2">{{ profile.about_bio_2 }}</p>
                        </div>
                    </div>

                    <!-- Key Metrics Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div 
                            v-for="stat in (profile.stats || [
                                { label: 'Years Exp', value: '2+' },
                                { label: 'Projects', value: '15+' },
                                { label: 'Tech Stack', value: '12+' },
                                { label: 'Satisfaction', value: '100%' }
                            ])" 
                            :key="stat.label"
                            class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 text-center hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors"
                        >
                            <div class="text-2xl sm:text-3xl font-extrabold font-heading text-zinc-900 dark:text-white tracking-tight">
                                {{ stat.value }}
                            </div>
                            <div class="text-[11px] font-mono text-zinc-500 dark:text-zinc-400 mt-1 uppercase tracking-wider">
                                {{ stat.label }}
                            </div>
                        </div>
                    </div>

                    <!-- Quick Navigation Dock -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <button
                            @click="emit('open-file', 'Projects.vue')"
                            class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-indigo-500 text-left transition-all group"
                        >
                            <div class="flex items-center justify-between text-indigo-600 dark:text-indigo-400 mb-2">
                                <FolderGit2 class="w-5 h-5" />
                                <ArrowUpRight class="w-4 h-4 opacity-50 group-hover:opacity-100 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-all" />
                            </div>
                            <div class="font-heading font-bold text-zinc-900 dark:text-white text-sm">Projects.vue</div>
                            <div class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5">Explore featured portfolio work</div>
                        </button>

                        <button
                            @click="emit('open-file', 'TechArsenal.json')"
                            class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-amber-500 text-left transition-all group"
                        >
                            <div class="flex items-center justify-between text-amber-500 dark:text-amber-400 mb-2">
                                <Cpu class="w-5 h-5" />
                                <ArrowUpRight class="w-4 h-4 opacity-50 group-hover:opacity-100 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-all" />
                            </div>
                            <div class="font-heading font-bold text-zinc-900 dark:text-white text-sm">TechArsenal.json</div>
                            <div class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5">Review master skills matrix</div>
                        </button>

                        <button
                            @click="emit('open-file', 'Contact.sh')"
                            class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-sky-500 text-left transition-all group"
                        >
                            <div class="flex items-center justify-between text-sky-500 dark:text-sky-400 mb-2">
                                <Terminal class="w-5 h-5" />
                                <ArrowUpRight class="w-4 h-4 opacity-50 group-hover:opacity-100 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-all" />
                            </div>
                            <div class="font-heading font-bold text-zinc-900 dark:text-white text-sm">Contact.sh</div>
                            <div class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5">Send a project inquiry message</div>
                        </button>
                    </div>

                </div>
            </div>

        </div>

        <!-- ================= MODE 2: SOURCE CODE VIEW ================= -->
        <div v-else class="w-full flex font-mono text-xs overflow-x-auto bg-white dark:bg-zinc-950">
            <!-- Line Numbers Gutter -->
            <div class="w-12 py-4 select-none text-right pr-4 text-zinc-400 dark:text-zinc-600 bg-zinc-50 dark:bg-zinc-950 border-r border-zinc-200 dark:border-zinc-800 shrink-0 space-y-1">
                <div v-for="n in 36" :key="n">{{ n }}</div>
            </div>

            <!-- Code Content -->
            <div class="flex-1 p-4 relative text-zinc-800 dark:text-zinc-300">
                <button
                    @click="copyCode"
                    class="absolute top-4 right-4 flex items-center space-x-1 px-2.5 py-1 rounded bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-xs border border-zinc-300 dark:border-zinc-700"
                >
                    <Check v-if="codeCopied" class="w-3.5 h-3.5 text-emerald-500 dark:text-emerald-400" />
                    <Copy v-else class="w-3.5 h-3.5" />
                    <span>{{ codeCopied ? 'Copied' : 'Copy Vue SFC' }}</span>
                </button>

                <pre class="leading-relaxed whitespace-pre font-mono"><code>{{ vueCodeString }}</code></pre>
            </div>
        </div>
    </div>
</template>
