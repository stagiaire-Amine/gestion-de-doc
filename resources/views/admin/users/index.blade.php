@extends('layouts.admin')

@section('title', 'DocuManage • User Management')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-purple-200/60 shadow-sm">
        <div>
            <h2 class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-purple-700 to-indigo-600 leading-tight">
                <i class="fas fa-users-cog mr-2 text-purple-400"></i> Admin Panel
            </h2>
            <p class="text-purple-500 text-sm mt-1 flex items-center gap-2">
                <i class="fas fa-shield-alt text-xs"></i> Manage registered users across the platform
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('clients.create') }}" 
               class="group flex items-center gap-2 px-6 py-2.5 bg-white text-purple-600 border border-purple-200 rounded-xl hover:bg-purple-50 transition-all duration-300 shadow-sm hover:-translate-y-0.5 font-semibold">
                <i class="fas fa-user-plus group-hover:scale-110 transition-transform"></i>
                <span>Add Client</span>
            </a>

            <a href="{{ route('documents.create') }}" 
               class="group flex items-center gap-2 px-6 py-2.5 bg-white text-purple-600 border border-purple-200 rounded-xl hover:bg-purple-50 transition-all duration-300 shadow-sm hover:-translate-y-0.5 font-semibold">
                <i class="fas fa-cloud-upload-alt group-hover:scale-110 transition-transform"></i>
                <span>Upload Document</span>
            </a>

            <a href="{{ route('admin.users.create') }}" 
               class="group flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 shadow-lg shadow-purple-200 hover:-translate-y-0.5 font-semibold">
                <i class="fas fa-plus group-hover:scale-110 transition-transform"></i>
                <span>Register New User</span>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="space-y-6">

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2"
                class="bg-emerald-50/90 backdrop-blur-sm text-emerald-700 px-5 py-4 rounded-xl border border-emerald-200 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-emerald-100 p-1.5 rounded-lg text-emerald-600 mt-1">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <span class="font-medium flex-1 break-words">{!! session('status') !!}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2"
                class="bg-rose-50/90 backdrop-blur-sm text-rose-700 px-5 py-4 rounded-xl border border-rose-200 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-rose-100 p-1.5 rounded-lg text-rose-600">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-700 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-purple-200/70 overflow-hidden">
            <div class="p-6 border-b border-purple-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-users text-purple-500"></i> All Users
                </h3>

                <form action="{{ route('admin.users.index') }}" method="GET" class="w-full sm:w-auto flex items-center gap-2">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-sm"></i>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name or email..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition-shadow">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-purple-50 text-purple-700 font-semibold rounded-xl border border-purple-200 hover:bg-purple-100 transition-colors">
                        Search
                    </button>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.users.index') }}" class="px-3 py-2 text-gray-400 hover:text-gray-600 transition" title="Clear Search">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contact</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Account Role</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Joined Date</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr class="hover:bg-purple-50/30 transition-colors">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-purple-500 to-indigo-500 flex items-center justify-center text-white font-bold shadow-md">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 h-3.5 w-3.5 rounded-full border-2 border-white {{ $user->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}" title="{{ $user->is_active ? 'Active' : 'Inactive' }}"></div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-800">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">ID: #{{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 flex items-center gap-2">
                                        <i class="fas fa-envelope text-gray-400"></i> {{ $user->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($user->is_admin)
                                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 shadow-sm flex items-center w-max gap-1">
                                            <i class="fas fa-crown"></i> Admin
                                        </span>
                                    @else
                                        <span class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200 shadow-sm flex items-center w-max gap-1">
                                            <i class="fas fa-user"></i> User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                                    <div class="flex items-center gap-2">
                                        <i class="far fa-calendar-alt text-gray-400"></i>
                                        {{ $user->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-500 hover:bg-indigo-500 hover:text-white transition-colors" title="Edit User">
                                            <i class="fas fa-pen text-xs"></i>
                                        </a>

                                        @if(auth()->id() !== $user->id)
                                            <button type="button" 
                                                @click="$dispatch('open-delete-modal', { 
                                                    url: '{{ route('admin.users.destroy', $user) }}', 
                                                    title: 'Delete User Account', 
                                                    message: 'Are you sure you want to permanently delete this user account?',
                                                    method: 'DELETE'
                                                })"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors" title="Delete User">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <div class="mx-auto h-16 w-16 bg-gray-50 border border-gray-200 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-search text-gray-400 text-xl"></i>
                                    </div>
                                    No users found matching your search.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- SECURE CREDENTIALS MODAL --}}
    @if(session('created_credentials'))
        <div x-data="credentialsModal(@js(session('created_credentials')))" 
             x-init="initModal()"
             x-cloak
             x-show="isOpen"
             class="relative z-[150]" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <!-- Blurred Background Overlay Tracker -->
            <div x-show="isOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto w-full h-full">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!-- Modal Panel -->
                    <div x-show="isOpen"
                         @click.outside="closeModal()"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full sm:max-w-md border border-purple-200">
                        
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start text-center sm:text-left">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10 shadow-sm border border-emerald-200">
                                    <i class="fa-solid fa-check text-emerald-600"></i>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-xl font-bold text-gray-900" id="modal-title">User Account Created</h3>
                                    <div class="mt-2 text-left">
                                        <p class="text-sm text-gray-500 mb-4">
                                            Please securely copy the credentials below to send them to the user.
                                            <strong class="block mt-1 font-semibold text-rose-600 bg-rose-50 p-2 rounded-lg border border-rose-100">
                                                <i class="fa-solid fa-triangle-exclamation mr-1"></i> These credentials will only be shown this one time.
                                            </strong>
                                        </p>
                                        
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 space-y-3 shadow-inner">
                                            <!-- Email Field -->
                                            <div>
                                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email</label>
                                                <div class="flex items-center justify-between">
                                                 <div class="text-gray-900 font-mono text-sm break-all font-semibold" x-text="creds.email"></div>
                                                    <button type="button" @click="copy('email')" class="ml-2 w-8 h-8 rounded bg-white border border-gray-200 text-gray-500 hover:text-purple-600 hover:border-purple-300 transition-colors shadow-sm flex-shrink-0" title="Copy Email">
                                                        <i class="fa-regular fa-copy"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <hr class="border-gray-200">
                                            <!-- Password Field -->
                                            <div>
                                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Generated Password</label>
                                                <div class="flex items-center justify-between">
                                                    <div class="text-purple-600 font-mono text-base break-all selection:bg-purple-200 font-bold tracking-wide" x-text="creds.password"></div>
                                                    <button type="button" @click="copy('password')" class="ml-2 w-8 h-8 rounded bg-white border border-gray-200 text-gray-500 hover:text-purple-600 hover:border-purple-300 transition-colors shadow-sm flex-shrink-0" title="Copy Password">
                                                        <i class="fa-regular fa-copy"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Dynamic Copy Message Feedback -->
                                        <div class="h-6 mt-3 flex justify-center items-center">
                                            <div x-show="copyMessage !== ''" 
                                                 x-transition:enter="transition ease-out duration-300"
                                                 x-transition:enter-start="opacity-0 transform scale-95 translate-y-1"
                                                 x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                                 x-transition:leave="transition ease-in duration-200"
                                                 x-transition:leave-start="opacity-100 transform scale-100"
                                                 x-transition:leave-end="opacity-0 transform scale-95"
                                                 class="text-sm text-emerald-600 font-semibold bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200" 
                                                 x-text="copyMessage"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50/80 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                            <button type="button" @click="copy('all')" class="inline-flex w-full justify-center rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:from-purple-700 hover:to-indigo-700 sm:ml-3 sm:w-auto transition-transform hover:-translate-y-0.5">
                                <i class="fa-solid fa-clipboard mr-2 mt-0.5"></i> Copy All
                            </button>
                            <button type="button" @click="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm border border-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('credentialsModal', (credentials) => ({
                    isOpen: false,
                    creds: credentials,
                    copyMessage: '',
                    
                    initModal() {
                        setTimeout(() => { this.isOpen = true; }, 150);
                    },
                    closeModal() {
                        this.isOpen = false;
                    },
                    async copy(type) {
                        let textToCopy = '';
                        
                        if (type === 'email') {
                            textToCopy = this.creds.email;
                            this.copyMessage = 'Email copied to clipboard!';
                        } else if (type === 'password') {
                            textToCopy = this.creds.password;
                            this.copyMessage = 'Password copied to clipboard!';
                        } else if (type === 'all') {
                            textToCopy = `Login: ${window.location.origin}/login\nEmail: ${this.creds.email}\nPassword: ${this.creds.password}`;
                            this.copyMessage = 'All details copied to clipboard!';
                        }
                        
                        try {
                            await navigator.clipboard.writeText(textToCopy);
                            setTimeout(() => {
                                if(this.copyMessage.includes('copied')) this.copyMessage = '';
                            }, 3000);
                        } catch (err) {
                            this.copyMessage = 'Failed to copy text (clipboard API error)';
                            setTimeout(() => this.copyMessage = '', 3000);
                        }
                    }
                }));
            });
        </script>
    @endif
@endsection
