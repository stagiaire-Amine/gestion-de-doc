<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
</body>

</html>