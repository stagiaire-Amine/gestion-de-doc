@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="font-black text-3xl text-indigo-900 flex items-center gap-3">
                <div class="p-3 bg-indigo-100 rounded-2xl shadow-inner">
                    <i class="fas fa-id-badge text-indigo-600"></i>
                </div>
                {{ $client->name }}
            </h2>
            <p class="text-indigo-400 font-medium mt-1 ml-16 flex items-center gap-2">
                <i class="fas fa-briefcase text-xs"></i>
                Client Dashboard & Document Manager
            </p>
        </div>

        <div class="flex items-center gap-3">
            @if(Auth::user()->is_admin || Auth::user()->hasPermission('documents.create'))
                <a href="{{ route('documents.create') }}"
                    class="group flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg shadow-indigo-200 hover:-translate-y-0.5 font-bold">
                    <i class="fas fa-cloud-upload-alt group-hover:scale-110 transition-transform text-indigo-100"></i>
                    <span>Upload Document</span>
                </a>
            @endif
            <a href="{{ route('clients.index') }}"
                class="group flex items-center gap-2 px-5 py-2.5 bg-white text-gray-600 rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-sm border border-gray-200 font-bold">
                <i class="fas fa-chevron-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Process Messages -->
            <div class="col-span-1 lg:col-span-3">
                @if(session('success'))
                    <div
                        class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-sm flex items-center gap-3 mb-6">
                        <i class="fas fa-check-circle text-xl"></i>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-xl shadow-sm mb-6">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-exclamation-triangle text-xl"></i>
                            <span class="font-black">Submission Error</span>
                        </div>
                        <ul class="list-disc pl-10 font-bold text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Left Side: Client profile -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl shadow-xl shadow-indigo-100/50 border border-indigo-50 p-8">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2 mb-6">
                        <i class="fas fa-user-circle text-indigo-500"></i> Profile Info
                    </h3>

                    <div class="space-y-5">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <span class="block text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">Full
                                Name</span>
                            <span class="font-black text-slate-800 text-lg">{{ $client->name }}</span>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between">
                            <div>
                                <span
                                    class="block text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">CIN
                                    / Identity</span>
                                <span class="font-bold text-slate-700">{{ $client->cin ?? 'Not provided' }}</span>
                            </div>
                            <i class="fas fa-id-card text-indigo-100 text-3xl"></i>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <span
                                class="block text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">Contact
                                Details</span>
                            <div class="space-y-2 mt-2">
                                <div class="flex items-center gap-3 text-sm font-bold text-slate-600">
                                    <i class="fas fa-envelope text-indigo-400 w-4"></i>
                                    {{ $client->email ?? 'No email' }}
                                </div>
                                <div class="flex items-center gap-3 text-sm font-bold text-slate-600">
                                    <i class="fas fa-phone text-indigo-400 w-4"></i>
                                    {{ $client->phone ?? 'No phone' }}
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <span
                                class="block text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">Address</span>
                            <p class="text-sm font-bold text-slate-600 mt-1 italic">
                                {{ $client->address ?? 'No address provided' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tools/Actions -->
                <div class="bg-slate-900 rounded-3xl shadow-2xl p-8 space-y-6 text-white overflow-hidden relative">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
                    </div>
                    <h3
                        class="text-sm font-black text-indigo-300 uppercase tracking-widest flex items-center gap-2 relative">
                        <i class="fas fa-tools"></i> Tools
                    </h3>
                    <div class="grid grid-cols-1 gap-3 relative">
                        <button
                            class="w-full h-12 flex items-center justify-center gap-3 bg-white/10 hover:bg-white/20 text-white rounded-2xl font-black transition-all border border-white/10 active:scale-95 disabled:opacity-50"
                            disabled>
                            <i class="fas fa-edit"></i> Edit Records
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Side: Document Management -->
            <div class="lg:col-span-2 space-y-8">
                @if(Auth::user()->is_admin || Auth::user()->hasPermission('documents.create'))
                    <!-- Upload Form -->
                    <div class="bg-white rounded-3xl shadow-xl shadow-indigo-100/50 border border-indigo-50 p-8">
                        <h3
                            class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2 mb-8 border-b border-slate-50 pb-4">
                            <i class="fas fa-cloud-upload-alt text-indigo-500"></i> Upload New Document
                        </h3>

                        <form action="{{ route('documents.store_for_client', $client) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-indigo-400 uppercase tracking-widest ml-1">Document
                                        Type *</label>
                                    <div class="relative group">
                                        <i
                                            class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-indigo-200 group-focus-within:text-indigo-500 transition-colors"></i>
                                        <input type="text" name="type" required placeholder="e.g. Identity, Contract, Tax Form"
                                            class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-gray-700 placeholder:text-gray-300">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-indigo-400 uppercase tracking-widest ml-1">Expiration
                                        Date (Optional)</label>
                                    <div class="relative group">
                                        <i
                                            class="fas fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-indigo-200 group-focus-within:text-indigo-500 transition-colors"></i>
                                        <input type="date" name="expires_at"
                                            class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-gray-700">
                                    </div>
                                </div>
                                <div class="md:col-span-2 space-y-2">
                                    <label class="text-[10px] font-black text-indigo-400 uppercase tracking-widest ml-1">Select
                                        File (PDF, JPG, PNG - Max 10MB)</label>
                                    <div class="relative group">
                                        <input type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png"
                                            class="w-full px-4 py-8 border-2 border-dashed border-indigo-100 rounded-3xl hover:border-indigo-400 hover:bg-indigo-50/30 transition-all cursor-pointer text-center font-bold text-indigo-600 file:hidden">
                                        <div class="absolute inset-x-0 bottom-4 text-center pointer-events-none">
                                            <p class="text-[10px] text-indigo-300 uppercase font-black">Click here to browse
                                                files</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end pt-4">
                                <button type="submit"
                                    class="px-12 py-4 bg-slate-900 text-white rounded-2xl font-black hover:bg-black transition-all active:scale-95 shadow-xl">
                                    Start Upload
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
                Riverside

                <!-- Documents List -->
                <div class="bg-white rounded-3xl shadow-xl shadow-indigo-100/50 border border-indigo-50 overflow-hidden">
                    <div class="p-8 border-b border-indigo-50 flex justify-between items-center bg-slate-50/50">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-folder-open text-indigo-500"></i> Client Documents ({{ $documents->count() }})
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-indigo-50">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-5 text-left text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">
                                        Doc Type</th>
                                    <th
                                        class="px-6 py-5 text-left text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">
                                        File Info</th>
                                    <th
                                        class="px-6 py-5 text-left text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">
                                        Expiry</th>
                                    <th
                                        class="px-6 py-5 text-right text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-indigo-50 bg-white">
                                @forelse($documents as $doc)
                                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="h-9 w-9 bg-indigo-50 rounded-xl flex items-center justify-center">
                                                    <i class="fas {{ $doc->file_icon ?? 'fa-file' }} text-indigo-500"></i>
                                                </div>
                                                <span class="font-black text-slate-700 text-sm">{{ $doc->type }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex flex-col gap-0.5 max-w-[200px]">
                                                <span class="font-bold text-gray-600 text-xs truncate"
                                                    title="{{ $doc->original_name }}">{{ $doc->original_name }}</span>
                                                <span
                                                    class="text-[10px] text-indigo-400 font-medium tracking-wider">{{ $doc->file_size_formatted }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            @if($doc->expires_at)
                                                <span
                                                    class="text-xs font-black {{ $doc->expires_at->isPast() ? 'text-rose-500' : 'text-slate-500' }}">
                                                    {{ $doc->expires_at->format('M d, Y') }}
                                                </span>
                                            @else
                                                <span class="text-xs font-black text-gray-300">No date</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 text-right space-x-3">
                                            <a href="{{ Storage::url($doc->path) }}" target="_blank"
                                                class="text-indigo-600 hover:text-indigo-900 font-black text-xs uppercase tracking-widest hover:underline decoration-2 underline-offset-4 transition-all">
                                                View
                                            </a>
                                            @if(Auth::user()->hasPermission('documents.delete'))
                                                <form action="{{ route('documents.destroy_client_doc', $doc) }}" method="POST"
                                                    class="inline-block"
                                                    onsubmit="return confirm('DANGER: Delete this document permanently?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-rose-400 hover:text-rose-600 font-black text-xs uppercase tracking-widest transition-all">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center gap-3 text-gray-300">
                                                <i class="fas fa-file-invoice text-5xl"></i>
                                                <p class="font-black uppercase tracking-widest text-xs">No documents uploaded
                                                    yet</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
@endsection