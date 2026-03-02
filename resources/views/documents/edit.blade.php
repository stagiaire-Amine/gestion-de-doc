@extends('layouts.app')

@section('header')
    <div
        class="flex justify-between items-center bg-white/70 backdrop-blur-sm -m-6 p-6 mb-6 border-b border-indigo-200/60 rounded-t-2xl shadow-sm">
        <div>
            <h2
                class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-indigo-700 to-purple-600 leading-tight">
                <i class="fas fa-edit mr-2 text-indigo-400"></i> Edit Document
            </h2>
            <p class="text-indigo-500 text-sm mt-1 flex items-center gap-2">
                <i class="fas fa-file-alt text-xs"></i> Update metadata for: {{ $document->original_name }}
            </p>
        </div>

        <a href="{{ route('documents.index') }}"
            class="group flex items-center gap-2 px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-all duration-300 shadow-sm border border-indigo-200">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition"></i>
            <span class="font-medium text-sm">Cancel</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="py-6 max-w-2xl mx-auto">
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-indigo-200/70 overflow-hidden">
            <form method="POST" action="{{ route('documents.update', $document) }}">
                @csrf
                @method('PUT')

                <div class="p-8 space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2 border-b border-indigo-100 pb-3">
                        <i class="fas fa-info-circle text-indigo-500"></i> Document Details
                    </h3>

                    <!-- Title -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-semibold text-gray-700">Document Title</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-heading text-indigo-400"></i>
                            </div>
                            <input type="text" name="title" id="title" value="{{ old('title', $document->title) }}"
                                class="block w-full pl-11 pr-4 py-3 bg-indigo-50/50 border border-indigo-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all @error('title') border-rose-300 ring-rose-300 @enderror"
                                required>
                        </div>
                        @error('title')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="space-y-2">
                        <label for="category" class="block text-sm font-semibold text-gray-700">Category</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-indigo-400"></i>
                            </div>
                            <select name="category" id="category"
                                class="block w-full pl-11 pr-4 py-3 bg-indigo-50/50 border border-indigo-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all appearance-none @error('category') border-rose-300 ring-rose-300 @enderror">
                                <option value="">No Category</option>
                                <option value="Contract" {{ old('category', $document->category) == 'Contract' ? 'selected' : '' }}>Contract</option>
                                <option value="Invoice" {{ old('category', $document->category) == 'Invoice' ? 'selected' : '' }}>Invoice</option>
                                <option value="Report" {{ old('category', $document->category) == 'Report' ? 'selected' : '' }}>Report</option>
                                <option value="Design" {{ old('category', $document->category) == 'Design' ? 'selected' : '' }}>Design</option>
                                <option value="Other" {{ old('category', $document->category) == 'Other' ? 'selected' : '' }}>
                                    Other</option>
                            </select>
                        </div>
                        @error('category')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-semibold text-gray-700">Status</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-flag text-indigo-400"></i>
                            </div>
                            <select name="status" id="status"
                                class="block w-full pl-11 pr-4 py-3 bg-indigo-50/50 border border-indigo-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all appearance-none @error('status') border-rose-300 ring-rose-300 @enderror">
                                <option value="pending" {{ old('status', $document->status) == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="approved" {{ old('status', $document->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status', $document->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="draft" {{ old('status', $document->status) == 'draft' ? 'selected' : '' }}>
                                    Draft</option>
                            </select>
                        </div>
                        @error('status')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-8 py-5 border-t border-indigo-100 bg-gray-50/80 flex justify-end items-center gap-4">
                    <button type="submit"
                        class="group flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 font-semibold">
                        <i class="fas fa-check group-hover:scale-110 transition-transform"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection