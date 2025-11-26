<!-- 
    Root Wrapper dengan Alpine Data. 
    Bisa ditaruh melingkupi area Quick Actions atau di root body kalau mau global.
-->
<div x-data="{ incomeModalOpen: false }">

    <!-- 1. TRIGGER BUTTON (Ganti button 'Input Income' yang lama dengan ini) -->
    <button 
        @click="incomeModalOpen = true"
        class="w-full flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-brand-500 hover:ring-1 hover:ring-brand-500 transition group shadow-sm hover:shadow-md text-left relative overflow-hidden"
    >
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-10 h-10 bg-brand-50 rounded-lg flex items-center justify-center group-hover:bg-brand-500 transition duration-300">
                <svg class="w-5 h-5 text-brand-600 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <p class="font-bold text-slate-900 text-sm">Input Income</p>
                <p class="text-xs text-gray-500">Catat pemasukan</p>
            </div>
        </div>
        <!-- Decorative BG Bloom -->
        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-brand-50 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition duration-500"></div>
    </button>

    <!-- 2. MODAL OVERLAY -->
    <div 
        x-show="incomeModalOpen" 
        style="display: none;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[99] flex items-center justify-center px-4 bg-slate-900/40 backdrop-blur-sm"
    >
        <!-- MODAL CARD -->
        <div 
            @click.away="incomeModalOpen = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="bg-white w-full max-w-lg rounded-3xl shadow-2xl relative overflow-hidden ring-1 ring-gray-100"
        >
            <!-- Header Accent -->
            <div class="h-2 w-full bg-gradient-to-r from-brand-500 to-emerald-400"></div>

            <form action="#" method="POST" class="p-8"> <!-- Ganti action ke route store lo -->
                @csrf
                
                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 font-sans tracking-tight">New Income</h3>
                        <p class="text-sm text-slate-500 mt-1">Alhamdulillah, rejeki lancar! 🤲</p>
                    </div>
                    <button @click="incomeModalOpen = false" type="button" class="p-2 bg-gray-50 hover:bg-gray-100 rounded-full text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- HERO INPUT: AMOUNT -->
                <div class="mb-8 relative group">
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Total Amount</label>
                    <div class="relative flex items-baseline">
                        <span class="text-2xl font-bold text-slate-400 mr-2">Rp</span>
                        <input 
                            type="number" 
                            name="amount" 
                            placeholder="0" 
                            class="w-full bg-transparent text-5xl font-bold text-slate-900 placeholder-gray-200 border-none focus:ring-0 p-0 font-sans tracking-tight transition-colors"
                            autofocus
                        >
                    </div>
                    <!-- Underline Animation -->
                    <div class="h-px w-full bg-gray-200 mt-2 group-focus-within:bg-brand-500 group-focus-within:h-0.5 transition-all duration-300"></div>
                </div>

                <!-- FORM GRID -->
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <!-- Date Input -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Tanggal</label>
                        <div class="relative">
                            <input 
                                type="date" 
                                name="date" 
                                value="{{ date('Y-m-d') }}"
                                class="w-full bg-gray-50 border border-gray-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 block p-3"
                            >
                        </div>
                    </div>

                    <!-- Category Select -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Sumber</label>
                        <div class="relative">
                            <select name="category_id" class="w-full bg-gray-50 border border-gray-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 block p-3 appearance-none">
                                <option value="salary">💰 Gaji Bulanan</option>
                                <option value="freelance">💻 Proyek Freelance</option>
                                <option value="investment">📈 Investasi</option>
                                <option value="gift">🎁 Hadiah / Bonus</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-8 space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Catatan (Opsional)</label>
                    <textarea 
                        name="description" 
                        rows="2" 
                        class="w-full bg-gray-50 border border-gray-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 block p-3 resize-none placeholder-gray-400"
                        placeholder="Contoh: Pembayaran termin 1 proyek website..."
                    ></textarea>
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button 
                        type="button" 
                        @click="incomeModalOpen = false"
                        class="flex-1 px-5 py-3.5 border border-gray-200 text-slate-700 font-semibold rounded-xl hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="flex-[2] px-5 py-3.5 bg-brand-600 text-white font-bold rounded-xl hover:bg-brand-900 transition shadow-lg shadow-brand-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Pemasukan
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>