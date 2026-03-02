<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DocuManage Admin')</title>

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        admin: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    }
                }
            }
        }
    </script>
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

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

        .nav-link-hover {
            transition: all .15s;
        }

        .nav-link-hover:hover {
            background-color: #f5f3ff;
            color: #7c3aed;
            transform: translateX(4px);
        }
    </style>
</head>

<body x-data="{ 
    isDark: document.documentElement.classList.contains('dark'),
    toggleTheme() {
      this.isDark = !this.isDark;
      if (this.isDark) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('color-theme', 'dark');
      } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('color-theme', 'light');
      }
    }
  }"
    class="bg-gradient-to-br from-purple-50 via-slate-50 to-indigo-50/40 dark:from-slate-900 dark:via-gray-900 dark:to-slate-900 min-h-screen transition-colors duration-300 antialiased text-gray-900 dark:text-gray-100">
    <div x-data="{ sidebarOpen: true }" class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-x-full opacity-0"
            class="w-72 bg-white/95 backdrop-blur-md border-r border-purple-200 shadow-2xl flex flex-col fixed inset-y-0 left-0 z-50 md:relative">

            <div class="p-6 border-b border-purple-100 flex items-center space-x-3 group min-h-[4rem]">
                <div
                    class="h-9 w-9 bg-gradient-to-br from-purple-600 to-indigo-500 rounded-xl flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-shield-halved text-lg"></i>
                </div>
                <div class="flex flex-col">
                    <span
                        class="text-xl font-black bg-gradient-to-r from-purple-700 to-indigo-600 bg-clip-text text-transparent">Admin
                        Panel</span>
                    <span class="text-[10px] text-purple-400 font-bold tracking-widest uppercase">DocuManage
                        Suite</span>
                </div>
            </div>

            <nav class="px-4 py-6 space-y-2 flex-1 overflow-y-auto">
                <div class="pt-4 px-4 py-2 text-[10px] font-black text-purple-300 uppercase tracking-widest">Main
                    Dashboard
                </div>

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-600' }} rounded-xl font-medium transition-all nav-link-hover">
                    <i class="fas fa-columns w-5 text-purple-400"></i>
                    Dashboard
                </a>

                <div class="pt-4 px-4 py-2 text-[10px] font-black text-purple-300 uppercase tracking-widest">App
                    Management
                </div>

                <a href="{{ route('documents.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('documents.*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-600' }} rounded-xl font-medium transition-all nav-link-hover">
                    <i class="fas fa-folder-open w-5 text-purple-400"></i>
                    Documents
                </a>

                <a href="{{ route('clients.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('clients.index') || (request()->routeIs('clients.*') && !request()->routeIs('clients.create')) ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-600' }} rounded-xl font-medium transition-all nav-link-hover">
                    <i class="fas fa-users w-5 text-purple-400"></i>
                    Clients
                </a>

                <a href="{{ route('clients.create') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('clients.create') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-600' }} rounded-xl font-medium transition-all nav-link-hover">
                    <i class="fas fa-user-plus w-5 text-purple-400"></i>
                    Add Client
                </a>

                <a href="{{ route('documents.create') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('documents.create') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-600' }} rounded-xl font-medium transition-all nav-link-hover">
                    <i class="fas fa-cloud-upload-alt w-5 text-purple-400"></i>
                    Upload Document
                </a>

                <div class="pt-4 px-4 py-2 text-[10px] font-black text-purple-300 uppercase tracking-widest">User Access
                </div>

                <a href="{{ route('admin.users.roles.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.users.roles.*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-600' }} rounded-xl font-medium transition-all nav-link-hover">
                    <i
                        class="fas fa-users w-5 {{ request()->routeIs('admin.users.roles.*') ? 'text-purple-600' : 'text-purple-400' }}"></i>
                    Users & Roles
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.users.*') && !request()->routeIs('admin.users.roles.*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-600' }} rounded-xl font-medium transition-all nav-link-hover">
                    <i
                        class="fas fa-users-cog w-5 {{ request()->routeIs('admin.users.*') && !request()->routeIs('admin.users.roles.*') ? 'text-purple-600' : 'text-purple-400' }}"></i>
                    Account Management
                </a>

                <div class="pt-4 px-4 py-2 text-[10px] font-black text-purple-300 uppercase tracking-widest">System
                </div>

                <a href="{{ route('admin.reclamations.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.reclamations.*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-600' }} rounded-xl font-medium transition-all nav-link-hover">
                    <i
                        class="fas fa-headset w-5 {{ request()->routeIs('admin.reclamations.*') ? 'text-purple-600' : 'text-purple-400' }}"></i>
                    Support Tickets
                </a>
            </nav>

            <div class="p-4 border-t border-purple-100 flex-shrink-0 bg-white/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full flex items-center gap-3 px-4 py-3 text-rose-600 hover:bg-rose-50 rounded-xl transition-all font-bold">
                        <i class="fas fa-power-off"></i> Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- TOP NAV -->
            <nav
                class="bg-white/80 backdrop-blur-md border-b border-purple-100 px-6 h-16 flex items-center justify-between shadow-sm flex-shrink-0">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-purple-600 hover:bg-purple-50">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="flex items-center gap-4">
                    <button type="button" @click="toggleTheme()"
                        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800">
                        <i x-show="!isDark" class="fas fa-moon"></i>
                        <i x-show="isDark" class="fas fa-sun"></i>
                    </button>
                    <div class="h-8 w-[1px] bg-purple-100 mx-2"></div>
                    <div class="flex items-center gap-3">
                        <div class="flex flex-col items-end hidden sm:flex">
                            <span class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</span>
                            <span class="text-[10px] font-black text-purple-600 uppercase">System Admin</span>
                        </div>
                        <div
                            class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold shadow-lg border-2 border-white">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </nav>

            <div class="flex-1 overflow-y-auto">
                <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    @hasSection('header')
                        <div class="mb-8">
                            @yield('header')
                        </div>
                    @endif

                    @yield('content')
                </main>

                <footer class="p-8 text-center text-gray-400 text-xs tracking-widest font-bold uppercase">
                    &copy; {{ date('Y') }} DocuManage Security Operations
                </footer>
            </div>

        </div>
    </div>

    <x-delete-modal />
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="fixed bottom-6 right-6 z-[100] animate-fade-slide-up">
            <div
                class="bg-emerald-500 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3 border border-emerald-400/50">
                <i class="fas fa-check-circle"></i>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        </div>
    @endif
</body>

</html>