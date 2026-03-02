@extends('layouts.guest')

@section('content')
    <div
        class="min-h-screen w-full flex items-center justify-center p-4 sm:p-6 bg-gradient-to-br from-slate-100 via-indigo-50 to-purple-50">
        <div
            class="flex flex-col lg:flex-row w-full max-w-5xl bg-white rounded-3xl overflow-hidden shadow-2xl animate-fade-in-up border border-indigo-100/50">

            <!-- Left Section - Branding -->
            <div
                class="hidden lg:flex flex-1 flex-col items-center justify-center p-12 bg-gradient-to-br from-indigo-600 to-purple-700 text-white text-center relative overflow-hidden">
                <div class="relative z-10 flex flex-col items-center">
                    <div
                        class="mb-8 p-4 bg-white/10 backdrop-blur-md rounded-2xl shadow-lg border border-white/20 animate-pulse-slow">
                        <svg class="w-16 h-16 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-extrabold tracking-tight mb-3 text-white">Security First</h1>
                    <p class="text-lg text-indigo-100 font-medium">Please update your temporary password to continue.</p>
                </div>

                <!-- Decorative circles -->
                <div
                    class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl translate-x-1/3 translate-y-1/3 pointer-events-none">
                </div>
            </div>

            <!-- Right Section - Form -->
            <div class="flex-1 p-8 sm:p-12 lg:p-16 bg-white flex flex-col justify-center">
                <div class="max-w-md w-full mx-auto">
                    <div class="lg:hidden mb-8 text-center flex flex-col items-center">
                        <div class="p-3 bg-indigo-50 border border-indigo-100 rounded-2xl mb-4 inline-block shadow-sm">
                            <svg class="w-10 h-10 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Security First</h2>
                    </div>

                    <div class="mb-8 text-center lg:text-left">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Change Password</h2>
                        <p class="text-gray-500 font-medium leading-relaxed">For your security, you must set a new password
                            before accessing the platform.</p>
                    </div>

                    @if ($errors->any())
                        <div
                            class="mb-6 bg-red-50 text-red-800 border border-red-200 p-4 rounded-xl flex shadow-sm items-start">
                            <svg class="w-5 h-5 flex-shrink-0 text-red-500 mt-0.5 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <ul class="list-disc pl-4 space-y-1 text-sm font-medium">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.force_reset.store') }}" class="space-y-6">
                        @csrf

                        <!-- New Password Field -->
                        <div>
                            <label for="password" class="text-sm font-semibold text-gray-700 mb-2 flex flex-col gap-1">
                                <span class="flex items-center gap-2"><svg class="w-4 h-4 text-indigo-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg> New Password</span>
                            </label>
                            <input id="password" type="password" name="password" required autofocus
                                class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none bg-gray-50/50 hover:bg-gray-50 focus:bg-white"
                                placeholder="Enter new password">
                            <p class="mt-2 text-xs text-gray-500 font-medium pl-1">Must be at least 8 characters long.</p>
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <label for="password_confirmation"
                                class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                Confirm Password
                            </label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none bg-gray-50/50 hover:bg-gray-50 focus:bg-white"
                                placeholder="Confirm new password">
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full py-3.5 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/20 hover:shadow-xl hover:-translate-y-0.5 transition-all outline-none focus:ring-4 focus:ring-indigo-500/30 flex justify-center items-center gap-2 group">
                                Save Password & Continue
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="mt-6 text-center">
                        @csrf
                        <button type="submit"
                            class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors group inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Logout instead
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
    </style>
@endsection