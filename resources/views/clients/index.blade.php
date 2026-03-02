@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="font-black text-3xl text-indigo-900 flex items-center gap-3">
                <div class="p-3 bg-indigo-100 rounded-2xl shadow-inner">
                    <i class="fas fa-users text-indigo-600"></i>
                </div>
                My Clients
            </h2>
            <p class="text-indigo-400 font-medium mt-1 ml-16 flex items-center gap-2">
                <i class="fas fa-id-card text-xs"></i>
                Manage your clients and their documents
            </p>
        </div>

        <div class="flex items-center gap-3">
            @if(Auth::user()->is_admin || Auth::user()->hasPermission('clients.create'))
                <a href="{{ route('clients.create') }}"
                    class="group flex items-center gap-2 px-6 py-3 bg-white text-indigo-600 border border-indigo-200 rounded-2xl hover:bg-indigo-50 transition-all duration-300 shadow-sm hover:-translate-y-1 font-bold">
                    <i class="fas fa-plus-circle group-hover:rotate-90 transition-transform duration-500 text-indigo-400"></i>
                    <span>Add Client</span>
                </a>
            @endif

            @if(Auth::user()->is_admin || Auth::user()->hasPermission('documents.create'))
                <a href="{{ route('documents.create') }}"
                    class="group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg shadow-indigo-200 hover:-translate-y-1 font-bold">
                    <i
                        class="fas fa-cloud-upload-alt group-hover:scale-110 transition-transform duration-300 text-indigo-100"></i>
                    <span>Upload Document</span>
                </a>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div
                class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-sm flex items-center gap-3 animate-fade-in">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div
            class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl shadow-indigo-100/50 border border-indigo-50 overflow-hidden">
            <div class="p-8">
                <form method="GET" action="{{ route('clients.index') }}" class="mb-10 flex gap-4 max-w-2xl">
                    <div class="relative flex-1 group">
                        <i
                            class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-indigo-300 group-focus-within:text-indigo-500 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name, email, or CIN..."
                            class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-700 placeholder:text-gray-400 shadow-inner">
                    </div>
                    <button type="submit"
                        class="px-8 py-3.5 bg-slate-900 text-white rounded-2xl font-black hover:bg-black transition-all active:scale-95 shadow-lg">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('clients.index') }}"
                            class="flex items-center justify-center p-3.5 bg-indigo-50 text-indigo-600 rounded-2xl hover:bg-indigo-100 transition-all">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </form>

                <div class="overflow-x-auto rounded-2xl border border-indigo-50">
                    <table class="min-w-full divide-y divide-indigo-50">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th
                                    class="px-6 py-5 text-left text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">
                                    Client Name</th>
                                <th
                                    class="px-6 py-5 text-left text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">
                                    Contact Info</th>
                                <th
                                    class="px-6 py-5 text-left text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">
                                    CIN</th>
                                <th
                                    class="px-6 py-5 text-left text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">
                                    Created</th>
                                <th
                                    class="px-6 py-5 text-right text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-indigo-50">
                            @forelse($clients as $client)
                                <tr class="hover:bg-indigo-50/30 transition-colors group">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-10 w-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 font-black">
                                                {{ substr($client->name, 0, 1) }}
                                            </div>
                                            <span class="font-black text-gray-900">{{ $client->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col gap-0.5">
                                            <span
                                                class="font-bold text-gray-700 text-sm">{{ $client->email ?? 'No email' }}</span>
                                            <span
                                                class="text-xs text-indigo-400 font-medium">{{ $client->phone ?? 'No phone' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-black border border-slate-200">
                                            {{ $client->cin ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="text-sm font-bold text-gray-500">{{ $client->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <a href="{{ route('clients.show', $client) }}"
                                            class="inline-flex items-center gap-2 px-5 py-2 bg-white text-indigo-600 border border-indigo-100 rounded-xl font-black text-xs hover:bg-indigo-600 hover:text-white transition-all shadow-sm hover:shadow-indigo-200">
                                            Manage <i class="fas fa-chevron-right text-[10px]"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="p-6 bg-slate-50 rounded-full text-slate-300 text-4xl">
                                                <i class="fas fa-user-slash"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-black text-xl text-gray-400">No clients found</h3>
                                                <p class="text-gray-400 mt-1">Start by adding your first client to the system.
                                                </p>
                                            </div>
                                            @if(Auth::user()->hasPermission('clients.create'))
                                                <a href="{{ route('clients.create') }}"
                                                    class="mt-2 text-indigo-600 font-black hover:underline underline-offset-4">Add
                                                    your first client</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
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
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
@endsection