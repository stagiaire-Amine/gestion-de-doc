@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="font-black text-3xl text-indigo-900 flex items-center gap-3">
                <div class="p-3 bg-indigo-100 rounded-2xl shadow-inner">
                    <i class="fas {{ $document->file_icon }} text-indigo-600"></i>
                </div>
                Document Detail
            </h2>
            <p class="text-indigo-400 font-medium mt-1 ml-16 flex items-center gap-2">
                <i class="fas fa-file-signature text-xs"></i>
                Manage and view information for
                <span class="text-indigo-600 font-bold italic">"{{ $document->title }}"</span>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('documents.index') }}"
                class="group flex items-center gap-2 px-5 py-2.5 bg-white text-gray-600 rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-sm border border-gray-200 font-bold">
                <i class="fas fa-chevron-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Back</span>
            </a>
            <a href="{{ route('documents.download', $document) }}"
                class="group flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg shadow-indigo-200 hover:-translate-y-0.5 font-bold">
                <i class="fas fa-cloud-download-alt group-hover:translate-y-0.5 transition-transform text-indigo-100"></i>
                <span>Download</span>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Side: Main Info & Preview Mockup -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Main Card -->
                <div
                    class="bg-white rounded-3xl shadow-xl shadow-indigo-100/50 border border-indigo-50 overflow-hidden group hover:shadow-2xl hover:shadow-indigo-200/40 transition-all duration-500">
                    <div class="p-8 md:p-10">
                        <div class="flex justify-between items-start mb-10">
                            <div class="space-y-1">
                                <span class="text-xs font-black text-indigo-300 uppercase tracking-[0.2em]">Document
                                    Title</span>
                                <h1 class="text-4xl font-black text-gray-900 leading-tight">{{ $document->title }}</h1>
                            </div>

                            <div class="relative">
                                @php
                                    $statusColors = [
                                        'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-100 ring-emerald-500/10',
                                        'rejected' => 'bg-rose-50 text-rose-700 border-rose-100 ring-rose-500/10',
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-100 ring-amber-500/10',
                                        'draft' => 'bg-slate-100 text-slate-700 border-slate-200 ring-slate-500/10',
                                    ];
                                    $statusClass = $statusColors[$document->status] ?? $statusColors['pending'];
                                @endphp
                                <div class="flex flex-col items-end gap-2">
                                    <span
                                        class="inline-flex items-center gap-2 px-5 py-2 rounded-2xl text-sm font-black border {{ $statusClass }} ring-4 uppercase tracking-wider shadow-sm">
                                        <div class="h-2 w-2 rounded-full bg-current animate-pulse"></div>
                                        {{ $document->status }}
                                    </span>
                                    @if($document->is_starred)
                                        <div
                                            class="flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 rounded-lg border border-amber-100 text-[10px] font-black uppercase tracking-tighter shadow-sm animate-bounce-slow">
                                            <i class="fas fa-star text-xs"></i>
                                            Priority
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-6">
                                <div
                                    class="p-5 bg-slate-50 rounded-2xl border border-slate-100 hover:border-indigo-100 transition-colors group/item">
                                    <h3
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 group-hover/item:text-indigo-400 transition-colors">
                                        Description</h3>
                                    <p class="text-gray-600 leading-relaxed font-medium italic">
                                        {{ $document->description ?: 'No additional description provided for this document.' }}
                                    </p>
                                </div>

                                <div
                                    class="p-5 bg-slate-50 rounded-2xl border border-slate-100 hover:border-indigo-100 transition-colors group/item">
                                    <h3
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 group-hover/item:text-indigo-400 transition-colors">
                                        General Info</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <span
                                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Category</span>
                                            <span class="font-bold text-indigo-700 flex items-center gap-1.5">
                                                <i class="fas fa-folder text-indigo-300 text-xs"></i>
                                                {{ $document->category ?? 'Uncategorized' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span
                                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Type</span>
                                            <span class="font-bold text-slate-700 flex items-center gap-1.5">
                                                <i class="fas fa-file-code text-slate-300 text-xs"></i>
                                                {{ strtoupper(explode('/', $document->mime_type)[1] ?? 'FILE') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="relative flex items-center justify-center p-8 bg-indigo-50/30 rounded-3xl border border-dashed border-indigo-200 overflow-hidden group/preview">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 opacity-0 group-hover/preview:opacity-100 transition-opacity duration-700">
                                </div>
                                <div class="relative flex flex-col items-center">
                                    <div
                                        class="text-8xl mb-4 drop-shadow-2xl transform group-hover/preview:scale-110 group-hover/preview:rotate-3 transition-transform duration-500">
                                        <i class="fas {{ $document->file_icon }}"></i>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-black text-gray-500 text-xs uppercase tracking-widest mb-1">
                                            {{ $document->file_size_formatted }}
                                        </div>
                                        <div
                                            class="px-4 py-1.5 bg-white/80 backdrop-blur-sm rounded-full text-[10px] font-bold text-indigo-600 border border-indigo-100 shadow-sm break-all max-w-[180px]">
                                            {{ $document->original_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Sidebar Meta & Actions -->
            <div class="space-y-6">
                <!-- Meta Card -->
                <div class="bg-white rounded-3xl shadow-xl shadow-indigo-100/50 border border-indigo-50 p-8 space-y-6">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-clock text-indigo-500"></i> Timeline
                    </h3>

                    <div class="space-y-6 relative ml-2">
                        <!-- Timeline Line -->
                        <div class="absolute left-1 top-2 bottom-2 w-0.5 bg-indigo-50"></div>

                        <div class="relative pl-8 group/time">
                            <div
                                class="absolute left-0 top-1 w-2.5 h-2.5 rounded-full bg-indigo-200 ring-4 ring-white group-hover/time:bg-indigo-500 transition-colors">
                            </div>
                            <span
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Created
                                On</span>
                            <span class="font-bold text-slate-700">{{ $document->created_at->format('F d, Y') }}</span>
                            <span
                                class="block text-xs text-slate-400 font-medium">{{ $document->created_at->format('H:i A') }}</span>
                        </div>

                        <div class="relative pl-8 group/time">
                            <div
                                class="absolute left-0 top-1 w-2.5 h-2.5 rounded-full bg-purple-200 ring-4 ring-white group-hover/time:bg-purple-500 transition-colors">
                            </div>
                            <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Last
                                Activity</span>
                            <span class="font-bold text-slate-700">{{ $document->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Admin/Owner Actions Card -->
                <div
                    class="bg-slate-900 rounded-3xl shadow-2xl p-8 space-y-6 text-white shadow-slate-900/40 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
                    </div>

                    <h3
                        class="relative text-sm font-black text-indigo-300 uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-tools"></i> Tools
                    </h3>

                    <div class="relative flex flex-col gap-3">
                        <a href="{{ route('documents.edit', $document) }}"
                            class="w-full h-12 flex items-center justify-center gap-3 bg-white/10 hover:bg-white/20 text-white rounded-2xl font-black transition-all border border-white/10 active:scale-95">
                            <i class="fas fa-magic text-indigo-400"></i>
                            Modify Elements
                        </a>

                        <button type="button" @click="$dispatch('open-delete-modal', { 
                                    url: '{{ route('documents.destroy', $document) }}', 
                                    title: 'Archive Document', 
                                    message: 'Are you sure you want to archive this document? You can restore it later from the archive.' 
                                })"
                            class="w-full h-12 flex items-center justify-center gap-3 bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white rounded-2xl font-black transition-all border border-rose-500/20 active:scale-95">
                            <i class="fas fa-archive"></i>
                            Archive Document
                        </button>
                    </div>
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
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes bounceSlow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .animate-bounce-slow {
            animation: bounceSlow 3s infinite ease-in-out;
        }
    </style>
@endsection