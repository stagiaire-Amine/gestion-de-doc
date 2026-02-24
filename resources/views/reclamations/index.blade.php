@extends('layouts.dashboard')

@section('title', 'DocuManage • Support')

@section('header')
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-violet-200/60 shadow-sm">
        <div>
            <h2
                class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-violet-700 to-fuchsia-600 leading-tight">
                <i class="fas fa-headset mr-2 text-violet-400"></i> Support Tickets
            </h2>
            <p class="text-violet-500 text-sm mt-1 flex items-center gap-2">
                <i class="fas fa-ticket-alt text-xs"></i> View and manage your reclamations
            </p>
        </div>

        <a href="{{ route('reclamations.create') }}"
            class="group flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-white rounded-xl hover:from-violet-700 hover:to-fuchsia-600 transition-all duration-300 shadow-md shadow-violet-200 hover:shadow-lg hover:scale-105 active:scale-95">
            <i class="fas fa-plus"></i>
            <span class="font-medium text-sm">New Ticket</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Success Message -->
        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                class="bg-emerald-50 text-emerald-700 px-5 py-4 rounded-xl border-l-4 border-emerald-400 flex items-center justify-between shadow-md">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                    <span class="font-medium">{{ session('status') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Card -->
        <div
            class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-violet-200/70 overflow-hidden transition-all hover:shadow-2xl duration-300">
            @if($reclamations->isEmpty())
                <div class="p-16 text-center">
                    <div
                        class="mx-auto h-28 w-28 bg-gradient-to-br from-violet-100 to-fuchsia-100 rounded-full flex items-center justify-center mb-5 shadow-inner">
                        <i class="fas fa-ticket-alt text-4xl text-violet-400"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800">No support tickets</h3>
                    <p class="mt-2 text-violet-400 max-w-sm mx-auto">
                        Submit a new ticket if you are experiencing any issues.
                    </p>
                    <a href="{{ route('reclamations.create') }}"
                        class="inline-block mt-6 px-6 py-2 border border-violet-200 text-violet-700 rounded-full text-sm hover:bg-violet-50 transition">
                        Create new ticket
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-violet-100">
                        <thead class="bg-violet-50/70">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-violet-700 uppercase tracking-wider">
                                    Subject
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-violet-700 uppercase tracking-wider">
                                    Priority
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-violet-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-violet-700 uppercase tracking-wider">
                                    Created
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-violet-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-violet-100">
                            @foreach($reclamations as $ticket)
                                @php
                                    // Status
                                    $s = $ticket->status;
                                    $sColors = [
                                        'open' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'in_progress' => 'bg-violet-100 text-violet-800 border-violet-200',
                                        'resolved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'closed' => 'bg-gray-100 text-gray-800 border-gray-200',
                                    ];
                                    $statusClass = $sColors[$s] ?? $sColors['open'];

                                    // Priority
                                    $p = $ticket->priority;
                                    $pColors = [
                                        'low' => 'text-emerald-500',
                                        'medium' => 'text-amber-500',
                                        'high' => 'text-rose-500',
                                    ];
                                    $pClass = $pColors[$p] ?? 'text-gray-500';
                                @endphp

                                <tr class="hover:bg-violet-50/50 transition-all cursor-pointer"
                                    onclick="window.location='{{ route('reclamations.show', $ticket) }}'">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-semibold text-gray-800">{{ $ticket->subject }}</div>
                                        <div class="text-xs text-violet-400 truncate max-w-xs mt-0.5">
                                            {{ Str::limit($ticket->message, 50) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $pClass }} capitalize">
                                        <i class="fas fa-flag text-xs mr-1"></i> {{ $p }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusClass }} capitalize">
                                            <i class="fas fa-circle text-[6px] mr-1"></i> {{ str_replace('_', ' ', $s) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-violet-500">
                                        {{ $ticket->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <a href="{{ route('reclamations.show', $ticket) }}"
                                            class="text-violet-500 hover:text-fuchsia-600 hover:underline">
                                            View details <i class="fas fa-chevron-right text-xs ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
    </div>
@endsection