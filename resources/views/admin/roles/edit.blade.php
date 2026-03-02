@extends('layouts.admin')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.roles.index') }}"
            class="p-3 bg-white border border-indigo-100 text-indigo-600 rounded-2xl hover:bg-indigo-50 transition-all shadow-sm">
            <i class="fas fa-chevron-left"></i>
        </a>

        <div>
            <h2 class="font-black text-3xl text-indigo-900 flex items-center gap-3">
                <i class="fas fa-user-shield text-indigo-400"></i>
                Roles & Permissions
            </h2>
            <p class="text-indigo-400 font-medium font-bold">
                Configuring access for
                <span class="text-indigo-800">{{ $user->name }}</span>
            </p>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <form method="POST" action="{{ route('admin.users.roles.update', $user) }}"
            x-data="{
                role: '{{ $user->is_admin ? 'admin' : 'user' }}',
                pulse: false,
                setRole(v){
                    this.role = v;
                    this.pulse = true;
                    setTimeout(() => this.pulse = false, 350);
                },
                checkAll(){
                    document.querySelectorAll('input[name=&quot;permissions[]&quot;]').forEach(el => el.checked = true);
                },
                uncheckAll(){
                    document.querySelectorAll('input[name=&quot;permissions[]&quot;]').forEach(el => el.checked = false);
                }
            }">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Role Selection -->
                <div class="space-y-6">
                    <div class="bg-slate-900 rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
                        </div>

                        <h3
                            class="text-sm font-black text-indigo-300 uppercase tracking-widest flex items-center gap-2 mb-6 relative">
                            <i class="fas fa-user-tag"></i> Account Role
                        </h3>

                        <!-- Status badge -->
                        <div class="flex items-center justify-between mb-5">
                            <div class="text-[11px] font-black tracking-widest uppercase text-white/60">
                                Mode
                            </div>

                            <div class="px-3 py-1 rounded-full text-[11px] font-black border"
                                :class="role === 'admin'
                                    ? 'bg-purple-500/15 text-purple-200 border-purple-400/30'
                                    : 'bg-indigo-500/15 text-indigo-200 border-indigo-400/30'"
                                x-transition.opacity>
                                <span x-text="role === 'admin' ? 'ADMIN (Bypass)' : 'USER (Restricted)'"></span>
                            </div>
                        </div>

                        <div class="space-y-4 relative">

                            <!-- USER -->
                            <label class="block cursor-pointer">
                                <input type="radio" name="is_admin" value="0" class="hidden"
                                    @change="setRole('user')" :checked="role === 'user'"
                                    {{ !$user->is_admin ? 'checked' : '' }}>

                                <div class="flex items-center gap-4 p-4 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 transition-all duration-300"
                                    :class="role === 'user' ? 'ring-2 ring-indigo-400/60 bg-white/10' : ''">
                                    <div class="h-10 w-10 rounded-xl bg-slate-800 flex items-center justify-center transition-all duration-300"
                                        :class="role === 'user' ? 'text-indigo-300 scale-[1.03]' : 'text-slate-400'">
                                        <i class="fas fa-user"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-black text-sm">Standard User</p>
                                        <p class="text-[10px] text-white/40">Permissions can be toggled</p>
                                    </div>

                                    <div class="ml-auto flex items-center gap-2">
                                        <span class="px-2 py-1 rounded-full text-[10px] font-black border transition-all"
                                            :class="role === 'user'
                                                ? 'bg-indigo-500/15 text-indigo-200 border-indigo-400/30'
                                                : 'bg-white/5 text-white/40 border-white/10'">
                                            Activer
                                        </span>
                                    </div>
                                </div>
                            </label>

                            <!-- ADMIN -->
                            <label class="block cursor-pointer">
                                <input type="radio" name="is_admin" value="1" class="hidden"
                                    @change="setRole('admin')" :checked="role === 'admin'"
                                    {{ $user->is_admin ? 'checked' : '' }}>

                                <div class="flex items-center gap-4 p-4 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 transition-all duration-300"
                                    :class="role === 'admin' ? 'ring-2 ring-purple-400/60 bg-white/10' : ''">
                                    <div class="h-10 w-10 rounded-xl bg-slate-800 flex items-center justify-center transition-all duration-300"
                                        :class="role === 'admin' ? 'text-purple-300 scale-[1.03]' : 'text-slate-400'">
                                        <i class="fas fa-crown"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-black text-sm text-white">Administrator</p>
                                        <p class="text-[10px] text-white/40">Bypasses granular restrictions</p>
                                    </div>

                                    <div class="ml-auto flex items-center gap-2">
                                        <span class="px-2 py-1 rounded-full text-[10px] font-black border transition-all"
                                            :class="role === 'admin'
                                                ? 'bg-purple-500/15 text-purple-200 border-purple-400/30'
                                                : 'bg-white/5 text-white/40 border-white/10'">
                                            Activer
                                        </span>
                                    </div>
                                </div>
                            </label>

                            <!-- Animated note -->
                            <div x-show="role === 'admin'"
                                x-transition:enter="transition ease-out duration-250"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-2"
                                class="mt-4 p-4 bg-purple-500/10 rounded-xl border border-purple-500/30 text-[11px] font-bold text-purple-200">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Admin users automatically bypass all granular permissions (right panel will be disabled).
                            </div>

                            <!-- Small “pulse” feedback -->
                            <div x-show="pulse" x-transition.opacity.duration.200ms
                                class="absolute -bottom-2 left-0 right-0 h-1 rounded-full"
                                :class="role === 'admin' ? 'bg-purple-400/60' : 'bg-indigo-400/60'"></div>
                        </div>
                    </div>

                    <div class="p-8">
                        <button type="submit"
                            class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black hover:bg-indigo-700 transition-all active:scale-95 shadow-xl shadow-indigo-200/50 flex items-center justify-center gap-3">
                            <i class="fas fa-save shadow-sm"></i>
                            Save Settings
                        </button>
                    </div>
                </div>

                <!-- Granular Permissions -->
                <div class="md:col-span-2 space-y-8">
                    <div
                        class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl shadow-indigo-100/50 border border-indigo-50 overflow-hidden">

                        <div class="p-8 border-b border-indigo-50 bg-slate-50/50">
                            <div class="flex items-center justify-between gap-4">
                                <h3
                                    class="text-xs font-black text-indigo-900 uppercase tracking-widest flex items-center gap-3">
                                    <div class="p-2 bg-white rounded-lg shadow-sm border border-indigo-100">
                                        <i class="fas fa-fingerprint text-indigo-500"></i>
                                    </div>
                                    Granular Access Permissions
                                </h3>

                                <!-- Activer / Désactiver All (only when USER) -->
                                <div class="flex items-center gap-2" x-show="role === 'user'" x-transition.opacity>
                                    <button type="button"
                                        class="px-3 py-2 rounded-xl text-[11px] font-black bg-indigo-600 text-white hover:bg-indigo-700 transition active:scale-95"
                                        @click="checkAll()">
                                        Activer tout
                                    </button>

                                    <button type="button"
                                        class="px-3 py-2 rounded-xl text-[11px] font-black bg-slate-900 text-white hover:bg-slate-800 transition active:scale-95"
                                        @click="uncheckAll()">
                                        Désactiver tout
                                    </button>
                                </div>
                            </div>

                            <!-- Disabled note (only when ADMIN) -->
                            <div class="mt-4" x-show="role === 'admin'"
                                x-transition:enter="transition ease-out duration-250"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-2">
                                <div
                                    class="p-4 rounded-2xl border border-purple-200 bg-purple-50 text-purple-700 text-xs font-bold flex items-start gap-3">
                                    <i class="fas fa-lock mt-0.5"></i>
                                    <div>
                                        Permissions are disabled because this user is set as <span class="font-black">Admin</span>.
                                        Switch to <span class="font-black">Standard User</span> to activate / deactivate permissions.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-10">
                            @foreach($permissionsByGroup as $group => $perms)
                                <div class="space-y-4">
                                    <h4
                                        class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] flex items-center gap-2 mb-2">
                                        <span class="w-2 h-2 bg-indigo-100 rounded-full"></span>
                                        {{ $group }}
                                    </h4>

                                    <div class="space-y-3">
                                        @foreach($perms as $key => $label)
                                            <label
                                                class="flex items-center gap-3 p-3 rounded-xl border border-transparent hover:bg-indigo-50/60 hover:border-indigo-100 cursor-pointer transition-all duration-300 group hover:-translate-y-[1px] hover:shadow-sm">

                                                <div class="relative flex items-center">
                                                    <input type="checkbox" name="permissions[]" value="{{ $key }}"
                                                        class="w-5 h-5 rounded border-indigo-100 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed"
                                                        :disabled="role === 'admin'"
                                                        {{ (is_array($user->permissions) && in_array($key, $user->permissions)) ? 'checked' : '' }}>
                                                </div>

                                                <span
                                                    class="text-sm font-bold text-gray-700 group-hover:text-indigo-700 transition-colors">
                                                    {{ $label }}
                                                </span>

                                                <!-- small indicator -->
                                                <span class="ml-auto text-[10px] font-black px-2 py-1 rounded-full border"
                                                    :class="role === 'admin'
                                                        ? 'bg-slate-100 text-slate-400 border-slate-200'
                                                        : 'bg-indigo-50 text-indigo-600 border-indigo-100'">
                                                    <span x-text="role === 'admin' ? 'Désactivé' : 'Actif'"></span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="px-8 py-6 bg-slate-50 border-t border-indigo-50 flex items-center gap-4">
                            <i class="fas fa-info-circle text-indigo-300"></i>
                            <p class="text-xs text-indigo-400 font-bold">
                                Use these toggles to restrict non-admin users to specific parts of the system.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection