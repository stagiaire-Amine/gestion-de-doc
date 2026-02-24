<div x-data="{ 
        show: false, 
        url: '', 
        title: 'Confirm Deletion', 
        message: 'Are you sure you want to delete this item? This action cannot be undone.',
        method: 'DELETE'
    }" @open-delete-modal.window="
        show = true; 
        url = $event.detail.url; 
        title = $event.detail.title || title; 
        message = $event.detail.message || message;
        if ($event.detail.method) method = $event.detail.method;
    " x-show="show" style="display: none;" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-sm"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-sm"
    x-transition:leave-end="opacity-0 backdrop-blur-none"
    class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/40 backdrop-blur-sm p-4">

    <div @click.outside="show = false" x-show="show" x-transition:enter="transition ease-out duration-300 delay-75"
        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="bg-white rounded-2xl shadow-2xl overflow-hidden w-full max-w-md relative border border-gray-100">

        <div class="p-6 md:p-8">
            <div class="flex items-start gap-4 mb-2">
                <div
                    class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center flex-shrink-0 text-rose-500 shadow-inner">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div class="pt-1">
                    <h3 class="text-xl font-bold text-gray-900 leading-tight" x-text="title"></h3>
                    <p class="text-sm text-gray-500 mt-2 leading-relaxed" x-text="message"></p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-8">
                <button type="button" @click="show = false"
                    class="px-5 py-2.5 rounded-xl font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors focus:ring-2 focus:ring-gray-300 focus:outline-none">
                    Cancel
                </button>
                <form :action="url" method="POST" class="m-0 p-0 inline">
                    @csrf
                    <input type="hidden" name="_method" :value="method">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl font-bold text-white bg-rose-500 hover:bg-rose-600 shadow-lg shadow-rose-200 transition-all hover:-translate-y-0.5 active:translate-y-0 focus:ring-2 focus:ring-rose-400 focus:outline-none flex items-center gap-2">
                        <i class="fas fa-check"></i> Confirm
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>