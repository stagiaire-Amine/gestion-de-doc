@extends('layouts.dashboard')

@section('title', 'DocuManage • New Ticket')

@section('header')
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-violet-200/60 shadow-sm">
        <div>
            <h2
                class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-violet-700 to-fuchsia-600 leading-tight">
                <i class="fas fa-plus-circle mr-2 text-violet-400"></i> New Ticket
            </h2>
            <p class="text-violet-500 text-sm mt-1 flex items-center gap-2">
                <i class="fas fa-edit text-xs"></i> Submit a new support request
            </p>
        </div>

        <a href="{{ route('reclamations.index') }}"
            class="group flex items-center gap-2 px-5 py-2 bg-violet-50 text-violet-600 rounded-xl hover:bg-violet-100 transition-all duration-300 shadow-sm border border-violet-200">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition"></i>
            <span class="font-medium text-sm">Cancel</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-violet-200/70 overflow-hidden">
            <form method="POST" action="{{ route('reclamations.store') }}" class="p-8 space-y-8">
                @csrf

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2 border-b border-violet-100 pb-3">
                        <i class="fas fa-info-circle text-violet-500"></i> Ticket Information
                    </h3>
                </div>

                <!-- Subject -->
                <div class="space-y-2">
                    <label for="subject" class="block text-sm font-semibold text-gray-700">Subject</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-heading text-violet-400"></i>
                        </div>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                            class="block w-full pl-11 pr-4 py-3 bg-violet-50/50 border border-violet-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-violet-400 focus:border-violet-400 transition-all @error('subject') border-rose-300 ring-rose-300 @enderror"
                            placeholder="Brief description of the issue" required autofocus>
                    </div>
                    @error('subject')
                        <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>
                            {{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div class="space-y-2">
                    <label for="priority" class="block text-sm font-semibold text-gray-700">Priority Level</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-flag text-violet-400"></i>
                        </div>
                        <select name="priority" id="priority"
                            class="block w-full pl-11 pr-4 py-3 bg-violet-50/50 border border-violet-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-violet-400 focus:border-violet-400 transition-all appearance-none @error('priority') border-rose-300 ring-rose-300 @enderror"
                            required>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low - Non-critical question
                                or issue</option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium -
                                Standard support request</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High - Urgent issue
                                blocking work</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-violet-400 text-sm"></i>
                        </div>
                    </div>
                    @error('priority')
                        <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>
                            {{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div class="space-y-2">
                    <label for="message" class="block text-sm font-semibold text-gray-700">Detailed Message</label>
                    <textarea name="message" id="message" rows="6"
                        class="block w-full p-4 bg-violet-50/50 border border-violet-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-violet-400 focus:border-violet-400 transition-all @error('message') border-rose-300 ring-rose-300 @enderror"
                        placeholder="Please provide as much detail as possible about your reclamation..."
                        required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>
                            {{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 border-t border-violet-100 flex justify-end">
                    <button type="submit"
                        class="group flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-white rounded-xl hover:from-violet-700 hover:to-fuchsia-600 transition-all duration-300 shadow-lg shadow-violet-200 hover:shadow-xl hover:-translate-y-0.5 font-semibold">
                        <i
                            class="fas fa-paper-plane group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                        Submit Ticket
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection