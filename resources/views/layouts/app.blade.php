<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DocuManage') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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
    class="bg-gradient-to-br from-slate-50 via-indigo-50/30 to-purple-50/30 dark:from-slate-900 dark:via-gray-900 dark:to-slate-900 min-h-screen transition-colors duration-300 antialiased text-gray-900 dark:text-gray-100">
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

                <a href="{{ route('clients.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('clients.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                    <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-indigo-600"></i>
                    </div>
                    Clients
                </a>

                @if(Auth::user()->is_admin || Auth::user()->hasPermission('clients.create'))
                    <a href="{{ route('clients.create') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('clients.create') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus text-indigo-600"></i>
                        </div>
                        Add Client
                    </a>
                @endif

                @if(Auth::user()->is_admin || Auth::user()->hasPermission('documents.create'))
                    <a href="{{ route('documents.create') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('documents.create') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cloud-upload-alt text-indigo-600"></i>
                        </div>
                        Upload
                    </a>
                @endif

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                    <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-circle text-indigo-600"></i>
                    </div>
                    Profile
                </a>

                @if(Auth::user()->is_admin || Auth::user()->hasPermission('documents.view'))
                    <a href="{{ route('documents.archived') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('documents.archived.*') || request()->routeIs('documents.archived') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-archive text-indigo-600"></i>
                        </div>
                        Archive
                    </a>
                @endif

                <a href="{{ route('reclamations.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('reclamations.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                    <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-headset text-indigo-600"></i>
                    </div>
                    Support
                </a>

                @if(Auth::user() && Auth::user()->is_admin)
                    <div class="pt-4 mt-2 mb-2 border-t border-indigo-100"></div>
                    <div class="px-4 mb-2">
                        <span
                            class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] ml-2">Administration</span>
                    </div>

                    <a href="{{ route('admin.users.roles.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('admin.users.roles.*') ? 'bg-purple-100 text-purple-800' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <div class="h-8 w-8 bg-purple-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-purple-700"></i>
                        </div>
                        Users
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('admin.users.*') && !request()->routeIs('admin.users.roles.*') ? 'bg-purple-100 text-purple-800' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
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
                    <button type="button" @click="toggleTheme()" aria-label="Toggle Dark Mode"
                        class="relative inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 dark:text-gray-400 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <svg x-show="!isDark" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg x-cloak x-show="isDark" style="display: none;" class="w-5 h-5" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
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
</body>

</html>