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
                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline stroke-linecap="round" stroke-linejoin="round" points="14 2 14 8 20 8" />
                            <line stroke-linecap="round" stroke-linejoin="round" x1="16" y1="13" x2="8" y2="13" />
                            <line stroke-linecap="round" stroke-linejoin="round" x1="16" y1="17" x2="8" y2="17" />
                            <polyline stroke-linecap="round" stroke-linejoin="round" points="10 9 9 9 8 9" />
                        </svg>
                    </div>
                    <h1 class="text-4xl font-extrabold tracking-tight mb-3 text-white">DocuManage</h1>
                    <p class="text-lg text-indigo-100 font-medium">Recover Access</p>
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
                                    d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline stroke-linecap="round" stroke-linejoin="round" points="14 2 14 8 20 8" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">DocuManage</h2>
                    </div>

                    <div class="mb-10 text-center lg:text-left">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Forgot Password? 🔒</h2>
                        <p class="text-gray-500 font-medium">Enter your email and we'll send you a link to reset your
                            password.</p>
                    </div>

                    @if (session('status'))
                        <div
                            class="mb-6 bg-green-50 text-green-800 border border-green-200 p-4 rounded-xl flex shadow-sm items-start">
                            <svg class="w-5 h-5 flex-shrink-0 text-green-500 mt-0.5 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm font-medium">{{ session('status') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                        @csrf

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Email Address
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none bg-gray-50/50 hover:bg-gray-50 focus:bg-white @error('email') border-red-500 ring-4 ring-red-500/10 @enderror"
                                placeholder="Enter your email" required autofocus>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full py-3.5 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/20 hover:shadow-xl hover:-translate-y-0.5 transition-all outline-none focus:ring-4 focus:ring-indigo-500/30 flex justify-center items-center gap-2 group">
                                Send Reset Link
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Back to Login -->
                        <div class="text-center pt-4 border-t border-gray-100 mt-8">
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 transition-colors gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Login
                            </a>
                        </div>
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