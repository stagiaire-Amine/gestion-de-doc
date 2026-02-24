@extends('layouts.dashboard')

@section('title', 'DocuManage • Ticket Details')

@section('header')
    @php
        // Status Colors Configuration
        $sColors = [
            'open' => 'bg-amber-100 text-amber-800 border-amber-200',
            'in_progress' => 'bg-violet-100 text-violet-800 border-violet-200',
            'resolved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'closed' => 'bg-gray-100 text-gray-800 border-gray-200',
        ];
        $statusClass = $sColors[$reclamation->status] ?? $sColors['open'];

        // Priority Colors Configuration
        $pColors = [
            'low' => 'bg-emerald-100 text-emerald-700',
            'medium' => 'bg-amber-100 text-amber-700',
            'high' => 'bg-rose-100 text-rose-700',
        ];
        $pBadge = $pColors[$reclamation->priority] ?? 'bg-gray-100 text-gray-700';
    @endphp

    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-violet-200/60 shadow-sm">
        <div>
            <div class="flex items-center gap-3 mb-2 animate-fade-up">
                <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $statusClass }} capitalize shadow-sm">
                    <i class="fas fa-circle text-[8px] mr-1"></i> {{ str_replace('_', ' ', $reclamation->status) }}
                </span>
                <span class="text-xs font-semibold text-gray-400">
                    Ticket #{{ str_pad($reclamation->id, 5, '0', STR_PAD_LEFT) }}
                </span>
            </div>

            <h2
                class="font-bold text-2xl sm:text-3xl text-gray-800 leading-tight flex items-center gap-2 animate-fade-up delay-100">
                {{ $reclamation->subject }}
            </h2>

            <div class="text-violet-500 text-sm mt-2 flex items-center gap-4 animate-fade-up delay-200">
                <span><i class="far fa-clock text-xs"></i> Opened
                    {{ $reclamation->created_at->format('M d, Y h:i A') }}</span>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $pBadge }} capitalize shadow-inner">
                    {{ $reclamation->priority }} Priority
                </span>
            </div>
        </div>

        <a href="{{ route('reclamations.index') }}"
            class="group flex items-center gap-2 px-5 py-2.5 bg-violet-50 text-violet-600 rounded-xl hover:bg-violet-100 transition-all duration-300 shadow-sm border border-violet-200 shrink-0">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition"></i>
            <span class="font-medium text-sm">Back to Tickets</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto animate-fade-up delay-300">
        <!-- Message Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-violet-200/70 overflow-hidden mb-6">

            <!-- Card Header -->
            <div class="px-6 py-4 bg-violet-50/50 border-b border-violet-100 flex items-center gap-4">
                <div
                    class="h-10 w-10 bg-gradient-to-br from-violet-500 to-fuchsia-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div>
                    <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-violet-400">Ticket Owner</div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6 sm:p-8">
                <div
                    class="prose prose-violet max-w-none prose-p:text-gray-700 prose-p:leading-relaxed whitespace-pre-wrap">
                    {{ $reclamation->message }}
                </div>
            </div>

            <!-- Card Footer -->
            <div
                class="px-6 py-4 bg-gray-50/80 border-t border-violet-100 flex justify-between items-center text-xs text-gray-500">
                <span>Last updated {{ $reclamation->updated_at->diffForHumans() }}</span>
            </div>
        </div>

        <!-- System Note -->
        <div
            class="flex items-start gap-4 p-4 rounded-xl bg-gradient-to-r from-violet-50 to-fuchsia-50 border border-violet-100 text-sm text-violet-800 shadow-sm">
            <div class="mt-0.5"><i class="fas fa-info-circle text-violet-400 text-lg"></i></div>
            <div>
                <strong class="block mb-1">Support Team Notice</strong>
                We review tickets during regular business hours. A support representative will respond to your reclamation
                as soon as possible based on the priority level.
            </div>
        </div>

    </div>

    <style>
        .animate-fade-up {
            animation: fadeUp .5s cubic-bezier(.2, .9, .3, 1) forwards;
            opacity: 0;
        }

        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(16px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-100 {
            animation-delay: .1s
        }

        .delay-200 {
            animation-delay: .2s
        }

        .delay-300 {
            animation-delay: .3s
        }
    </style>
@endsection