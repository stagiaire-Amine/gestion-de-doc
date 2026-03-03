@extends('layouts.dashboard')

@section('title', 'DocuManage • Archive')

@section('header')
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-rose-200/60 shadow-sm">
        <div>
            <h2
                class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-rose-700 to-orange-600 leading-tight">
                <i class="fas fa-archive mr-2 text-rose-400"></i> Archived Documents
            </h2>
            <p class="text-rose-500 text-sm mt-1 flex items-center gap-2">
                <i class="fas fa-info-circle text-xs"></i> View or restore your deleted files
            </p>
        </div>

        <a href="{{ route('documents.index') }}"
            class="group flex items-center gap-2 px-6 py-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition-all duration-300 shadow-sm border border-rose-200 font-semibold">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition"></i>
            <span>Back to Active Documents</span>
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

        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-rose-200/50 overflow-hidden">
            @if($documents->isEmpty())
                <div class="p-16 text-center">
                    <div
                        class="mx-auto h-24 w-24 bg-rose-50 border border-rose-100 rounded-full flex items-center justify-center mb-5 shadow-inner">
                        <i class="fas fa-box-open text-4xl text-rose-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Archive is empty</h3>
                    <p class="mt-2 text-gray-500">You haven't archived any documents yet.</p>
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
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Deleted
                                    At</th>
                                <th scope="col"
                                    class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($documents as $document)
                                <tr class="hover:bg-rose-50/30 transition-colors group">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-xl flex items-center justify-center text-xl shadow-sm border border-gray-200 filter grayscale">
                                                <i class="fas {{ $document->file_icon }}"></i>
                                            </div>
                                            <div class="ml-4 opacity-75">
                                                <div class="text-sm font-bold text-gray-800 line-through">{{ $document->title }}
                                                </div>
                                                <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                                    <span
                                                        class="font-medium text-gray-600">{{ $document->file_size_formatted }}</span>
                                                    <span class="text-gray-300">&bull;</span>
                                                    <span
                                                        class="truncate max-w-xs text-gray-400 capitalize">{{ $document->status }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        {{ $document->deleted_at->format('M d, Y h:i A') }}
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                            <!-- Download -->
                                            <a href="{{ route('documents.archived.download', $document->id) }}"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 text-gray-500 hover:bg-gray-500 hover:text-white transition-colors"
                                                title="Download">
                                                <i class="fas fa-download text-xs"></i>
                                            </a>

                                            <!-- Restore -->
                                            <button type="button" @click="$dispatch('open-delete-modal', { 
                                                                url: '{{ route('documents.archived.restore', $document->id) }}', 
                                                                title: 'Restore Document', 
                                                                message: 'Restore this document to active display?',
                                                                method: 'POST'
                                                            })"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-500 hover:bg-emerald-500 hover:text-white transition-colors"
                                                title="Restore">
                                                <i class="fas fa-trash-restore text-xs"></i>
                                            </button>

                                            <!-- Force Delete -->
                                            <button type="button" @click="$dispatch('open-delete-modal', { 
                                                                url: '{{ route('documents.archived.forceDelete', $document->id) }}', 
                                                                title: 'Permanent Delete', 
                                                                message: 'PERMANENTLY delete this document? This cannot be undone.',
                                                                method: 'DELETE'
                                                            })"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors"
                                                title="Permanent Delete">
                                                <i class="fas fa-times text-xs"></i>
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