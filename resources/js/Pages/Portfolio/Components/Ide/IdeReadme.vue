<script setup>
import { ref } from 'vue';
import { FileText, Copy, Check, Terminal, ExternalLink } from 'lucide-vue-next';

const props = defineProps({
    profile: {
        type: Object,
        default: () => ({}),
    },
    viewMode: {
        type: String,
        default: 'preview',
    },
});

const emit = defineEmits(['open-file', 'download-cv']);

const codeCopied = ref(false);

const markdownRaw = `# Ikbal Muhammad — Full Stack Developer Workspace

> High-performance full-stack web applications engineered with modern PHP, Laravel 11, and Vue 3.

---

## 🚀 Architectural Principles
- **Clean Solid Design**: High-contrast, strictly solid palette designed for maximum legibility and distraction-free usability.
- **Modern Typography**: Distinctive **Fraunces** editorial headings paired with ergonomic **Inter** body text.
- **Unified Full-Stack Flow**: Monolithic speed and SPA responsiveness combined via **Inertia.js v2**.
- **Type-safe & Tested**: Backed by PHPUnit feature test suites and robust MySQL relational models.

---

## 🛠️ Stack & Toolchain
- **Backend**: Laravel 11.x, PHP 8.5+, Eloquent ORM, MySQL 8
- **Frontend**: Vue 3 (Composition API), Inertia.js, Tailwind CSS
- **Bundler & Tooling**: Vite 8, PostCSS, ESLint, Pint
- **Infrastructure**: Linux (CachyOS / Ubuntu), Nginx, Git, Docker

---

## 📂 Workspace Structure
- \`src/Overview.vue\`      — Hero overview, biography, and key performance metrics.
- \`src/projects/Projects.vue\` — Featured client & personal production deployments.
- \`src/TechArsenal.json\`  — Categorized proficiency matrices across Frontend & Backend.
- \`src/Journey.log\`       — Engineering milestones, career path, and academic history.
- \`src/Contact.sh\`        — Direct interactive message gateway.

---

## 📬 Contact & Inquiries
- **Email**: ${props.profile?.email || 'ikbal@email.com'}
- **Location**: ${props.profile?.location || 'Indonesia'}
- **Status**: ${props.profile?.availability || 'Available for Freelance & Full-time Roles'}
`;

const copyCode = () => {
    navigator.clipboard.writeText(markdownRaw);
    codeCopied.value = true;
    setTimeout(() => {
        codeCopied.value = false;
    }, 2000);
};
</script>

<template>
    <div class="flex-1 h-full overflow-y-auto bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 flex">
        
        <!-- ================= MODE 1: VISUAL PREVIEW ================= -->
        <div v-if="viewMode === 'preview'" class="w-full p-4 sm:p-8 max-w-4xl mx-auto space-y-6 font-sans">
            
            <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 sm:p-8 space-y-6">
                <!-- Header -->
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-5">
                    <div class="flex items-center space-x-2 text-xs font-mono text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-2">
                        <FileText class="w-4 h-4" />
                        <span>Project Documentation</span>
                    </div>
                    <h1 class="text-3xl font-extrabold font-heading text-zinc-900 dark:text-white">
                        Ikbal Muhammad — Developer Workspace
                    </h1>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">
                        High-performance full-stack web applications engineered with modern PHP, Laravel 11, and Vue 3.
                    </p>
                </div>

                <!-- Architectural Principles -->
                <div class="space-y-3">
                    <h2 class="text-lg font-bold font-heading text-zinc-900 dark:text-white">
                        Architectural Principles
                    </h2>
                    <ul class="space-y-2 text-sm text-zinc-600 dark:text-zinc-300">
                        <li class="flex items-start space-x-2">
                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">•</span>
                            <span><strong>Clean Solid Palette:</strong> Strictly solid tones without distracting gradients, maximizing readability and professional contrast.</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">•</span>
                            <span><strong>Modern Typography:</strong> Fraunces for structural headings and Inter for comfortable body reading.</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">•</span>
                            <span><strong>Monolith + SPA Power:</strong> Server-driven simplicity with client-side SPA speed powered by Inertia.js.</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">•</span>
                            <span><strong>Production Tested:</strong> Validated with comprehensive PHPUnit feature test suites.</span>
                        </li>
                    </ul>
                </div>

                <!-- Workspace Files -->
                <div class="space-y-3 border-t border-zinc-200 dark:border-zinc-800 pt-5">
                    <h2 class="text-lg font-bold font-heading text-zinc-900 dark:text-white">
                        Workspace File Index
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs font-mono">
                        <button 
                            @click="emit('open-file', 'Overview.vue')"
                            class="p-3 rounded-lg bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-emerald-500 text-left transition-colors flex items-center justify-between"
                        >
                            <span class="text-emerald-600 dark:text-emerald-400 font-semibold">src/Overview.vue</span>
                            <span class="text-zinc-500 font-sans">Profile & Bio</span>
                        </button>
                        <button 
                            @click="emit('open-file', 'Projects.vue')"
                            class="p-3 rounded-lg bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-indigo-500 text-left transition-colors flex items-center justify-between"
                        >
                            <span class="text-indigo-600 dark:text-indigo-400 font-semibold">src/projects/Projects.vue</span>
                            <span class="text-zinc-500 font-sans">Project Showcase</span>
                        </button>
                        <button 
                            @click="emit('open-file', 'TechArsenal.json')"
                            class="p-3 rounded-lg bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-amber-500 text-left transition-colors flex items-center justify-between"
                        >
                            <span class="text-amber-600 dark:text-amber-400 font-semibold">src/TechArsenal.json</span>
                            <span class="text-zinc-500 font-sans">Skills Matrix</span>
                        </button>
                        <button 
                            @click="emit('open-file', 'Journey.log')"
                            class="p-3 rounded-lg bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-purple-500 text-left transition-colors flex items-center justify-between"
                        >
                            <span class="text-purple-600 dark:text-purple-400 font-semibold">src/Journey.log</span>
                            <span class="text-zinc-500 font-sans">Milestone Logs</span>
                        </button>
                    </div>
                </div>

                <!-- Action CTA -->
                <div class="flex items-center space-x-3 border-t border-zinc-200 dark:border-zinc-800 pt-5">
                    <button
                        @click="emit('open-file', 'Contact.sh')"
                        class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs font-mono transition-colors"
                    >
                        Launch Contact Terminal
                    </button>
                    <button
                        @click="emit('download-cv')"
                        class="px-4 py-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-200 font-semibold text-xs font-mono transition-colors border border-zinc-300 dark:border-transparent"
                    >
                        Download Resume PDF
                    </button>
                </div>
            </div>

        </div>

        <!-- ================= MODE 2: SOURCE CODE VIEW ================= -->
        <div v-else class="w-full flex font-mono text-xs overflow-x-auto bg-white dark:bg-zinc-950">
            <!-- Line Numbers Gutter -->
            <div class="w-12 py-4 select-none text-right pr-4 text-zinc-400 dark:text-zinc-600 bg-zinc-50 dark:bg-zinc-950 border-r border-zinc-200 dark:border-zinc-800 shrink-0 space-y-1">
                <div v-for="n in 35" :key="n">{{ n }}</div>
            </div>

            <!-- Code Content -->
            <div class="flex-1 p-4 relative text-zinc-800 dark:text-zinc-300">
                <button
                    @click="copyCode"
                    class="absolute top-4 right-4 flex items-center space-x-1 px-2.5 py-1 rounded bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-xs border border-zinc-300 dark:border-zinc-700"
                >
                    <Check v-if="codeCopied" class="w-3.5 h-3.5 text-emerald-500 dark:text-emerald-400" />
                    <Copy v-else class="w-3.5 h-3.5" />
                    <span>{{ codeCopied ? 'Copied' : 'Copy Markdown' }}</span>
                </button>

                <pre class="leading-relaxed whitespace-pre font-mono text-zinc-800 dark:text-zinc-300"><code>{{ markdownRaw }}</code></pre>
            </div>
        </div>

    </div>
</template>
