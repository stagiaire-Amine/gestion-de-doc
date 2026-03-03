@extends('layouts.app')

@section('content')
    <div class="space-y-8 animate-fade-in">
        <!-- Header Section -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-2">
            <div class="space-y-2">
                <h1 class="text-4xl font-black text-slate-900 flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    Clients Directory
                </h1>
                <p class="text-slate-500 font-medium tracking-tight ml-1">
                    Manage and organize your client database and their associated documents.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('clients.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-100 transition-all active:scale-95">
                    <i class="fa-solid fa-plus"></i>
                    Add Client
                </a>
                <a href="{{ route('documents.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:border-indigo-400 hover:bg-indigo-50 text-slate-700 hover:text-indigo-600 font-semibold rounded-xl transition-all shadow-sm">
                    <i class="fa-solid fa-file-arrow-up"></i>
                    Upload Document
                </a>
            </div>
        </header>

        @if($apiError)
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-xl flex items-center gap-4">
                <i class="fa-solid fa-circle-exclamation text-rose-500 text-xl"></i>
                <div>
                    <p class="font-bold">Connection Error</p>
                    <p class="text-sm opacity-90">{{ $apiError }}</p>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl flex items-center gap-4">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <div>
                    <p class="font-bold">Success</p>
                    <p class="text-sm opacity-90">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Search Section -->
        <section class="max-w-2xl">
            <form action="{{ route('clients.index') }}" method="GET" class="relative group">
                <div
                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" name="q" value="{{ $q }}" placeholder="Search clients by name, email or CIN..."
                    class="block w-full pl-11 pr-32 py-3.5 bg-white border border-slate-200 rounded-2xl shadow-sm focus:ring-4 focus:ring-indigo-100 focus:border-indigo-400 text-slate-900 placeholder-slate-400 transition-all">
                <div class="absolute inset-y-2 right-2 flex items-center">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl text-sm font-bold transition-all">
                        Search
                    </button>
                </div>
            </form>
        </section>

        <!-- Content Card -->
        <div class="bg-white border border-slate-100 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] overflow-hidden">
            @if(count($clients) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr
                                class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold text-xs uppercase tracking-wider">
                                <th class="px-6 py-4">Client Name</th>
                                <th class="px-6 py-4">Contact Info</th>
                                <th class="px-6 py-4">CIN / Reg</th>
                                <th class="px-6 py-4">Address</th>
                                <th class="px-6 py-4">Created</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($clients as $client)
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200">
                                                {{ strtoupper(substr($client['name'], 0, 1)) }}
                                            </div>
                                            <div class="font-bold text-slate-900">{{ $client['name'] }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col gap-0.5">
                                            <span class="text-indigo-600 font-medium text-sm flex items-center gap-1.5">
                                                <i class="fa-solid fa-envelope text-xs opacity-70"></i>
                                                {{ $client['email'] ?? 'N/A' }}
                                            </span>
                                            <span class="text-slate-500 text-xs flex items-center gap-1.5">
                                                <i class="fa-solid fa-phone text-[10px] opacity-70"></i>
                                                {{ $client['phone'] ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="px-2 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg border border-slate-200">
                                            {{ $client['cin'] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="text-slate-500 text-sm max-w-[200px] truncate" title="{{ $client['address'] }}">
                                            {{ $client['address'] ?? 'Not set' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-slate-400 text-xs">
                                            {{ \Carbon\Carbon::parse($client['created_at'])->format('d M, Y') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div
                                            class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('documents.create', ['client_id' => $client['id']]) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white text-xs font-bold rounded-lg transition-all border border-indigo-100">
                                                <i class="fa-solid fa-file-circle-plus"></i>
                                                Add Document
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="py-20 px-6 text-center">
                    <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-user-slash text-4xl text-indigo-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">No clients found</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-8">
                        @if($q)
                            We couldn't find any clients matching your search "{{ $q }}".
                        @else
                            You haven't added any clients yet.
                        @endif
                    </p>
                    <a href="{{ route('clients.create') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-100 transition-all">
                        <i class="fa-solid fa-plus"></i>
                        Add Your First Client
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }
    </style>
@endsection