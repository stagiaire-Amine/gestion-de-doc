@if(!request()->is('api/*'))
    <div x-data="{ 
            showPopup: false,
            init() {
                // Check if user has already seen and dismissed the popup today
                const lastDismissed = localStorage.getItem('docuManagePopupDismissed');
                const now = new Date().getTime();

                // Show popup if not dismissed or dismissed more than 24 hours ago
                if (!lastDismissed || (now - parseInt(lastDismissed)) > 24 * 60 * 60 * 1000) {
                    setTimeout(() => { this.showPopup = true; }, 1000);
                }
            },
            dismiss() {
                this.showPopup = false;
                localStorage.setItem('docuManagePopupDismissed', new Date().getTime().toString());
            }
         }" x-show="showPopup" style="display: none;" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-sm"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 backdrop-blur-sm"
        x-transition:leave-end="opacity-0 backdrop-blur-none"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/40 backdrop-blur-sm p-4">

        <!-- Modal Content -->
        <div @click.outside="dismiss()" x-show="showPopup" x-transition:enter="transition ease-out duration-500 delay-100"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="bg-white rounded-2xl shadow-2xl overflow-hidden w-full max-w-md relative border border-indigo-100">

            <!-- Decoration top -->
            <div
                class="h-32 bg-gradient-to-br from-indigo-500 via-purple-500 to-fuchsia-500 relative overflow-hidden flex items-center justify-center">
                <!-- decorative circles -->
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
                <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-white/20 rounded-full blur-lg"></div>

                <div
                    class="h-16 w-16 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white border border-white/30 shadow-lg transform rotate-3">
                    <i class="fas fa-bullhorn text-3xl"></i>
                </div>
            </div>

            <!-- Close button -->
            <button @click="dismiss()"
                class="absolute top-4 right-4 text-white/80 hover:text-white bg-black/10 hover:bg-black/20 rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                <i class="fas fa-times"></i>
            </button>

            <!-- Body -->
            <div class="p-8 text-center">
                <h3
                    class="text-2xl font-bold bg-gradient-to-r from-indigo-700 to-purple-600 bg-clip-text text-transparent mb-3">
                    Welcome to DocuManage!</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Experience the next generation of document management. Secure, fast, and incredibly intuitive.
                </p>

                <button @click="dismiss()"
                    class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Got it, Thanks!
                </button>
            </div>
        </div>
    </div>
@endif