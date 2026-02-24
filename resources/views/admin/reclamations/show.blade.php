@extends('layouts.dashboard')

@section('title', 'DocuManage • Ticket Review')

@section('header')
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-purple-200/60 shadow-sm">
        <div>
            <h2
                class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-purple-700 to-indigo-600 leading-tight">
                <i class="fas fa-ticket-alt mr-2 text-purple-400"></i> Ticket
                #{{ str_pad($reclamation->id, 5, '0', STR_PAD_LEFT) }}
            </h2>
            <p class="text-purple-500 text-sm mt-1 flex items-center gap-2">
                <i class="fas fa-user text-xs"></i> Submitted by {{ $reclamation->user->name ?? 'Unknown User' }}
                ({{ $reclamation->user->email ?? 'Deleted Account' }})
            </p>
        </div>

        <a href="{{ route('admin.reclamations.index') }}"
            class="group flex items-center gap-2 px-6 py-2.5 bg-gray-50 text-gray-600 rounded-xl hover:bg-gray-100 transition-all duration-300 shadow-sm border border-gray-200 font-semibold">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition"></i>
            <span>Back to Inbox</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2"
                class="bg-emerald-50/90 backdrop-blur-sm text-emerald-700 px-5 py-4 rounded-xl border border-emerald-200 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-emerald-100 p-1.5 rounded-lg text-emerald-600 mt-1">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <span class="font-medium flex-1 break-words">{!! session('status') !!}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-purple-200/70 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-purple-100">

                <!-- Ticket Content -->
                <div class="col-span-2 p-8 space-y-6">
                    <div>
                        <h3 class="text-sm font-bold text-purple-400 uppercase tracking-wider mb-2">Subject</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $reclamation->subject }}</p>
                    </div>

                    <div class="pt-6 border-t border-gray-100">
                        <h3 class="text-sm font-bold text-purple-400 uppercase tracking-wider mb-4">Message</h3>
                        <div
                            class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-gray-700 whitespace-pre-wrap font-medium leading-relaxed shadow-inner">
                            {{ $reclamation->message }}
                        </div>
                    </div>
                </div>

                <!-- Ticket Management Sidebar -->
                <div class="p-8 bg-purple-50/30 space-y-8">

                    <!-- Update Status Form -->
                    <div class="bg-white p-5 rounded-xl border border-purple-100 shadow-sm">
                        <h3 class="text-sm font-bold text-indigo-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i class="fas fa-tasks"></i> Update Status
                        </h3>

                        <form action="{{ route('admin.reclamations.update', $reclamation) }}" method="POST"
                            class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="relative">
                                <select name="status"
                                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 bg-gray-50 capitalize font-bold">
                                    <option value="open" {{ $reclamation->status === 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $reclamation->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $reclamation->status === 'resolved' ? 'selected' : '' }}>
                                        Resolved</option>
                                    <option value="closed" {{ $reclamation->status === 'closed' ? 'selected' : '' }}>Closed
                                    </option>
                                </select>
                            </div>

                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-md shadow-indigo-200 transition-all hover:-translate-y-0.5">
                                <i class="fas fa-save"></i> Save Status
                            </button>
                        </form>
                    </div>

                    <!-- Metadata -->
                    <div>
                        <h3 class="text-sm font-bold text-purple-400 uppercase tracking-wider mb-3">Ticket Information</h3>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                                <span class="text-sm font-medium text-gray-500">Priority</span>
                                @php
                                    $priColors = [
                                        'low' => 'bg-gray-100 text-gray-700',
                                        'medium' => 'bg-blue-100 text-blue-800',
                                        'high' => 'bg-rose-100 text-rose-800',
                                    ];
                                    $priClass = $priColors[$reclamation->priority] ?? $priColors['low'];
                                @endphp
                                <span
                                    class="px-2.5 py-1 rounded-md text-xs font-bold capitalize {{ $priClass }}">{{ $reclamation->priority }}</span>
                            </div>

                            <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                                <span class="text-sm font-medium text-gray-500">Current Status</span>
                                @php
                                    $statColors = [
                                        'open' => 'bg-yellow-100 text-yellow-800',
                                        'in_progress' => 'bg-indigo-100 text-indigo-800',
                                        'resolved' => 'bg-emerald-100 text-emerald-800',
                                        'closed' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $statClass = $statColors[$reclamation->status] ?? $statColors['open'];
                                @endphp
                                <span
                                    class="px-2.5 py-1 rounded-md text-xs font-bold capitalize {{ $statClass }}">{{ str_replace('_', ' ', $reclamation->status) }}</span>
                            </div>

                            <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                                <span class="text-sm font-medium text-gray-500">Submitted</span>
                                <span
                                    class="text-sm font-bold text-gray-800">{{ $reclamation->created_at->format('M d, Y H:i') }}</span>
                            </div>

                            <div class="flex items-center justify-between pb-1">
                                <span class="text-sm font-medium text-gray-500">Last Update</span>
                                <span
                                    class="text-sm font-bold text-gray-800">{{ $reclamation->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection