<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocuManage · animated login</title>
    <!-- Tailwind via CDN + a touch of extra polish -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- subtle inter font for better readability -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz@14..32&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        /* custom keyframes – fluid background shift + levitating pulse */
        @keyframes float-slow {
            0% {
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-8px) scale(1.02);
            }

            100% {
                transform: translateY(0px) scale(1);
            }
        }

        @keyframes bgDrift {
            0% {
                background-position: 0% 0%;
            }

            50% {
                background-position: 100% 100%;
            }

            100% {
                background-position: 0% 0%;
            }
        }

        @keyframes softGlow {
            0% {
                box-shadow: 0 0 0px 0px rgba(99, 102, 241, 0.2), 0 0 0px 0px rgba(168, 85, 247, 0.2);
            }

            50% {
                box-shadow: 0 0 20px 5px rgba(99, 102, 241, 0.3), 0 0 30px 10px rgba(168, 85, 247, 0.2);
            }

            100% {
                box-shadow: 0 0 0px 0px rgba(99, 102, 241, 0.2), 0 0 0px 0px rgba(168, 85, 247, 0.2);
            }
        }

        .animate-float-slow {
            animation: float-slow 6s ease-in-out infinite;
        }

        .animate-bg-drift {
            background-size: 200% 200%;
            animation: bgDrift 12s ease infinite;
        }

        .animate-glow-card {
            animation: softGlow 4s infinite;
        }

        /* extra smooth hover transitions */
        input,
        button {
            transition: all 0.2s ease;
        }

        .moving-gradient {
            background: linear-gradient(125deg, #4f46e5, #9333ea, #ec4899, #4f46e5);
            background-size: 300% 300%;
            animation: bgDrift 10s ease infinite;
        }
    </style>
</head>

<body class="antialiased">

    <!-- MAIN LAYOUT (guest) with moving background AND coloured floating orbs -->
    <div class="min-h-screen w-full flex items-center justify-center p-4 sm:p-8 moving-gradient">
        <!-- extra colourful blurred overlays for depth & motion -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-10 left-10 w-72 h-72 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"
                style="animation-duration: 7s;"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"
                style="animation-duration: 9s; animation-delay: 1s;"></div>
            <div class="absolute top-1/3 right-1/4 w-80 h-80 bg-purple-300 rounded-full mix-blend-soft-light filter blur-3xl opacity-20 animate-pulse"
                style="animation-duration: 11s;"></div>
        </div>

        <!-- main card – now with animated glow & floating effect + border transition -->
        <div
            class="flex flex-col lg:flex-row w-full max-w-5xl bg-white/95 backdrop-blur-sm rounded-3xl overflow-hidden shadow-2xl border border-indigo-200/50 animate-float-slow animate-glow-card min-h-[600px] relative z-10">

            <!-- LEFT SECTION – brand with extra colour move & icon levitation -->
            <div class="hidden lg:flex flex-1 flex-col items-center justify-center p-12 text-white text-center relative overflow-hidden"
                style="background: linear-gradient(145deg, #4f46e5, #7e22ce, #6d28d9, #4f46e5); background-size: 300% 300%; animation: bgDrift 14s ease infinite;">
                <!-- moving inner orbs -->
                <div class="absolute w-full h-full top-0 left-0 opacity-20">
                    <div class="absolute top-5 left-5 w-40 h-40 bg-white rounded-full blur-3xl animate-ping"></div>
                    <div
                        class="absolute bottom-10 right-10 w-60 h-60 bg-fuchsia-300 rounded-full blur-3xl animate-pulse">
                    </div>
                </div>

                <div class="relative z-10 flex flex-col items-center">
                    <!-- logo icon with slow colour shift & bounce -->
                    <div class="mb-8 p-4 bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 animate-bounce"
                        style="animation: bounce 3s infinite;">
                        <svg class="w-16 h-16 text-white drop-shadow-lg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline stroke-linecap="round" stroke-linejoin="round" points="14 2 14 8 20 8" />
                            <line stroke-linecap="round" stroke-linejoin="round" x1="16" y1="13" x2="8" y2="13" />
                            <line stroke-linecap="round" stroke-linejoin="round" x1="16" y1="17" x2="8" y2="17" />
                            <polyline stroke-linecap="round" stroke-linejoin="round" points="10 9 9 9 8 9" />
                        </svg>
                    </div>
                    <h1 class="text-4xl font-extrabold tracking-tight mb-3 text-white drop-shadow-md">DocuManage</h1>
                    <p class="text-lg text-indigo-100 font-medium animate-pulse" style="animation-duration: 2.5s;">
                        Document Management System</p>
                    <!-- moving decorative streak -->
                    <div class="w-32 h-1 bg-white/40 rounded-full mt-6 overflow-hidden">
                        <div class="h-full w-1/2 bg-white rounded-full animate-slide"
                            style="animation: slide 2s infinite;"></div>
                    </div>
                </div>

                <!-- extra animated orbs (same as original but moving more) -->
                <div class="absolute top-0 left-0 w-64 h-64 bg-white/20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 animate-pulse"
                    style="animation-duration: 8s;"></div>
                <div class="absolute bottom-0 right-0 w-80 h-80 bg-fuchsia-500/30 rounded-full blur-3xl translate-x-1/3 translate-y-1/3 animate-pulse"
                    style="animation-duration: 6s;"></div>
            </div>

            <!-- RIGHT SECTION – login form (with micro-interactions) -->
            <div class="flex-1 p-8 sm:p-12 lg:p-16 bg-white/90 backdrop-blur-sm flex flex-col justify-center">
                <div class="max-w-md w-full mx-auto">
                    <!-- mobile logo (appears only small screens) with gentle jiggle -->
                    <div class="lg:hidden mb-8 text-center flex flex-col items-center">
                        <div
                            class="p-3 bg-indigo-50 border border-indigo-200 rounded-2xl mb-4 inline-block shadow-md hover:rotate-2 transition-transform duration-500">
                            <svg class="w-10 h-10 text-indigo-600 animate-pulse" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline stroke-linecap="round" stroke-linejoin="round" points="14 2 14 8 20 8" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">DocuManage</h2>
                    </div>

                    <div class="mb-10 text-center lg:text-left">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                        <p class="text-gray-500 font-medium">Please sign in to access your documents</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Field with moving border/ring on focus -->
                        <div>
                            <label for="email"
                                class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-indigo-500 group-hover:scale-110 transition" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Email Address
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all outline-none bg-gray-50/50 hover:bg-gray-100 focus:bg-white @error('email') border-red-500 ring-4 ring-red-500/10 @enderror"
                                placeholder="Enter your email" required autofocus>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 font-medium flex items-center gap-1 animate-shake">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password Field with show/hide + animated eye -->
                        <div>
                            <label for="password"
                                class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-indigo-500 group-hover:rotate-12 transition" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Password
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all outline-none bg-gray-50/50 hover:bg-gray-100 focus:bg-white pr-12 @error('password') border-red-500 ring-4 ring-red-500/10 @enderror"
                                    placeholder="Enter your password" required>

                                <button type="button" id="togglePasswordBtn"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-indigo-600 focus:outline-none transition-transform hover:scale-110 active:scale-90">
                                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot (both have gentle hover animation) -->
                        <div class="flex items-center justify-between pt-2">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="remember"
                                    class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300 transition-all duration-300 cursor-pointer group-hover:scale-110"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <span
                                    class="text-sm text-gray-600 font-medium group-hover:text-gray-900 transition-colors">Remember
                                    me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-all hover:underline decoration-indigo-300 underline-offset-2">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit button – animated gradient + arrow slide -->
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full py-3.5 px-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-[length:200%_200%] hover:bg-[position:100%_0] text-white rounded-xl font-bold shadow-lg shadow-indigo-600/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-500 outline-none focus:ring-4 focus:ring-indigo-500/30 flex justify-center items-center gap-2 group">
                                Log In
                                <svg class="w-5 h-5 transition-all group-hover:translate-x-2 group-hover:scale-110"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- extra animation keyframes (shake, slide) + additional pulse variant -->
    <style>
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

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes pulseSlow {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.95;
            }
        }

        .animate-pulse-slow {
            animation: pulseSlow 3s infinite ease-in-out;
        }

        @keyframes slide {
            0% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-5px);
            }

            40% {
                transform: translateX(5px);
            }

            60% {
                transform: translateX(-3px);
            }

            80% {
                transform: translateX(3px);
            }
        }

        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }
    </style>

    <!-- same toggle script + extra micro animation on icon (just for fun) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function () {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeIcon.classList.add('hidden');
                        eyeSlashIcon.classList.remove('hidden');
                        // tiny haptic: rotate animation on button
                        toggleBtn.classList.add('rotate-12');
                        setTimeout(() => toggleBtn.classList.remove('rotate-12'), 150);
                    } else {
                        passwordInput.type = 'password';
                        eyeIcon.classList.remove('hidden');
                        eyeSlashIcon.classList.add('hidden');
                        toggleBtn.classList.add('-rotate-12');
                        setTimeout(() => toggleBtn.classList.remove('-rotate-12'), 150);
                    }
                });
            }

            // optional: floating label effect on inputs? no, but we add hover pulse to card
        });
    </script>
</body>

</html>