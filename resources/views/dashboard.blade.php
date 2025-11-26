<!DOCTYPE html>
<html lang="id" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Moneytor</title>
    <link rel="icon" href="/img/logo.png" type="image/png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Space Grotesk', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background-color: #e2e8f0; border-radius: 20px; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
        
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>
</head>
<body x-data="{ showIncomeModal: false }" class="bg-gray-50 h-screen flex flex-col overflow-hidden text-slate-800 font-sans">

    <!-- HEADER -->
    <header class="bg-white/80 backdrop-blur-lg border-b border-gray-200 sticky top-0 z-40 h-16 flex items-center justify-between px-6 shadow-sm">
        <div class="flex items-center gap-2">
            <img src="/img/logo.png" alt="Moneytor Logo" class="h-7 w-auto">
            <div>
                <span class="font-bold text-xl tracking-tight text-gray-900">Moneytor</span>
            </div>
            <span class="px-2 py-0.5 bg-brand-50 text-brand-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-brand-100">Beta</span>
        </div>
        
        <div class="flex items-center gap-4">
            <button onclick="clearChat()" class="text-xs text-gray-400 hover:text-red-500 font-medium transition flex items-center gap-1 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Reset Context
            </button>
            <div class="h-6 w-px bg-gray-200"></div>
            <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-2 py-1 rounded-lg transition">
                <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold">JD</div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex overflow-hidden">
        
        <!-- LEFT: CHAT INTERFACE -->
        <section class="w-full lg:w-[45%] flex flex-col border-r border-gray-200 bg-white relative z-10">
            <div id="chat-container" class="flex-1 overflow-y-auto p-6 space-y-6 scroll-smooth">
                <div class="flex gap-4 animate-fade-in">
                    <img src="/img/gyro.png" alt="Gyro Logo" class="h-8 w-auto">
                    <div class="space-y-2 max-w-[85%]">
                        <span class="text-s font-semibold text-gray-500 ml-1">Gyro</span>
                        <div class="bg-white border border-gray-200 text-slate-700 p-4 rounded-2xl rounded-tl-none shadow-sm text-sm leading-relaxed">
                            <p>Yo! Gw Gyro. 👋</p>
                            <p class="mt-2">Gw technical advisor & partner strategis lo. Gw di sini buat bantu lo mikir, bukan cuma nyatet. Kita fokus sikat <i>profitless growth</i> biar cashflow lo sehat. Mau bedah metric apa hari ini?</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white border-t border-gray-100">
                <div class="relative max-w-3xl mx-auto">
                    <form id="chat-form" class="relative flex items-end gap-2 bg-gray-50 border border-gray-200 rounded-2xl p-2 focus-within:ring-2 focus-within:ring-brand-500/20 focus-within:border-brand-500 transition-all shadow-inner">
                        <textarea 
                            id="user-input"
                            rows="1"
                            class="w-full bg-transparent border-0 focus:ring-0 p-3 text-slate-900 placeholder-gray-400 text-sm resize-none max-h-32 overflow-y-auto"
                            placeholder="Tanya Gyro: 'Gimana forecast cashflow gw bulan depan?'..."
                            oninput="autoResize(this)"
                            onkeydown="handleEnter(event)"
                        ></textarea>
                        <button type="submit" id="send-btn" class="p-3 bg-slate-900 text-white rounded-xl hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed transition mb-0.5 shadow-lg shadow-slate-900/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform -rotate-45 translate-x-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                            </svg>
                        </button>
                    </form>
                    <div class="text-center mt-2">
                        <p class="text-[10px] text-gray-400 font-medium tracking-wide">Gyro assist, but you decide. Always double-check critical data.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- RIGHT: CANVAS DASHBOARD -->
        <section class="hidden lg:flex lg:w-[55%] flex-col bg-slate-50/50 overflow-y-auto">
            <div class="p-8 max-w-4xl mx-auto w-full space-y-8">
                
                <!-- Section Header -->
                <div class="flex items-end justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Overview</h2>
                        <p class="text-sm text-gray-500 mt-1">Snapshot keuangan lo per <span id="current-date" class="font-medium text-gray-700">Today</span></p>
                    </div>
                    <button class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-slate-700 text-sm font-semibold rounded-lg hover:bg-gray-50 hover:border-gray-300 transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Export Report
                    </button>
                </div>

                <!-- Main Grid -->
                <div class="grid grid-cols-12 gap-6">
                    
                    <!-- Balance Card -->
                    <div class="col-span-12 bg-slate-900 rounded-2xl py-5 px-6 text-white shadow-xl shadow-slate-900/10 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500 rounded-full blur-[100px] opacity-20 group-hover:opacity-30 transition duration-700"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-slate-400 text-xs font-medium uppercase tracking-widest mb-1">Total Net Worth</p>
                                <h3 class="text-3xl font-bold tracking-tight">Rp 12.450.000</h3>
                            </div>
                            <div class="bg-white/10 backdrop-blur-md px-3 py-1 rounded-lg border border-white/10">
                                <span class="text-xs font-medium text-brand-300 flex items-center gap-1">
                                    ▲ 12.5% vs last month
                                </span>
                            </div>
                        </div>
                        <div class="relative z-10 mt-5 grid grid-cols-2 gap-8 border-t border-white/10 pt-4">
                            <div>
                                <div class="flex items-center gap-2 text-slate-400 text-xs mb-1">
                                    <div class="w-2 h-2 rounded-full bg-brand-400"></div> Income
                                </div>
                                <p class="text-lg font-semibold">Rp 15.000.000</p>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 text-slate-400 text-xs mb-1">
                                    <div class="w-2 h-2 rounded-full bg-red-400"></div> Expense
                                </div>
                                <p class="text-lg font-semibold">Rp 2.550.000</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-span-12 grid grid-cols-2 gap-4">
                        
                        <!-- BUTTON 1: INPUT INCOME (TRIGGER) -->
                        <button 
                            @click="showIncomeModal = true"
                            class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-brand-500 hover:ring-1 hover:ring-brand-500 transition group shadow-sm hover:shadow-md text-left"
                        >
                            <div class="flex items-center gap-4">
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
                        </button>

                        <!-- BUTTON 2: INPUT EXPENSE -->
                        <button class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:ring-1 hover:ring-red-500 transition group shadow-sm hover:shadow-md text-left">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center group-hover:bg-red-500 transition duration-300">
                                    <svg class="w-5 h-5 text-red-600 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 text-sm">Input Expense</p>
                                    <p class="text-xs text-gray-500">Catat pengeluaran</p>
                                </div>
                            </div>
                        </button>
                    </div>

                    <!-- Charts & Transactions -->
                    <div class="col-span-12 md:col-span-5 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-slate-900">Spending Breakdown</h3>
                            <p class="text-xs text-gray-400 mb-6">Berdasarkan kategori bulan ini</p>
                        </div>
                        <div class="relative h-48 w-full flex items-center justify-center">
                            <canvas id="spendingChart"></canvas>
                        </div>
                        <div class="mt-4 flex justify-center gap-4 text-xs text-gray-500">
                            <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-brand-500"></span> Food</div>
                            <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Bills</div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-7 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-slate-900">Recent Activity</h3>
                            <a href="#" class="text-xs text-brand-600 font-medium hover:underline">View All</a>
                        </div>
                        <div class="space-y-4">
                            <!-- Transaction Items (Unchanged) -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-red-50 text-red-600 rounded-full flex items-center justify-center group-hover:bg-red-100 transition">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">Groceries Superindo</p>
                                        <p class="text-xs text-gray-400">Today, 10:30 AM</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-slate-900">- Rp 250.000</span>
                            </div>
                            <!-- More items... -->
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- === INCOME MODAL (UPDATED) === -->
    <div 
        x-show="showIncomeModal" 
        style="display: none;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[999] flex items-center justify-center px-4 bg-slate-900/40 backdrop-blur-sm"
    >
        <div 
            @click.away="showIncomeModal = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="bg-white w-full max-w-lg rounded-[2rem] shadow-2xl relative overflow-hidden"
        >
            <form action="#" method="POST" class="p-8">
                @csrf
                
                <!-- Header: Cleaner, No Accent Bar -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 font-sans tracking-tight">New Income</h3>
                        <p class="text-sm text-slate-500 mt-1">Catat rejeki, pantau arus kas. 💸</p>
                    </div>
                    <button @click="showIncomeModal = false" type="button" class="p-2 bg-gray-50 hover:bg-gray-100 rounded-full text-gray-400 hover:text-gray-600 transition">
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
                    <div class="h-px w-full bg-gray-200 mt-2 group-focus-within:bg-brand-500 group-focus-within:h-0.5 transition-all duration-300"></div>
                </div>

                <!-- DATE INPUT (Full Width for Context) -->
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 mb-2">TANGGAL TRANSAKSI</label>
                    <input 
                        type="date" 
                        name="date" 
                        class="w-full bg-gray-50 border border-gray-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 block p-3.5 transition-all"
                    >
                </div>

                <!-- FLOW GRID: FROM -> TO -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <!-- 1. Source (Dari Mana) -->
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-gray-500">SUMBER DANA</label>
                        <div class="relative">
                            <select name="category_id" class="w-full bg-white border border-gray-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 block p-3.5 pl-10 appearance-none shadow-sm hover:border-gray-300 transition">
                                <option value="salary">💰 Gaji Bulanan</option>
                                <option value="freelance">💻 Freelance</option>
                                <option value="invest">📈 Investasi</option>
                                <option value="gift">🎁 Hadiah</option>
                            </select>
                            <!-- Icon Left -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Wallet (Ke Mana / Kantong) -->
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-brand-600">MASUK KANTONG</label>
                        <div class="relative">
                            <select name="wallet_id" class="w-full bg-brand-50 border border-brand-200 text-brand-900 text-sm rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 block p-3.5 pl-10 appearance-none shadow-sm hover:border-brand-300 transition font-medium">
                                <option value="bca">💳 Bank BCA</option>
                                <option value="mandiri">💳 Bank Mandiri</option>
                                <option value="gopay">📱 GoPay</option>
                                <option value="cash">💵 Cash Dompet</option>
                                <option value="emergency">🔒 Tabungan Darurat</option>
                            </select>
                            <!-- Icon Left -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-brand-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </div>
                            <!-- Chevron Right -->
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-brand-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-8 space-y-2">
                    <label class="block text-xs font-semibold text-gray-500">CATATAN</label>
                    <textarea 
                        name="description" 
                        rows="2" 
                        class="w-full bg-gray-50 border border-gray-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 block p-3.5 resize-none placeholder-gray-400 transition"
                        placeholder="Contoh: Pembayaran termin 1 proyek website..."
                    ></textarea>
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button 
                        type="button" 
                        @click="showIncomeModal = false"
                        class="flex-1 px-5 py-3.5 border border-gray-200 text-slate-700 font-semibold rounded-xl hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="flex-[2] px-5 py-3.5 bg-brand-600 text-white font-bold rounded-xl hover:bg-brand-700 transition shadow-lg shadow-brand-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 flex items-center justify-center gap-2 transform active:scale-[0.98]"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Pemasukan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        // Date & Chat Logic
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            input.valueAsDate = new Date();
        });

        // Existing Chat & Chart Scripts (No changes needed)
        const chatContainer = document.getElementById('chat-container');
        const chatForm = document.getElementById('chat-form');
        const userInput = document.getElementById('user-input');
        const sendBtn = document.getElementById('send-btn');

        function autoResize(el) {
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
            if(!el.value) el.style.height = 'auto';
        }

        function handleEnter(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        }

        function clearChat() {
            if(confirm('Reset context chat ini?')) {
                const firstBubble = chatContainer.firstElementChild;
                chatContainer.innerHTML = '';
                chatContainer.appendChild(firstBubble);
            }
        }

        function appendMessage(role, text) {
            const isUser = role === 'user';
            const wrapper = document.createElement('div');
            wrapper.className = `flex gap-4 animate-fade-in ${isUser ? 'flex-row-reverse' : ''}`;
            
            const avatar = isUser 
                ? `<div class="w-8 h-8 rounded-full bg-slate-900 text-white flex-shrink-0 flex items-center justify-center text-xs font-bold mt-1 shadow-sm">JD</div>`
                : `<div class="w-8 h-8 bg-brand-100 rounded-full flex-shrink-0 flex items-center justify-center mt-1 border border-brand-200 text-brand-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                   </div>`;

            const name = isUser ? '' : `<span class="text-xs font-semibold text-gray-500 ml-1 block mb-1">Gyro</span>`;

            const bubbleClass = isUser 
                ? 'bg-slate-900 text-white rounded-2xl rounded-tr-none shadow-md' 
                : 'bg-white border border-gray-200 text-slate-700 rounded-2xl rounded-tl-none shadow-sm';

            const content = isUser ? text : marked.parse(text);

            wrapper.innerHTML = `
                ${avatar}
                <div class="max-w-[85%]">
                    ${name}
                    <div class="${bubbleClass} px-5 py-3 text-sm leading-relaxed prose prose-sm max-w-none dark:prose-invert">
                        ${content}
                    </div>
                </div>
            `;

            chatContainer.appendChild(wrapper);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function showTyping() {
            const id = 'typing-indicator';
            const html = `
                <div id="${id}" class="flex gap-4 animate-fade-in">
                    <div class="w-8 h-8 bg-brand-100 rounded-full flex-shrink-0 flex items-center justify-center mt-1 border border-brand-200">
                         <svg class="h-4 w-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-2xl rounded-tl-none text-gray-500 flex items-center gap-1.5 w-fit">
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></span>
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.15s"></span>
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></span>
                    </div>
                </div>
            `;
            chatContainer.insertAdjacentHTML('beforeend', html);
            chatContainer.scrollTop = chatContainer.scrollHeight;
            return id;
        }

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const text = userInput.value.trim();
            if (!text) return;

            appendMessage('user', text);
            userInput.value = '';
            userInput.style.height = 'auto';
            sendBtn.disabled = true;

            const typingId = showTyping();

            try {
                await new Promise(r => setTimeout(r, 1500));
                document.getElementById(typingId).remove();
                const mockResponse = "Untuk budget makan, lo masih punya sisa **Rp 550.000** minggu ini. Saran gw, kurangin jajan kopi kalau mau aman sampai gajian.";
                appendMessage('bot', mockResponse);
            } catch (error) {
                document.getElementById(typingId).remove();
                appendMessage('bot', '**Error:** Connection failed.');
            } finally {
                sendBtn.disabled = false;
                userInput.focus();
            }
        });

        const ctx = document.getElementById('spendingChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Food', 'Transport', 'Shopping', 'Bills', 'Other'],
                datasets: [{
                    data: [35, 15, 20, 25, 5],
                    backgroundColor: [
                        '#10b981', // Brand Green
                        '#3b82f6', // Blue
                        '#f59e0b', // Amber
                        '#6366f1', // Indigo
                        '#cbd5e1'  // Slate
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>