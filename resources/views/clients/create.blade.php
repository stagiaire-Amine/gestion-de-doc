@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8 animate-fade-in pb-12">

        <!-- Header Section -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <h1 class="text-4xl font-black text-slate-900 flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <i class="fa-solid fa-user-plus text-xl"></i>
                    </div>
                    Add New Client
                </h1>
                <p class="text-slate-500 font-medium tracking-tight ml-1 leading-relaxed">
                    Create a new client record to start managing their documents securely in DocuManage Cloud.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('documents.create') }}"
                    class="inline-flex items-center gap-2.5 px-6 py-3 bg-white border border-slate-200 hover:border-indigo-400 hover:bg-indigo-50 text-slate-700 hover:text-indigo-600 font-bold rounded-2xl transition-all shadow-sm">
                    <i class="fa-solid fa-file-arrow-up"></i>
                    Upload Document
                </a>

                <a href="{{ route('clients.index') }}"
                    class="inline-flex items-center gap-2.5 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95">
                    <i class="fa-solid fa-list-ul"></i>
                    View All Clients
                </a>
            </div>
        </header>

        <!-- Global Errors -->
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-6 text-rose-900 shadow-sm animate-shake">
                <div class="flex items-start gap-4">
                    <div
                        class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-rose-200">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-black tracking-tight">Check your information</p>
                        <ul class="mt-1 list-disc space-y-0.5 pl-5 text-sm font-semibold opacity-75">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Card Container -->
        <div
            class="bg-white border border-slate-100/80 rounded-[2.5rem] shadow-[0_20px_60px_rgba(0,0,0,0.03)] overflow-hidden relative">

            <!-- Progress Indicator -->
            <div class="bg-indigo-50/50 border-b border-indigo-100/50 flex items-center overflow-x-auto scroller-none">
                <div class="flex-1 py-6 px-10 border-r border-indigo-100/50 bg-white flex items-center gap-4 min-w-[300px]">
                    <div
                        class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-black shadow-lg shadow-indigo-200">
                        <i class="fa-solid fa-pencil"></i>
                    </div>
                    <div>
                        <h5 class="text-sm font-black text-slate-800 uppercase tracking-widest leading-none mb-1">Client
                            Information</h5>
                        <p class="text-[10px] text-indigo-500 font-bold uppercase tracking-[0.2em]">Personal Details</p>
                    </div>
                </div>

                <div
                    class="flex-1 py-6 px-10 flex items-center gap-4 opacity-30 select-none grayscale cursor-not-allowed bg-slate-50/50 min-w-[300px]">
                    <div
                        class="w-10 h-10 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center text-sm font-black">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <h5 class="text-sm font-black text-slate-800 uppercase tracking-widest leading-none mb-1">Review &
                            Save</h5>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em]">Final Step</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('clients.store') }}" method="POST" class="p-10 md:p-14 space-y-12">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-10">

                    <!-- Left Column -->
                    <div class="space-y-8 text-left">
                        <!-- FULL NAME -->
                        <div class="space-y-3">
                            <label for="name"
                                class="block text-[11px] font-black uppercase tracking-[0.2em] text-indigo-400/80 ml-1">
                                FULL NAME <span class="text-rose-500">*</span>
                                <span
                                    class="ml-2 inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-[10px] font-black text-indigo-600">REQUIRED</span>
                            </label>

                            <div class="relative group/field">
                                <div
                                    class="absolute left-5 top-1/2 -translate-y-1/2 w-10 h-10 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center transition-all group-focus-within/field:bg-indigo-600 group-focus-within/field:text-white shadow-sm ring-4 ring-transparent group-focus-within/field:ring-indigo-100">
                                    <i class="fa-solid fa-id-card text-sm"></i>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    placeholder="e.g., John Smith"
                                    class="block w-full pl-20 pr-6 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-indigo-400 focus:ring-0 transition-all text-slate-900 placeholder-slate-300 font-semibold text-lg hover:bg-slate-100">
                            </div>

                            @error('name')
                                <p class="text-rose-600 text-[11px] font-bold px-4 flex items-center gap-2 mt-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- EMAIL -->
                        <div class="space-y-3">
                            <label for="email"
                                class="block text-[11px] font-black uppercase tracking-[0.2em] text-indigo-400/80 ml-1">
                                EMAIL ADDRESS
                            </label>
                            <div class="relative group/field">
                                <i
                                    class="fa-solid fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/field:text-indigo-500 transition-colors"></i>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    placeholder="client@example.com"
                                    class="block w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-indigo-400 focus:ring-0 transition-all text-slate-900 placeholder-slate-300 font-semibold hover:bg-slate-100">
                            </div>
                            @error('email')
                                <p class="text-rose-600 text-[11px] font-bold px-4 flex items-center gap-2 mt-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-8 text-left">
                        <!-- PHONE -->
                        <div class="space-y-3">
                            <label for="phone"
                                class="block text-[11px] font-black uppercase tracking-[0.2em] text-indigo-400/80 ml-1">
                                PHONE NUMBER
                            </label>
                            <div class="relative group/field">
                                <i
                                    class="fa-solid fa-phone absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/field:text-indigo-500 transition-colors"></i>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                    placeholder="+212 600-000000"
                                    class="block w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-indigo-400 focus:ring-0 transition-all text-slate-900 placeholder-slate-300 font-semibold hover:bg-slate-100">
                            </div>
                            @error('phone')
                                <p class="text-rose-600 text-[11px] font-bold px-4 flex items-center gap-2 mt-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- CIN / REGISTRATION -->
                        <div class="space-y-3">
                            <label for="cin"
                                class="block text-[11px] font-black uppercase tracking-[0.2em] text-indigo-400/80 ml-1">
                                CIN / REGISTRATION NUMBER
                            </label>
                            <div class="relative group/field">
                                <i
                                    class="fa-solid fa-fingerprint absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/field:text-indigo-500 transition-colors"></i>
                                <input type="text" name="cin" id="cin" value="{{ old('cin') }}" placeholder="ID000-00-0000"
                                    class="block w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-indigo-400 focus:ring-0 transition-all text-slate-900 placeholder-slate-300 font-semibold hover:bg-slate-100">
                            </div>
                            @error('cin')
                                <p class="text-rose-600 text-[11px] font-bold px-4 flex items-center gap-2 mt-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                </div>

                <!-- ADDRESS (Full Width) -->
                <div class="space-y-4 text-left">
                    <label for="address"
                        class="block text-[11px] font-black uppercase tracking-[0.2em] text-indigo-400/80 ml-1">
                        LIVING ADDRESS
                    </label>

                    <div class="relative group/field">
                        <i
                            class="fa-solid fa-map-location-dot absolute left-6 top-6 text-slate-300 group-focus-within/field:text-indigo-500 transition-colors"></i>
                        <textarea name="address" id="address" rows="5"
                            placeholder="Include street, city, postal code, and country..."
                            class="block w-full pl-14 pr-6 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-indigo-400 focus:ring-0 transition-all text-slate-900 placeholder-slate-300 font-semibold hover:bg-slate-100 resize-none transition-all duration-300">{{ old('address') }}</textarea>
                    </div>

                    @error('address')
                        <p class="text-rose-600 text-[11px] font-bold px-4 flex items-center gap-2 mt-1">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Footer Actions -->
                <div class="pt-10 border-t border-slate-100 flex flex-col items-center gap-10">
                    <div class="w-full flex flex-col md:flex-row items-center justify-between gap-6">
                        <a href="{{ route('clients.index') }}"
                            class="group text-slate-400 hover:text-slate-700 font-black uppercase tracking-[0.2em] text-[10px] flex items-center gap-3 transition-colors">
                            <i
                                class="fa-solid fa-xmark bg-slate-50 group-hover:bg-slate-100 p-2 rounded-full transition-colors font-bold"></i>
                            Cancel & Discard
                        </a>

                        <button type="submit"
                            class="group inline-flex items-center gap-4 px-10 py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-2xl shadow-indigo-200 transition-all active:scale-[0.98] transform hover:-translate-y-1">
                            <span class="text-sm md:text-base uppercase tracking-widest">Save Client Record</span>
                            <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                        </button>
                    </div>

                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] flex items-center gap-3">
                        <span class="w-6 h-6 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-lock text-[10px]"></i>
                        </span>
                        Securely stored in DocuManage Cloud
                    </p>
                </div>

            </form>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }

        .scroller-none::-webkit-scrollbar {
            display: none;
        }

        .scroller-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection