@extends('layouts.dashboard')

@section('title', 'DocuManage • Profile')

@section('header')
    <div class="flex justify-between items-center bg-gray-50/50 -m-6 p-6 mb-6 border-b border-gray-100">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">My Profile</h2>
            <p class="text-gray-500 text-sm mt-1">Manage your account settings and security</p>
        </div>

        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 shadow-sm">
            <span class="text-sm font-medium">Close</span>
            <i class="fas fa-times text-gray-400"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- PROFILE INFORMATION --}}
        <div class="bg-white rounded-2xl shadow-lg border-t-4 border-indigo-500 p-6 sm:p-8">
            <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                <i class="fas fa-user text-indigo-500"></i>
                Profile Information
            </h3>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6 max-w-xl">
                @csrf
                @method('patch')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold shadow hover:bg-indigo-500">
                    <i class="fas fa-save"></i>
                    Update Profile
                </button>
            </form>
        </div>

        {{-- UPDATE PASSWORD --}}
        <div class="bg-white rounded-2xl shadow-lg border-t-4 border-pink-500 p-6 sm:p-8">
            <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                <i class="fas fa-lock text-pink-500"></i>
                Update Password
            </h3>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6 max-w-xl">
                @csrf
                @method('put')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                    <input type="password" name="current_password"
                        class="w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-2.5">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" name="password" class="w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-2.5">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-2.5">
                </div>

                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-pink-600 text-white rounded-xl font-semibold shadow hover:bg-pink-500">
                    <i class="fas fa-shield-alt"></i>
                    Update Password
                </button>
            </form>
        </div>

    </div>
    </div>
@endsection