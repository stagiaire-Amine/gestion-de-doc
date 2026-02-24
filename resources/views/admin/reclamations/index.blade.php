@extends('layouts.dashboard')

@section('title', 'DocuManage • Manage Tickets')

@section('header')
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-purple-200/60 shadow-sm">
        <div>
            <h2
                class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-purple-700 to-indigo-600 leading-tight">
                <i class="fas fa-headset mr-2 text-purple-400"></i> Support Tickets (Admin)
            </h2>
            <p class="text-purple-500 text-sm mt-1 flex items-center gap-2">
                <i class="fas fa-shield-alt text-xs"></i> Manage and resolve user reclamations
            </p>
        </div>
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

        <!-- Filters (Optional but good UX) -->
        <div class="bg-white/80 backdrop-blur border border-purple-100 p-4 rounded-2xl flex gap-4">
            <a href="{{ route('admin.reclamations.index') }}"
                class="px-4 py-2 {{ !request('status') ? 'bg-purple-100 text-purple-800' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg font-semibold text-sm transition-colors">All
                Tickets</a>
            <a href="{{ route('admin.reclamations.index', ['status' => 'open']) }}"
                class="px-4 py-2 {{ request('status') === 'open' ? 'bg-purple-100 text-purple-800' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg font-semibold text-sm transition-colors">Open</a>
            <a href="{{ route('admin.reclamations.index', ['status' => 'in_progress']) }}"
                class="px-4 py-2 {{ request('status') === 'in_progress' ? 'bg-purple-100 text-purple-800' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg font-semibold text-sm transition-colors">In
                Progress</a>
        </div>

        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-purple-200/70 overflow-hidden">
            @if($reclamations->isEmpty())
                <div class="p-16 text-center">
                    <div
                        class="mx-auto h-24 w-24 bg-purple-50 border border-purple-100 rounded-full flex items-center justify-center mb-5 shadow-inner">
                        <i class="fas fa-check-double text-4xl text-purple-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">No reclamations found</h3>
                    <p class="mt-2 text-gray-500">The support queue is currently empty.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Ticket
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">User
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Priority</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($reclamations as $reclamation)
                                <tr class="hover:bg-purple-50/30 transition-colors">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-800">
                                            #{{ str_pad($reclamation->id, 5, '0', STR_PAD_LEFT) }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5 truncate max-w-[200px]"
                                            title="{{ $reclamation->subject }}">{{ $reclamation->subject }}</div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-700">
                                            {{ $reclamation->user->name ?? 'Unknown User' }}</div>
                                        <div class="text-xs text-gray-500">{{ $reclamation->user->email ?? 'Deleted Account' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @php
                                            $priColors = [
                                                'low' => 'bg-gray-100 text-gray-700 border-gray-200',
                                                'medium' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'high' => 'bg-rose-100 text-rose-800 border-rose-200',
                                            ];
                                            $priClass = $priColors[$reclamation->priority] ?? $priColors['low'];
                                        @endphp
                                        <span
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold border shadow-sm flex items-center w-max gap-1 capitalize {{ $priClass }}">
                                            @if($reclamation->priority == 'high') <i class="fas fa-exclamation-circle"></i>
                                            @elseif($reclamation->priority == 'medium') <i class="fas fa-minus"></i>
                                            @else <i class="fas fa-arrow-down"></i> @endif
                                            {{ $reclamation->priority }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @php
                                            $statColors = [
                                                'open' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'in_progress' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                'resolved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                'closed' => 'bg-gray-100 text-gray-800 border-gray-200',
                                            ];
                                            $statClass = $statColors[$reclamation->status] ?? $statColors['open'];
                                        @endphp
                                        <span
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold border shadow-sm flex items-center w-max gap-1 capitalize {{ $statClass }}">
                                            {{ str_replace('_', ' ', $reclamation->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        <div class="flex items-center gap-2">
                                            <i class="far fa-calendar-alt text-gray-400"></i>
                                            {{ $reclamation->created_at->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.reclamations.show', $reclamation) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-indigo-50 text-indigo-600 font-bold hover:bg-indigo-600 hover:text-white transition-colors gap-2 shadow-sm border border-indigo-100">
                                            View <i class="fas fa-arrow-right text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $reclamations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection