@extends('layouts.dashboard')

@section('title', 'DocuManage • Documents')

@section('header')
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-indigo-200/60 shadow-sm">
        <div>
            <h2
                class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-indigo-700 to-purple-600 leading-tight">
                <i class="fas fa-folder-open mr-2 text-indigo-400"></i> My Documents
            </h2>
            <p class="text-indigo-500 text-sm mt-1 flex items-center gap-2">
                <i class="fas fa-info-circle text-xs"></i> Manage and organize your files
            </p>
        </div>

        <a href="{{ route('documents.create') }}"
            class="group flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg shadow-indigo-200 hover:-translate-y-0.5 font-semibold">
            <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
            <span>Upload Document</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2"
                class="bg-emerald-50/90 backdrop-blur-sm text-emerald-700 px-5 py-4 rounded-xl border border-emerald-200 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-emerald-100 p-1.5 rounded-lg text-emerald-600">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <span class="font-medium">{{ session('status') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-indigo-200/70 overflow-hidden">
            @if($documents->isEmpty())
                <div class="p-16 text-center">
                    <div
                        class="mx-auto h-24 w-24 bg-indigo-50 border border-indigo-100 rounded-full flex items-center justify-center mb-5 shadow-inner">
                        <i class="fas fa-folder-open text-4xl text-indigo-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">No documents yet</h3>
                    <p class="mt-2 text-gray-500">Get started by uploading your first document.</p>
                    <div class="mt-8">
                        <a href="{{ route('documents.create') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-md transition-colors">
                            <i class="fas fa-cloud-upload-alt"></i> Upload Document
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Document</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($documents as $document)
                                <tr class="hover:bg-indigo-50/30 transition-colors group">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 bg-indigo-50/80 rounded-xl flex items-center justify-center text-xl shadow-sm border border-indigo-100">
                                                <i class="fas {{ $document->file_icon }}"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-800">{{ $document->title }}</div>
                                                <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                                    <span
                                                        class="font-medium text-gray-600">{{ $document->file_size_formatted }}</span>
                                                    @if($document->original_name)
                                                        <span class="text-gray-300">&bull;</span>
                                                        <span class="truncate max-w-xs text-gray-400"
                                                            title="{{ $document->original_name }}">{{ $document->original_name }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span
                                            class="px-3 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200 shadow-sm">
                                            {{ $document->category ?? 'General' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @php
                                            $colors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                'rejected' => 'bg-rose-100 text-rose-800 border-rose-200',
                                                'draft' => 'bg-gray-100 text-gray-800 border-gray-200',
                                            ];
                                            $statusClass = $colors[$document->status] ?? $colors['pending'];
                                        @endphp
                                        <span
                                            class="px-3 py-1 rounded-lg text-xs font-semibold border {{ $statusClass }} capitalize shadow-sm">
                                            {{ $document->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        {{ $document->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                            <!-- View -->
                                            <a href="{{ route('documents.show', $document) }}"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-purple-50 text-purple-500 hover:bg-purple-500 hover:text-white transition-colors"
                                                title="View Details">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('documents.edit', $document) }}"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-500 hover:bg-indigo-500 hover:text-white transition-colors"
                                                title="Edit">
                                                <i class="fas fa-pen text-xs"></i>
                                            </a>

                                            <!-- Download -->
                                            <a href="{{ route('documents.download', $document) }}"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-500 hover:bg-emerald-500 hover:text-white transition-colors"
                                                title="Download">
                                                <i class="fas fa-download text-xs"></i>
                                            </a>

                                            <!-- Archive (Soft Delete) -->
                                            <button type="button" @click="$dispatch('open-delete-modal', { 
                                                                url: '{{ route('documents.destroy', $document) }}', 
                                                                title: 'Archive Document', 
                                                                message: 'Are you sure you want to archive this document? You can restore it later from the archive.' 
                                                            })"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors"
                                                title="Archive">
                                                <i class="fas fa-archive text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection