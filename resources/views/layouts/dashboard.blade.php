<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'DocuManage'))</title>

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-100 {
            animation-delay: .1s;
        }

        .delay-200 {
            animation-delay: .2s;
        }

        .delay-300 {
            animation-delay: .3s;
        }

        .delay-400 {
            animation-delay: .4s;
        }

        .delay-500 {
            animation-delay: .5s;
        }

        .row-hover-transition {
            transition: background-color .15s ease, transform .2s ease, box-shadow .2s ease, border-left .15s;
        }

        .row-hover-transition:hover {
            background-color: #f0f7ff;
            transform: translateY(-2px) scale(1.002);
            box-shadow: 0 6px 14px -6px rgba(79, 70, 229, .15);
            border-left: 3px solid #4f46e5;
        }

        .stat-card-hover {
            transition: all .25s ease;
        }

        .stat-card-hover:hover {
            background: linear-gradient(145deg, #fff, #faf5ff);
            border-color: #c7d2fe;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 20px 25px -12px rgba(99, 102, 241, .25);
        }

        .btn-pulse {
            animation: soft-pulse 2.5s infinite;
        }

        @keyframes soft-pulse {
            0% {
                box-shadow: 0 4px 14px rgba(79, 70, 229, .4);
            }

            50% {
                box-shadow: 0 8px 24px rgba(79, 70, 229, .7);
            }

            100% {
                box-shadow: 0 4px 14px rgba(79, 70, 229, .4);
            }
        }

        .nav-link-hover {
            transition: all .15s;
        }

        .nav-link-hover:hover {
            background-color: #ede9fe;
            color: #4f46e5;
            transform: translateX(4px);
        }

        .file-type-badge {
            transition: background .2s, transform .1s;
        }

        .file-type-badge:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-indigo-50 via-slate-50 to-purple-50/40 min-h-screen">
    <div x-data="{ sidebarOpen: true }" class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-x-full opacity-0"
            class="w-72 bg-white/90 backdrop-blur-md border-r border-indigo-200/60 shadow-xl shadow-indigo-100/30 flex flex-col fixed inset-y-0 left-0 z-50 md:relative">

            <div class="p-6 border-b border-indigo-100 flex items-center space-x-3 group min-h-[4rem]">
                <div
                    class="h-9 w-9 bg-gradient-to-br from-indigo-600 to-purple-500 rounded-xl flex items-center justify-center text-white shadow-md transition-all group-hover:scale-110 group-hover:rotate-3">
                    <i class="fas fa-file-alt text-lg"></i>
                </div>
                <span
                    class="text-xl font-bold bg-gradient-to-r from-indigo-700 to-purple-600 bg-clip-text text-transparent">DocuManage</span>
            </div>

            <nav class="px-4 py-6 space-y-1.5 flex-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-indigo-50/80 text-indigo-700 border-l-4 border-indigo-500 shadow-sm' : 'text-gray-600' }} rounded-xl font-medium transition-all nav-link-hover">
                    <i
                        class="fas fa-columns w-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-indigo-400' }}"></i>
                    DocuManage
                </a>

                <a href="{{ route('documents.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('documents.index') ? 'bg-indigo-50/80 text-indigo-700 border-l-4 border-indigo-500 shadow-sm' : 'text-gray-600' }} rounded-xl font-medium nav-link-hover transition-all duration-200">
                    <i
                        class="fas fa-folder-open w-5 {{ request()->routeIs('documents.index') ? 'text-indigo-600' : 'text-indigo-400' }}"></i>
                    Documents
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('profile.*') ? 'bg-indigo-50/80 text-indigo-700 border-l-4 border-indigo-500 shadow-sm' : 'text-gray-600' }} rounded-xl font-medium nav-link-hover transition-all duration-200">
                    <i
                        class="fas fa-user-circle w-5 {{ request()->routeIs('profile.*') ? 'text-indigo-600' : 'text-indigo-400' }}"></i>
                    Profile
                </a>

                <a href="{{ route('documents.create') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('documents.create') ? 'bg-indigo-50/80 text-indigo-700 border-l-4 border-indigo-500 shadow-sm' : 'text-gray-600' }} rounded-xl font-medium nav-link-hover transition-all duration-200">
                    <i
                        class="fas fa-cloud-upload-alt w-5 {{ request()->routeIs('documents.create') ? 'text-indigo-600' : 'text-indigo-400' }}"></i>
                    Upload
                </a>

                <div class="pt-4 mt-2 border-t border-dashed border-indigo-200/60">
                    <div class="px-4 py-2 text-xs font-semibold text-indigo-400 uppercase tracking-wider">filters</div>

                    <a href="{{ route('documents.archived') }}"
                        class="flex items-center gap-3 px-4 py-2 text-sm {{ request()->routeIs('documents.archived') ? 'text-indigo-700 font-bold' : 'text-indigo-600/70' }} hover:bg-indigo-50 rounded-xl transition">
                        <i class="fas fa-archive w-5 text-indigo-300"></i> Archive
                    </a>

                    <a href="{{ route('reclamations.index') }}"
                        class="flex items-center gap-3 px-4 py-2 text-sm {{ request()->routeIs('reclamations.*') ? 'text-indigo-700 font-bold' : 'text-indigo-600/70' }} hover:bg-indigo-50 rounded-xl transition">
                        <i class="fas fa-headset w-5 text-indigo-300"></i> Support
                    </a>
                </div>

                @if(Auth::user() && Auth::user()->is_admin)
                    <div class="pt-4 mt-2 border-t border-dashed border-indigo-200/60">
                        <div class="px-4 py-2 text-xs font-semibold text-purple-400 uppercase tracking-wider">administration
                        </div>

                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm {{ request()->routeIs('admin.users.*') ? 'text-purple-700 font-bold' : 'text-purple-600/70' }} hover:bg-purple-50 rounded-xl transition">
                            <i class="fas fa-users-cog w-5 text-purple-300"></i> Users Management
                        </a>

                        <a href="{{ route('admin.reclamations.index') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm {{ request()->routeIs('admin.reclamations.*') ? 'text-purple-700 font-bold' : 'text-purple-600/70' }} hover:bg-purple-50 rounded-xl transition">
                            <i class="fas fa-headset w-5 text-purple-300"></i> Support Tickets
                        </a>
                    </div>
                @endif
            </nav>

            <div class="p-4 border-t border-indigo-100 flex-shrink-0 bg-white">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-rose-600 hover:bg-rose-50 rounded-xl transition-all hover:translate-x-1 group">
                        <i class="fas fa-sign-out-alt group-hover:rotate-12 transition"></i> Log out
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- TOP NAV -->
            <nav
                class="bg-white/70 backdrop-blur-md border-b border-indigo-200/40 px-6 h-16 flex items-center justify-between shadow-sm flex-shrink-0">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg text-indigo-600 hover:bg-indigo-100 transition-all hover:rotate-12 active:rotate-0">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="flex items-center gap-4">
                    <span class="hidden md:inline text-sm text-indigo-400"><i class="far fa-bell"></i></span>
                    <div
                        class="font-medium text-gray-700 bg-gradient-to-r from-indigo-100 to-purple-100 px-4 py-1.5 rounded-full shadow-inner flex items-center gap-2">
                        <i class="fas fa-circle text-xs text-emerald-500"></i>
                        {{ Auth::user()?->name ?? 'Guest' }}
                        @if(Auth::user()?->is_admin)
                            <span
                                class="bg-purple-200 text-purple-800 text-[10px] uppercase font-bold px-1.5 py-0.5 rounded ml-1">Admin</span>
                        @endif
                    </div>
                </div>
            </nav>

            <div class="flex-1 overflow-y-auto">
                <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
                    <!-- HEADER YIELD -->
                    @hasSection('header')
                        <header>
                            @yield('header')
                        </header>
                    @endif

                    <!-- MAIN CONTENT YIELD -->
                    <div>
                        @yield('content')
                    </div>
                </main>

                <div
                    class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex gap-4 text-xs text-indigo-400 justify-end items-center animate-fade-slide-up delay-500">
                    <span
                        class="bg-indigo-100 border border-indigo-200 px-3 py-1 rounded-full text-indigo-600 font-medium tracking-wide shadow-sm">DocuManage
                        Platform</span>
                </div>
            </div>

        </div>
    </div>

    <x-site-popup />
    <x-delete-modal />
</body>

</html>