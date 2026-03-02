@extends('layouts.admin')

@section('header')
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="font-black text-3xl text-indigo-900 flex items-center gap-3">
                <div class="p-3 bg-indigo-100 rounded-2xl shadow-inner">
                    <i class="fas fa-users-cog text-indigo-600"></i>
                </div>
                User Access Control
            </h2>
            <p class="text-indigo-400 font-medium mt-1 ml-16 flex items-center gap-2">
                <i class="fas fa-shield-alt text-xs"></i>
                Manage user roles and granular permissions
            </p>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-sm flex items-center gap-3 animate-fade-in">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl shadow-indigo-100/50 border border-indigo-50 overflow-hidden">
            <div class="p-8">
                <div class="overflow-x-auto rounded-2xl border border-indigo-50">
                    <table class="min-w-full divide-y divide-indigo-50">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-6 py-5 text-left text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">User</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">Role</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">Active Permissions</th>
                                <th class="px-6 py-5 text-right text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-indigo-50">
                            @foreach($users as $user)
                                <tr class="hover:bg-indigo-50/30 transition-colors group">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 font-black">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-black text-gray-900 text-sm">{{ $user->name }}</span>
                                                <span class="text-xs text-indigo-400 font-medium">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($user->is_admin)
                                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-[10px] font-black uppercase tracking-wider border border-purple-200">
                                                Administrator
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-wider border border-slate-200">
                                                Standard User
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($user->is_admin)
                                            <span class="text-xs font-bold text-gray-400 italic">Global Access (Full)</span>
                                        @else
                                            <div class="flex flex-wrap gap-1 max-w-xs">
                                                @forelse($user->permissions ?? [] as $perm)
                                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[9px] font-bold border border-indigo-100">
                                                        {{ $perm }}
                                                    </span>
                                                @empty
                                                    <span class="text-xs text-slate-300">No specific permissions</span>
                                                @endforelse
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        @if(Auth::user()->is_admin || Auth::user()->hasPermission('users.assign_roles'))
                                            <a href="{{ route('admin.users.roles.edit', $user) }}" 
                                                class="inline-flex items-center gap-2 px-5 py-2 bg-slate-900 text-white rounded-xl font-black text-xs hover:bg-black transition-all shadow-sm active:scale-95">
                                                <i class="fas fa-key text-[10px] text-indigo-300"></i> Edit Role
                                            </a>
                                        @else
                                            <span class="text-[10px] text-slate-300 font-black uppercase tracking-widest italic">Restricted</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
