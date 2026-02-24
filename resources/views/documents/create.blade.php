@extends('layouts.dashboard')

@section('title', 'DocuManage • Upload')

@section('header')
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-indigo-200/60 shadow-sm">
        <div>
            <h2
                class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-indigo-700 to-purple-600 leading-tight">
                <i class="fas fa-cloud-upload-alt mr-2 text-indigo-400"></i> Upload Document
            </h2>
            <p class="text-indigo-500 text-sm mt-1 flex items-center gap-2">
                <i class="fas fa-file-alt text-xs"></i> Add a new document to your repository
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
    <div class="max-w-4xl mx-auto">
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-indigo-200/70 overflow-hidden">
            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" id="uploadForm">
                @csrf

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- LEFT SIDE: Document Details -->
                    <div class="space-y-6">
                        <h3
                            class="text-lg font-semibold text-gray-800 flex items-center gap-2 border-b border-indigo-100 pb-3">
                            <i class="fas fa-info-circle text-indigo-500"></i> Document Details
                        </h3>

                        <!-- Title -->
                        <div class="space-y-2">
                            <label for="title" class="block text-sm font-semibold text-gray-700">Document Title</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-heading text-indigo-400"></i>
                                </div>
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    class="block w-full pl-11 pr-4 py-3 bg-indigo-50/50 border border-indigo-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all @error('title') border-rose-300 ring-rose-300 @enderror"
                                    placeholder="e.g. Q4 Financial Report (optional)">
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
                                    <option value="">Select a category...</option>
                                    <option value="Contract" {{ old('category') == 'Contract' ? 'selected' : '' }}>Contract
                                    </option>
                                    <option value="Invoice" {{ old('category') == 'Invoice' ? 'selected' : '' }}>Invoice
                                    </option>
                                    <option value="Report" {{ old('category') == 'Report' ? 'selected' : '' }}>Report</option>
                                    <option value="Design" {{ old('category') == 'Design' ? 'selected' : '' }}>Design</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            @error('category')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700">Initial Status</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-flag text-indigo-400"></i>
                                </div>
                                <select name="status" id="status"
                                    class="block w-full pl-11 pr-4 py-3 bg-indigo-50/50 border border-indigo-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all appearance-none @error('status') border-rose-300 ring-rose-300 @enderror">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved
                                    </option>
                                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                    </option>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                            @error('status')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- RIGHT SIDE: File Upload -->
                    <div class="space-y-6">
                        <h3
                            class="text-lg font-semibold text-gray-800 flex items-center gap-2 border-b border-indigo-100 pb-3">
                            <i class="fas fa-file-upload text-indigo-500"></i> File Upload
                        </h3>

                        <div id="dropzone"
                            class="border-2 border-dashed border-indigo-300 rounded-2xl p-8 text-center cursor-pointer transition-all hover:border-indigo-500 hover:bg-indigo-50/50 bg-white group">
                            <div
                                class="text-6xl text-indigo-200 group-hover:text-indigo-400 transition-colors mb-4 group-hover:scale-110 transform duration-300">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <p class="text-sm text-gray-600 font-medium">
                                <span class="text-indigo-600 font-bold">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-400 mt-2">
                                PDF, DOCX, XLSX, PNG, JPG (max. 10MB)
                            </p>
                            <div id="fileName"
                                class="mt-4 text-sm font-bold text-indigo-700 hidden py-2 px-4 bg-indigo-100 rounded-xl">
                            </div>

                            <input type="file" name="document" id="fileInput" class="hidden"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg,.txt,.zip" required>
                        </div>
                        @error('document')
                            <p class="text-rose-500 text-xs mt-1 text-center font-medium"><i
                                    class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-8 py-5 border-t border-indigo-100 bg-gray-50/80 flex justify-end items-center gap-4">
                    <p class="text-xs text-indigo-400 hidden sm:block animate-pulse">
                        <i class="far fa-magic"></i> Ready for production
                    </p>
                    <button type="submit"
                        class="group flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 font-semibold">
                        <i class="fas fa-upload group-hover:-translate-y-1 transition-transform"></i>
                        Upload Document
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            const dropzone = document.getElementById('dropzone');
            const fileInput = document.getElementById('fileInput');
            const fileName = document.getElementById('fileName');

            if (!dropzone || !fileInput || !fileName) return;

            dropzone.addEventListener('click', () => fileInput.click());

            fileInput.addEventListener('change', () => {
                if (fileInput.files.length > 0) {
                    fileName.textContent = '📄 ' + fileInput.files[0].name;
                    fileName.classList.remove('hidden');
                } else {
                    fileName.classList.add('hidden');
                }
            });

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, () => {
                    dropzone.classList.add('border-indigo-500', 'bg-indigo-50');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, () => {
                    dropzone.classList.remove('border-indigo-500', 'bg-indigo-50');
                }, false);
            });

            dropzone.addEventListener('drop', (e) => {
                let dt = e.dataTransfer;
                let files = dt.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    fileInput.dispatchEvent(new Event('change'));
                }
            }, false);

            // Client side validation just before submit
            document.getElementById('uploadForm').addEventListener('submit', function (e) {
                if (!fileInput.files || fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Please select a file to upload.');
                }
            });
        });
    </script>
@endsection