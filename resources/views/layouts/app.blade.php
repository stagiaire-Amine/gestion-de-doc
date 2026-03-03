<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<<<<<<< HEAD
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DocuManage') }}</title>

    <!-- Tailwind CSS (CDN Fallback for local dev) -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --glass: rgba(255, 255, 255, 0.7);
        }

        body {
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }

        .bg-soft-gradient {
            background: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(99, 102, 241, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(79, 70, 229, 0.05) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(99, 102, 241, 0.05) 0px, transparent 50%),
                #f8fafc;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-slide-right {
            animation: slideInRight 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .stagger-1 {
            animation-delay: 0.1s;
        }

        .stagger-2 {
            animation-delay: 0.2s;
        }

        .stagger-3 {
            animation-delay: 0.3s;
        }

        /* Glassmorphism */
        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-soft-gradient min-h-screen text-slate-800 antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @yield('content')
    </div>

    <!-- Success/Error Alerts (Global) -->
    @if(session('success'))
        <div id="status-toast"
            class="fixed bottom-10 right-10 bg-white border-l-4 border-emerald-500 text-slate-800 px-8 py-5 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] z-50 flex items-center gap-4 animate-slide-right stagger-1 overflow-hidden group">
            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="font-black text-sm uppercase tracking-widest text-emerald-600">Success</p>
                <p class="font-semibold text-slate-600">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 opacity-0 group-hover:opacity-100 transition-opacity">
                <i class="fa-solid fa-xmark text-slate-300 hover:text-slate-500"></i>
            </button>
        </div>
        <script>setTimeout(() => {
                const toast = document.getElementById('status-toast');
                if (toast) {
                    toast.style.transform = 'translateX(120%)';
                    toast.style.transition = 'transform 0.5s ease-in';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 5000)</script>
    @endif

    @if(session('error'))
        <div id="error-toast"
            class="fixed bottom-10 right-10 bg-white border-l-4 border-rose-500 text-slate-800 px-8 py-5 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] z-50 flex items-center gap-4 animate-slide-right stagger-1 overflow-hidden group">
            <div class="w-10 h-10 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <p class="font-black text-sm uppercase tracking-widest text-rose-600">Error</p>
                <p class="font-semibold text-slate-600">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 opacity-0 group-hover:opacity-100 transition-opacity">
                <i class="fa-solid fa-xmark text-slate-300 hover:text-slate-500"></i>
            </button>
        </div>
        <script>setTimeout(() => {
                const toast = document.getElementById('error-toast');
                if (toast) {
                    toast.style.transform = 'translateX(120%)';
                    toast.style.transition = 'transform 0.5s ease-in';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 7000)</script>
    @endif
=======
    <title>{{ config('app.name', 'DocuManage') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body class="bg-gradient-to-br from-slate-50 via-indigo-50/30 to-purple-50/30 min-h-screen">
    <div x-data="{ sidebarOpen: true }" class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside x-show="sidebarOpen"
            class="w-72 bg-white/90 backdrop-blur-xl border-r border-indigo-100 shadow-xl shadow-indigo-100/40">
            <div class="p-6 border-b flex items-center gap-3">
                <div
                    class="h-12 w-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-black text-indigo-700">DocuManage</div>
                    <div class="text-xs text-indigo-400 font-medium">document management</div>
                </div>
            </div>

            <nav class="px-4 py-6 space-y-2 flex-col flex gap-1 h-full overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                    <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-columns text-indigo-600"></i>
                    </div>
                    Dashboard
                </a>

                <a href="{{ route('documents.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('documents.index') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                    <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-folder-open text-indigo-600"></i>
                    </div>
                    Documents
                </a>

                <a href="{{ route('documents.create') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('documents.create') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                    <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cloud-upload-alt text-indigo-600"></i>
                    </div>
                    Upload
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                    <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-circle text-indigo-600"></i>
                    </div>
                    Profile
                </a>

                <a href="{{ route('documents.archived') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('documents.archived.*') || request()->routeIs('documents.archived') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                    <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-archive text-indigo-600"></i>
                    </div>
                    Archive
                </a>

                <a href="{{ route('reclamations.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('reclamations.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                    <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-headset text-indigo-600"></i>
                    </div>
                    Support
                </a>

                @if(Auth::user() && Auth::user()->is_admin)
                    <div class="pt-4 mt-2 mb-2 border-t border-indigo-100"></div>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('admin.users.*') ? 'bg-purple-100 text-purple-800' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <div class="h-8 w-8 bg-purple-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users-cog text-purple-700"></i>
                        </div>
                        Users Management
                    </a>

                    <a href="{{ route('admin.reclamations.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('admin.reclamations.*') ? 'bg-purple-100 text-purple-800' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <div class="h-8 w-8 bg-purple-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-headset text-purple-700"></i>
                        </div>
                        Support Tickets
                    </a>
                @endif
            </nav>

            <div class="px-4 mt-auto">
                <div class="p-4 bg-indigo-50/60 rounded-xl border border-indigo-100">
                    <div class="flex items-center gap-3">
                        <div
                            class="h-10 w-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                            @auth
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            @else
                                U
                            @endauth
                        </div>
                        <div>
                            <div class="font-medium text-gray-700">{{ Auth::user()?->name ?? 'User' }}</div>
                            <div class="text-xs text-indigo-500">Pro Account</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 border-t mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl">
                        <i class="fas fa-sign-out-alt"></i>
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN --}}
        <div class="flex-1">
            {{-- TOPBAR --}}
            <div
                class="bg-white/70 backdrop-blur-xl border-b border-indigo-100 px-6 h-16 flex items-center justify-between sticky top-0 z-30">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2.5 rounded-xl hover:bg-indigo-100">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:block font-medium text-gray-700">
                        {{ Auth::user()?->name ?? 'Guest' }}
                    </div>
                    <div
                        class="h-10 w-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                        @auth
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        @else
                            G
                        @endauth
                    </div>
                </div>
            </div>

            {{-- PAGE CONTENT --}}
            <main>
                @hasSection('header')
                    <div class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            @yield('header')
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

    </div>

    <x-site-popup />
    <x-delete-modal />
>>>>>>> ba423d4ca8b0b93271da5dafa3e306809b3ffcde
</body>

</html>