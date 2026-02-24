@extends('layouts.dashboard')

@section('title', 'DocuManage • Edit User')

@section('header')
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-purple-200/60 shadow-sm">
        <div>
            <h2
                class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-purple-700 to-indigo-600 leading-tight">
                <i class="fas fa-user-edit mr-2 text-purple-400"></i> Edit User
            </h2>
            <p class="text-purple-500 text-sm mt-1 flex items-center gap-2">
                <i class="fas fa-info-circle text-xs text-purple-400"></i> Modifying details for {{ $user->name }}
            </p>
        </div>

        <a href="{{ route('admin.users.index') }}"
            class="group flex items-center gap-2 px-6 py-2.5 bg-gray-50 text-gray-600 rounded-xl hover:bg-gray-100 transition-all duration-300 shadow-sm border border-gray-200 font-semibold">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition"></i>
            <span>Back to Users</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show"
                class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm relative mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-rose-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-rose-800">There were {{ $errors->count() }} errors with your
                            submission</h3>
                        <div class="mt-2 text-sm text-rose-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <button @click="show = false" class="absolute top-4 right-4 text-rose-400 hover:text-rose-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-purple-200/70 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name (Optional edit) -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-bold text-gray-700">Full Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-id-card text-purple-300"></i>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                    class="pl-10 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm py-2.5 bg-gray-50"
                                    placeholder="Optional...">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-bold text-gray-700">Email Address <span
                                    class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-purple-300"></i>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                    required
                                    class="pl-10 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm py-2.5 bg-gray-50">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-purple-100">
                        <!-- Role Selection -->
                        <div class="space-y-2">
                            <label for="role" class="block text-sm font-bold text-gray-700">Account Role <span
                                    class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-shield text-purple-300"></i>
                                </div>
                                <select name="role" id="role"
                                    class="pl-10 block w-full rounded-xl border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm py-2.5 bg-gray-50 appearance-none font-medium">
                                    <option value="user" {{ old('role', $user->is_admin ? 'admin' : 'user') === 'user' ? 'selected' : '' }}>Standard User</option>
                                    <option value="admin" {{ old('role', $user->is_admin ? 'admin' : 'user') === 'admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Administrators have global access to all settings.</p>
                        </div>

                        <!-- Active Toggle -->
                        <div class="space-y-3">
                            <label class="block text-sm font-bold text-gray-700">Account Status</label>
                            <label class="relative inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                <div
                                    class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500 shadow-inner">
                                </div>
                                <span
                                    class="ml-3 text-sm font-medium text-gray-700 peer-checked:text-emerald-600">Active</span>
                            </label>
                            <p class="text-xs text-gray-500">Disabled users cannot log into the platform.</p>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-purple-100 flex justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}"
                            class="px-6 py-2.5 text-gray-600 bg-gray-100 hover:bg-gray-200 font-semibold rounded-xl transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 font-semibold rounded-xl shadow-lg shadow-purple-200 transition-all hover:-translate-y-0.5 group flex items-center gap-2">
                            <span>Save Changes</span> <i class="fas fa-check group-hover:scale-110 transition"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection