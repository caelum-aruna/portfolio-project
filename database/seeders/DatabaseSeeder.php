<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\ProfileSetting;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::firstOrCreate(
            ['email' => 'ikbal@email.com'],
            [
                'name' => 'Ikbal Muhammad',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Profile Settings
        $settings = [
            'name' => 'Ikbal Muhammad',
            'role' => 'Full Stack Developer',
            'tagline' => 'Crafting modern, robust web solutions with Laravel & Vue.js',
            'greeting' => 'Hello, I am',
            'description' => 'I build modern, responsive, and scalable web applications with the Laravel & Vue.js ecosystem, turning complex concepts into high-impact digital experiences.',
            'about_bio_1' => "I'm Ikbal, a dedicated Full Stack Developer based in Indonesia. I specialize in engineering clean, performant, and maintainable web applications that bridge intuitive design with rock-solid server architecture.",
            'about_bio_2' => 'With a strong foundation in modern PHP (Laravel), Vue 3 Composition API, Inertia.js, and relational database design, I enjoy tackling complex challenges from database optimization to smooth micro-interactions.',
            'email' => 'ikbal@email.com',
            'phone' => '+62 812 3456 7890',
            'location' => 'Indonesia',
            'availability' => 'Available for Opportunities',
            'resume_url' => '#',
            'hero_image' => '/images/hero-image.png',
            'tech_image' => '/images/tech-stack.png',
            'socials' => [
                'github' => 'https://github.com',
                'linkedin' => 'https://linkedin.com',
                'instagram' => 'https://instagram.com',
                'twitter' => 'https://x.com',
            ],
            'stats' => [
                ['label' => 'Years of Experience', 'value' => '2+'],
                ['label' => 'Completed Projects', 'value' => '15+'],
                ['label' => 'Tech Stacks Mastered', 'value' => '12+'],
                ['label' => 'Client Satisfaction', 'value' => '100%'],
            ],
        ];

        foreach ($settings as $key => $val) {
            ProfileSetting::setVal($key, $val);
        }

        // 3. Skills
        $skills = [
            // Frontend
            ['name' => 'Vue.js 3', 'category' => 'Frontend', 'icon' => 'vue', 'proficiency' => 95, 'order' => 1],
            ['name' => 'JavaScript (ES6+)', 'category' => 'Frontend', 'icon' => 'javascript', 'proficiency' => 92, 'order' => 2],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'icon' => 'tailwind', 'proficiency' => 94, 'order' => 3],
            ['name' => 'TypeScript', 'category' => 'Frontend', 'icon' => 'typescript', 'proficiency' => 80, 'order' => 4],
            ['name' => 'HTML5 & CSS3', 'category' => 'Frontend', 'icon' => 'html5', 'proficiency' => 96, 'order' => 5],
            ['name' => 'React.js', 'category' => 'Frontend', 'icon' => 'react', 'proficiency' => 78, 'order' => 6],

            // Backend
            ['name' => 'Laravel', 'category' => 'Backend', 'icon' => 'laravel', 'proficiency' => 96, 'order' => 1],
            ['name' => 'PHP 8+', 'category' => 'Backend', 'icon' => 'php', 'proficiency' => 94, 'order' => 2],
            ['name' => 'MySQL / MariaDB', 'category' => 'Backend', 'icon' => 'mysql', 'proficiency' => 90, 'order' => 3],
            ['name' => 'RESTful APIs', 'category' => 'Backend', 'icon' => 'api', 'proficiency' => 92, 'order' => 4],
            ['name' => 'Node.js', 'category' => 'Backend', 'icon' => 'nodejs', 'proficiency' => 80, 'order' => 5],

            // Tools & Architecture
            ['name' => 'Inertia.js', 'category' => 'Tools & DevOps', 'icon' => 'inertia', 'proficiency' => 95, 'order' => 1],
            ['name' => 'Git & GitHub', 'category' => 'Tools & DevOps', 'icon' => 'git', 'proficiency' => 90, 'order' => 2],
            ['name' => 'Docker', 'category' => 'Tools & DevOps', 'icon' => 'docker', 'proficiency' => 78, 'order' => 3],
            ['name' => 'Linux / CLI', 'category' => 'Tools & DevOps', 'icon' => 'linux', 'proficiency' => 85, 'order' => 4],
            ['name' => 'Figma UI/UX', 'category' => 'Tools & DevOps', 'icon' => 'figma', 'proficiency' => 82, 'order' => 5],
        ];

        foreach ($skills as $s) {
            Skill::firstOrCreate(['name' => $s['name']], $s);
        }

        // 4. Projects
        $projects = [
            [
                'title' => 'E-Commerce Enterprise Platform',
                'slug' => 'e-commerce-enterprise-platform',
                'category' => 'Full Stack',
                'description' => 'A robust e-commerce application featuring comprehensive product cataloging, secure checkout flow, multi-channel payment integration, and administrative inventory analytics.',
                'details' => 'Engineered with Laravel backend and reactive Vue 3 frontend using Inertia.js. Includes cart persistence, transaction status webhooks, coupon redemption engine, and sales reporting charts.',
                'thumbnail' => '/images/tech-stack.png',
                'tech_stack' => ['Laravel', 'Vue.js 3', 'Tailwind CSS', 'MySQL', 'Inertia.js'],
                'demo_url' => 'https://demo.example.com/ecommerce',
                'repo_url' => 'https://github.com/example/ecommerce-platform',
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'title' => 'Aureus ERP Business Suite',
                'slug' => 'aureus-erp-business-suite',
                'category' => 'Enterprise System',
                'description' => 'Integrated Enterprise Resource Planning suite tailored for small and medium businesses, managing supply chain pipelines, employee records, and automated financial ledgers.',
                'details' => 'Built with high data integrity constraints, multi-tenant database capability, granular role-based permissions (RBAC), and automated PDF/Excel invoice exporting.',
                'thumbnail' => '/images/tech-stack.png',
                'tech_stack' => ['Laravel', 'Vue 3', 'MySQL', 'Tailwind CSS', 'Vite'],
                'demo_url' => 'https://demo.example.com/aureuserp',
                'repo_url' => 'https://github.com/example/aureuserp',
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'title' => 'Collaborative Task & Sprint Tracker',
                'slug' => 'collaborative-task-sprint-tracker',
                'category' => 'Productivity App',
                'description' => 'Modern project tracking platform with interactive Kanban boards, sprint roadmaps, real-time activity feeds, and milestone analytics.',
                'details' => 'Features drag-and-drop ticket workflows, WebSocket notifications, team workspace isolation, and automated deadline reminders.',
                'thumbnail' => '/images/tech-stack.png',
                'tech_stack' => ['Vue.js 3', 'Laravel', 'Tailwind CSS', 'Pinia'],
                'demo_url' => 'https://demo.example.com/task-manager',
                'repo_url' => 'https://github.com/example/task-manager',
                'is_featured' => true,
                'order' => 3,
            ],
            [
                'title' => 'Maternal Healthcare Classification Portal',
                'slug' => 'maternal-healthcare-classification-portal',
                'category' => 'Healthcare & AI',
                'description' => 'Intelligent clinical decision support web application predicting maternal risk categories based on biometric and laboratory diagnostics data.',
                'details' => 'Developed for healthcare professionals to streamline patient risk assessment using machine learning algorithms and clinical telemetry visualization.',
                'thumbnail' => '/images/tech-stack.png',
                'tech_stack' => ['Laravel', 'Python', 'Vue.js', 'Tailwind CSS', 'MySQL'],
                'demo_url' => 'https://demo.example.com/health-portal',
                'repo_url' => 'https://github.com/example/health-portal',
                'is_featured' => false,
                'order' => 4,
            ],
        ];

        foreach ($projects as $p) {
            Project::firstOrCreate(['slug' => $p['slug']], $p);
        }

        // 5. Experiences
        $experiences = [
            [
                'position' => 'Full Stack Developer',
                'company' => 'Tech Solutions Inc.',
                'period' => '2024 - Present',
                'description' => 'Architecting and maintaining scalable full-stack web applications with Laravel and Vue 3. Designing efficient RESTful APIs, optimizing relational MySQL database queries, and collaborating in agile sprints.',
                'type' => 'work',
                'order' => 1,
            ],
            [
                'position' => 'Frontend Developer Intern',
                'company' => 'Creative Agency Studio',
                'period' => '2023 - 2024',
                'description' => 'Developed high-fidelity, accessible user interfaces using Vue.js, Tailwind CSS, and TypeScript. Partnered with UX researchers and UI designers to ensure optimal responsiveness across all viewports.',
                'type' => 'work',
                'order' => 2,
            ],
            [
                'position' => 'Informatics Engineering Student',
                'company' => 'Universitas Halu Oleo (UHO)',
                'period' => '2022 - Present',
                'description' => 'Focusing on software engineering principles, algorithms & data structures, database administration, and distributed system architectures.',
                'type' => 'education',
                'order' => 3,
            ],
        ];

        foreach ($experiences as $e) {
            Experience::firstOrCreate(
                ['position' => $e['position'], 'company' => $e['company']],
                $e
            );
        }

        // 6. Sample Contact Message
        ContactMessage::firstOrCreate(
            ['email' => 'client@enterprise.com'],
            [
                'name' => 'Alexandre Dubois',
                'subject' => 'Project Collaboration Opportunity',
                'message' => 'Hi Ikbal, we were very impressed by your Laravel & Vue.js portfolio and would love to discuss a potential full-stack contract project with you.',
                'is_read' => false,
            ]
        );
    }
}
