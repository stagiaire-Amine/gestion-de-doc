@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('clients.index') }}"
            class="p-3 bg-white border border-indigo-100 text-indigo-600 rounded-2xl hover:bg-indigo-50 hover:text-indigo-700 transition-all shadow-sm hover:shadow-md group">
            <i class="fas fa-chevron-left group-hover:-translate-x-0.5 transition-transform"></i>
        </a>
        <div>
            <h2 class="font-black text-3xl text-indigo-900 flex items-center gap-3">
                <i class="fas fa-user-plus text-indigo-400 bg-indigo-50 p-2 rounded-2xl"></i>
                Add New Client
            </h2>
            <p class="text-indigo-400 font-medium flex items-center gap-2">
                <i class="fas fa-sparkle text-xs"></i>
                Create a new client record to start managing their documents
            </p>
        </div>

        <div class="ml-auto flex items-center gap-3">
            <a href="{{ route('documents.create') }}"
                class="group flex items-center gap-2 px-6 py-3 bg-white text-indigo-600 border border-indigo-100 rounded-2xl hover:bg-indigo-50 transition-all duration-300 shadow-sm hover:shadow-md font-bold text-sm">
                <i class="fas fa-cloud-upload-alt group-hover:scale-110 transition-transform"></i>
                <span>Upload Document</span>
            </a>
            <a href="{{ route('clients.index') }}"
                class="group flex items-center gap-2 px-6 py-3 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-2xl hover:bg-indigo-100 transition-all duration-300 shadow-sm hover:shadow-md font-bold text-sm">
                <i class="fas fa-list-ul group-hover:scale-110 transition-transform"></i>
                <span>View All Clients</span>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Decorative elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none" style="z-index: -1">
            <div
                class="absolute top-20 left-0 w-72 h-72 bg-gradient-to-br from-indigo-100/30 to-purple-100/30 rounded-full blur-3xl">
            </div>
            <div
                class="absolute bottom-20 right-0 w-96 h-96 bg-gradient-to-tl from-blue-100/30 to-indigo-100/30 rounded-full blur-3xl">
            </div>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl shadow-indigo-200/50 border border-indigo-100/50 overflow-hidden animate-fade-in relative">

            <!-- Colorful header gradient -->
            <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

            <div class="p-8 md:p-12">
                <form method="POST" action="{{ route('clients.store') }}" class="space-y-8">
                    @csrf

                    <!-- Progress indicator -->
                    <div class="flex items-center gap-2 text-sm font-bold text-indigo-400 mb-6">
                        <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <i class="fas fa-pen text-xs"></i>
                        </div>
                        <span>Client Information</span>
                        <i class="fas fa-arrow-right text-xs text-indigo-300"></i>
                        <div class="w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <span class="text-gray-400">Review & Save</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Primary Name - Enhanced -->
                        <div class="md:col-span-2 space-y-2">
                            <label for="name"
                                class="text-xs font-black text-indigo-400 uppercase tracking-wider ml-1 flex items-center gap-2">
                                <i class="fas fa-asterisk text-[8px] text-rose-400"></i>
                                Full Name
                                <span
                                    class="text-[10px] bg-indigo-50 text-indigo-600 px-2 py-1 rounded-full">Required</span>
                            </label>
                            <div class="relative group">
                                <div
                                    class="absolute left-0 top-0 h-full w-1 bg-indigo-400 rounded-l-2xl group-focus-within:bg-indigo-600 transition-colors">
                                </div>
                                <i
                                    class="fas fa-user-circle absolute left-5 top-1/2 -translate-y-1/2 text-2xl text-indigo-300 group-focus-within:text-indigo-500 transition-all"></i>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full pl-14 pr-4 py-5 bg-gradient-to-r from-slate-50 to-white border-2 border-indigo-100/50 rounded-2xl focus:ring-0 focus:border-indigo-400 transition-all font-bold text-gray-700 placeholder:text-gray-300 hover:border-indigo-200"
                                    placeholder="e.g., John Smith">
                            </div>
                            @error('name')
                                <p class="text-rose-500 text-xs font-bold mt-1 ml-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email - Enhanced with gradient -->
                        <div class="space-y-2">
                            <label for="email"
                                class="text-xs font-black text-indigo-400 uppercase tracking-wider ml-1 flex items-center gap-2">
                                <i class="fas fa-envelope text-indigo-300"></i>
                                Email Address
                            </label>
                            <div class="relative group">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-2xl opacity-0 group-focus-within:opacity-100 transition-opacity">
                                </div>
                                <i
                                    class="fas fa-envelope-open absolute left-4 top-1/2 -translate-y-1/2 text-indigo-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="relative w-full pl-12 pr-4 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:ring-0 focus:border-indigo-400 transition-all font-bold text-gray-700 placeholder:text-gray-300 hover:bg-white"
                                    placeholder="client@example.com">
                            </div>
                            @error('email')
                                <p class="text-rose-500 text-xs font-bold mt-1 ml-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Phone - Enhanced with colors -->
                        <div class="space-y-2">
                            <label for="phone"
                                class="text-xs font-black text-indigo-400 uppercase tracking-wider ml-1 flex items-center gap-2">
                                <i class="fas fa-phone-alt text-indigo-300"></i>
                                Phone Number
                            </label>
                            <div class="relative group">
                                <div
                                    class="absolute -inset-0.5 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-2xl opacity-0 group-focus-within:opacity-30 blur transition-opacity">
                                </div>
                                <i
                                    class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-indigo-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="relative w-full pl-12 pr-4 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:ring-0 focus:border-indigo-400 transition-all font-bold text-gray-700 placeholder:text-gray-300 hover:bg-white"
                                    placeholder="+212 600-000000">
                            </div>
                            @error('phone')
                                <p class="text-rose-500 text-xs font-bold mt-1 ml-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Address - Enhanced -->
                        <div class="md:col-span-2 space-y-2">
                            <label for="address"
                                class="text-xs font-black text-indigo-400 uppercase tracking-wider ml-1 flex items-center gap-2">
                                <i class="fas fa-map-pin text-indigo-300"></i>
                                Living Address
                            </label>
                            <div class="relative group">
                                <div
                                    class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-indigo-400 to-purple-400 rounded-l-2xl">
                                </div>
                                <i
                                    class="fas fa-map-marker-alt absolute left-5 top-6 text-xl text-indigo-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <textarea name="address" id="address" rows="3"
                                    class="w-full pl-14 pr-4 py-4 bg-gradient-to-r from-slate-50 to-white border-2 border-indigo-100/50 rounded-2xl focus:ring-0 focus:border-indigo-400 transition-all font-bold text-gray-700 placeholder:text-gray-300 hover:border-indigo-200 resize-none"
                                    placeholder="Enter complete address...">{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                                <p class="text-rose-500 text-xs font-bold mt-1 ml-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror

                            <!-- Address helper -->
                            <p class="text-[10px] text-indigo-300 ml-1 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i>
                                Include street, city, postal code, and country
                            </p>
                        </div>
                    </div>

                    <!-- Additional options with colors -->


                    <!-- Form actions with enhanced colors -->
                    <div class="pt-6 border-t-2 border-indigo-100/50 flex items-center justify-between gap-4">
                        <a href="{{ route('clients.index') }}"
                            class="font-black text-gray-400 hover:text-gray-600 transition-colors flex items-center gap-2 group">
                            <i class="fas fa-times-circle group-hover:scale-110 transition-transform"></i>
                            Cancel & Discard
                        </a>
                        <button type="submit"
                            class="px-10 py-4 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white rounded-2xl font-black hover:from-indigo-700 hover:to-indigo-600 transition-all active:scale-95 shadow-xl shadow-indigo-200/50 flex items-center gap-3 group">
                            <i class="fas fa-save group-hover:scale-110 transition-transform"></i>
                            Save Client Record
                            <i
                                class="fas fa-arrow-right text-sm opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.98) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        .shimmer-effect {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            background-size: 1000px 100%;
            animation: shimmer 3s infinite linear;
        }

        /* Custom scrollbar for textarea */
        textarea::-webkit-scrollbar {
            width: 8px;
        }

        textarea::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection