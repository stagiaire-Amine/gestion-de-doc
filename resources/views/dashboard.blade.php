@extends('layouts.dashboard')

@section('title', 'DocuManage • Dashboard')

@php
    $mimeBadge = function ($mime) {
        $mime = strtolower($mime ?? '');
        if (str_contains($mime, 'pdf'))
            return ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'label' => 'PDF', 'iconColor' => 'text-rose-500'];
        if (str_contains($mime, 'image'))
            return ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'label' => 'IMG', 'iconColor' => 'text-emerald-500'];
        if (str_contains($mime, 'word') || str_contains($mime, 'document'))
            return ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'label' => 'DOC', 'iconColor' => 'text-blue-500'];
        if (str_contains($mime, 'excel') || str_contains($mime, 'spreadsheet'))
            return ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'label' => 'XLS', 'iconColor' => 'text-emerald-600'];
        if (str_contains($mime, 'powerpoint') || str_contains($mime, 'presentation'))
            return ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'label' => 'PPT', 'iconColor' => 'text-orange-500'];
        return ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'label' => 'FILE', 'iconColor' => 'text-purple-500'];
    };

    $statusMeta = function ($status) {
        $s = strtolower($status ?? 'draft');
        return match ($s) {
            'approved' => ['text' => 'text-emerald-600', 'dot' => 'text-emerald-600', 'label' => 'approved'],
            'pending' => ['text' => 'text-amber-600', 'dot' => 'text-amber-600', 'label' => 'pending'],
            'rejected' => ['text' => 'text-rose-600', 'dot' => 'text-rose-600', 'label' => 'rejected'],
            'draft' => ['text' => 'text-indigo-600', 'dot' => 'text-indigo-600', 'label' => 'draft'],
            default => ['text' => 'text-gray-600', 'dot' => 'text-gray-600', 'label' => $s],
        };
    };
@endphp

@section('header')
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-indigo-200/60 shadow-sm">
        <div>
            <h1 class="text-4xl font-bold text-gray-800 animate-fade-slide-up">
                DocuManage<span class="text-indigo-600 animate-pulse">.</span>
            </h1>

        </div>

        <a href="{{ route('documents.create') }}"
            class="group flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-500 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-300/50 hover:shadow-indigo-400/60 transition-all duration-300 hover:scale-105 active:scale-95 animate-fade-slide-up delay-200 btn-pulse font-semibold">
            <i class="fas fa-cloud-upload-alt mr-2 group-hover:scale-110 transition-transform"></i>
            <span>Upload document</span>
            <i class="fas fa-chevron-right text-xs opacity-70 ml-1"></i>
        </a>
    </div>
@endsection

@section('content')
    <!-- STATS -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div
            class="bg-white rounded-2xl border border-indigo-100 p-5 flex items-center gap-4 animate-fade-slide-up delay-100 stat-card-hover group">
            <div
                class="h-12 w-12 rounded-xl bg-gradient-to-br from-rose-100 to-rose-200 text-rose-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition">
                <i class="fas fa-file-pdf text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-rose-400">PDF files</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pdfCount }}</p>
                <p class="text-xs text-rose-300">from database</p>
            </div>
        </div>

        <div
            class="bg-white rounded-2xl border border-sky-100 p-5 flex items-center gap-4 animate-fade-slide-up delay-200 stat-card-hover group">
            <div
                class="h-12 w-12 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200 text-emerald-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition">
                <i class="fas fa-image text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-emerald-400">Images</p>
                <p class="text-2xl font-bold text-gray-800">{{ $imageCount }}</p>
                <p class="text-xs text-emerald-300">from database</p>
            </div>
        </div>

        <div
            class="bg-white rounded-2xl border border-blue-100 p-5 flex items-center gap-4 animate-fade-slide-up delay-300 stat-card-hover group">
            <div
                class="h-12 w-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition">
                <i class="fas fa-file-word text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-blue-400">Word files</p>
                <p class="text-2xl font-bold text-gray-800">{{ $wordCount }}</p>
                <p class="text-xs text-blue-300">from database</p>
            </div>
        </div>

        <div
            class="bg-white rounded-2xl border border-purple-100 p-5 flex items-center gap-4 animate-fade-slide-up delay-400 stat-card-hover group">
            <div
                class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 text-purple-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition">
                <i class="fas fa-share-alt text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-purple-400">Shared</p>
                <p class="text-2xl font-bold text-gray-800">{{ $sharedCount }}</p>
                <p class="text-xs text-purple-300">from database</p>
            </div>
        </div>
    </section>

    <!-- RECENT DOCUMENTS TABLE -->
    <section
        class="mt-10 bg-white/90 backdrop-blur-sm rounded-2xl border border-indigo-200/60 overflow-hidden shadow-md shadow-indigo-100/20">
        <div class="px-6 py-4 border-b border-indigo-100 font-semibold text-indigo-800 flex items-center justify-between">
            <span><i class="fas fa-clock mr-2 text-indigo-400"></i>Recently updated documents</span>
            <span class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">live</span>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-indigo-50/70 text-indigo-600">
                <tr>
                    <th class="px-6 py-3 text-left font-medium">Name</th>
                    <th class="px-6 py-3 text-left font-medium">Type</th>
                    <th class="px-6 py-3 text-left font-medium">Modified</th>
                    <th class="px-6 py-3 text-left font-medium">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-indigo-50">
                @forelse($recentDocuments as $doc)
                    @php
                        $b = $mimeBadge($doc->mime_type);
                        $s = $statusMeta($doc->status);
                        $name = $doc->title ?? $doc->original_name ?? 'untitled sequence';
                        $modified = optional($doc->updated_at)->diffForHumans() ?? '-';
                    @endphp

                    <tr class="row-hover-transition cursor-pointer"
                        onclick="window.location.href='{{ route('documents.index') }}'">
                        <td class="px-6 py-4 font-medium text-gray-800">
                            <i class="fas {{ $doc->file_icon }} mr-2 {{ $b['iconColor'] }}"></i>{{ $name }}
                            @if($doc->original_name && $name !== $doc->original_name)
                                <div class="text-[10px] text-gray-400 font-normal ml-6">{{ $doc->original_name }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="{{ $b['bg'] }} {{ $b['text'] }} px-3 py-1 rounded-full text-xs file-type-badge font-bold">
                                {{ $b['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $modified }}</td>
                        <td class="px-6 py-4">
                            <span class="flex items-center gap-1.5 {{ $s['text'] }} font-medium">
                                <i class="fas fa-circle text-[8px] {{ $s['dot'] }}"></i> {{ $s['label'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            No recent documents. Upload your first document!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-3 bg-indigo-50/40 border-t border-indigo-100 text-right">
            <a href="{{ route('documents.index') }}"
                class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors flex items-center justify-end gap-1">
                view all documents <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>
@endsection