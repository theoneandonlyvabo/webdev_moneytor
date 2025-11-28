<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Moneytor</title>
    <link rel="icon" href="/img/logo.png" type="image/png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            500: '#10b981',
                            600: '#059669',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap');
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>
</head>

<body x-data="{ showIncomeModal: false, showExpenseModal: false, mobileMenu: false }" class="bg-slate-50 h-screen flex flex-col overflow-hidden text-slate-800 font-sans antialiased">

    <!-- HEADER -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 h-16 flex items-center justify-between px-4 lg:px-8 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="bg-slate-900 rounded-lg p-1.5">
                <img src="/img/logo.png" alt="M" class="h-5 w-auto">
            </div>
            <div>
                <span class="font-bold text-lg tracking-tight text-slate-900">Moneytor</span>
            </div>
            <span class="px-2 py-0.5 bg-brand-50 text-brand-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-brand-200">Beta</span>
        </div>
        
        <div class="flex items-center gap-6">
            <button onclick="clearChat()" class="hidden md:flex text-xs text-slate-500 hover:text-red-500 font-medium transition items-center gap-1.5 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset Context
            </button>
            
            <div class="h-5 w-px bg-slate-200 hidden md:block"></div>
            
            <div class="flex items-center gap-3">
                <div class="text-right hidden md:block">
                    <p class="text-xs font-bold text-slate-900">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-500">Free Plan</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold hover:bg-slate-700 transition shadow-md ring-2 ring-white" title="Logout">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="flex-1 flex overflow-hidden">
        
        <!-- LEFT: CHAT INTERFACE (Sticky Sidebar Style) -->
        <section class="w-full lg:w-[40%] xl:w-[35%] flex flex-col border-r border-slate-200 bg-white relative z-10 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
            <!-- Chat Area -->
            <div id="chat-container" class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6 scroll-smooth bg-slate-50/30">
                <!-- Welcome Message -->
                <div class="flex gap-4 animate-fade-in group">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-white border border-slate-100 shadow-sm flex items-center justify-center p-1.5 overflow-hidden">
                            <img src="/img/gyro.png" alt="Gyro" class="w-full h-full object-contain">
                        </div>
                    </div>
                    <div class="space-y-1 max-w-[85%]">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-slate-900">Gyro</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 font-medium">AI Advisor</span>
                        </div>
                        <div class="bg-white border border-slate-200 text-slate-600 p-4 rounded-2xl rounded-tl-none shadow-sm text-sm leading-relaxed">
                            <p>Yo! Gw Gyro. 👋</p>
                            <p class="mt-2">Gw technical advisor & partner strategis lo. Gw di sini buat bantu lo mikir, bukan cuma nyatet. Kita fokus sikat <i>profitless growth</i> biar cashflow lo sehat. Mau bedah metric apa hari ini?</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white border-t border-slate-100">
                <div class="relative max-w-3xl mx-auto">
                    <form id="chat-form" class="relative flex items-end gap-2 bg-slate-50 border border-slate-200 rounded-2xl p-2 focus-within:ring-2 focus-within:ring-brand-500/20 focus-within:border-brand-500 transition-all shadow-inner">
                        <textarea 
                            id="user-input"
                            rows="1"
                            class="w-full bg-transparent border-0 focus:ring-0 p-3 text-slate-900 placeholder-slate-400 text-sm resize-none max-h-32 overflow-y-auto font-medium"
                            placeholder="Tanya Gyro: 'Gimana forecast cashflow gw bulan depan?'..."
                            oninput="autoResize(this)"
                            onkeydown="handleEnter(event)"
                        ></textarea>
                        <button type="submit" id="send-btn" class="p-2.5 bg-slate-900 text-white rounded-xl hover:bg-brand-600 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 mb-0.5 shadow-lg shadow-slate-900/20 hover:shadow-brand-500/30 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                            </svg>
                        </button>
                    </form>
                    <div class="text-center mt-2 flex justify-center items-center gap-1.5 opacity-60 hover:opacity-100 transition-opacity">
                        <svg class="w-3 h-3 text-brand-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <p class="text-[10px] text-slate-400 font-medium tracking-wide">Gyro assist, but you decide.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- RIGHT: DASHBOARD (Scrollable) -->
        <section class="hidden lg:flex lg:w-[60%] xl:w-[65%] flex-col bg-slate-50 relative overflow-y-auto">
            <!-- Content Container -->
            <div class="p-8 xl:p-12 w-full max-w-6xl mx-auto space-y-10">
                
                <!-- Page Title -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Overview</h1>
                        <p class="text-slate-500 text-sm mt-1 font-medium flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                            Snapshot keuangan per {{ \Carbon\Carbon::now()->format('d F Y') }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <span class="bg-white px-3 py-1 rounded-full border border-slate-200 text-xs font-bold text-slate-600 shadow-sm">
                            IDR Currency
                        </span>
                    </div>
                </div>

                <!-- MAIN CARD (Net Worth) -->
                <div class="relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-brand-600 to-blue-600 rounded-[2rem] blur opacity-20 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative bg-slate-900 text-white rounded-[1.8rem] p-8 md:p-10 shadow-2xl overflow-hidden ring-1 ring-white/10">
                        <!-- Background Glows -->
                        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-64 h-64 bg-brand-500/20 rounded-full blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-64 h-64 bg-blue-600/20 rounded-full blur-3xl"></div>
                        
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-8">
                                <div>
                                    <p class="text-slate-400 text-xs font-bold tracking-widest uppercase mb-1">Total Net Worth</p>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-slate-400 text-2xl font-light">Rp</span>
                                        <h2 class="text-5xl md:text-6xl font-bold tracking-tight font-mono">{{ number_format($totalSaldo, 0, ',', '.') }}</h2>
                                    </div>
                                </div>
                                <span class="bg-white/5 backdrop-blur-md border border-white/10 text-brand-300 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-inner">
                                    <span class="w-1.5 h-1.5 bg-brand-400 rounded-full animate-pulse"></span> Live
                                </span>
                            </div>
                            
                            <!-- Stats Grid -->
                            <div class="grid grid-cols-2 gap-6 border-t border-white/10 pt-6 mt-6">
                                <div class="group/stat">
                                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1 group-hover/stat:text-brand-400 transition-colors">Total Income</p>
                                    <p class="text-xl md:text-2xl font-bold text-white font-mono flex items-center gap-2">
                                        <svg class="w-4 h-4 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                        {{ number_format($pemasukan, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="group/stat">
                                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1 group-hover/stat:text-red-400 transition-colors">Total Expense</p>
                                    <p class="text-xl md:text-2xl font-bold text-white font-mono flex items-center gap-2">
                                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                        {{ number_format($pengeluaran, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Income Button -->
                    <button @click="showIncomeModal = true" class="relative group overflow-hidden bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-brand-200 transition-all duration-300 text-left">
                        <div class="absolute inset-0 bg-gradient-to-r from-brand-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10 flex items-center gap-5">
                            <div class="w-14 h-14 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg">Input Income</h3>
                                <p class="text-sm text-slate-500 font-medium">Catat pemasukan baru</p>
                            </div>
                            <div class="ml-auto opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </button>
                    
                    <!-- Expense Button -->
                    <button @click="showExpenseModal = true" class="relative group overflow-hidden bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-red-200 transition-all duration-300 text-left">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10 flex items-center gap-5">
                            <div class="w-14 h-14 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg">Input Expense</h3>
                                <p class="text-sm text-slate-500 font-medium">Catat pengeluaran baru</p>
                            </div>
                            <div class="ml-auto opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </button>
                </div>

                <!-- ANALYTICS SECTION -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    
                    <!-- Spending Chart -->
                    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col">
                        <h3 class="font-bold text-slate-900 mb-6 text-lg">Spending Breakdown</h3>
                        <div class="flex-1 flex items-center justify-center relative">
                            <div class="w-full max-w-[220px] aspect-square relative">
                                <canvas id="spendingChart"></canvas>
                                <!-- Center Text Overlay -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <span class="text-xs text-slate-400 font-bold uppercase">Total</span>
                                    <span class="text-sm font-bold text-slate-800">Expense</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 text-center">
                            <p class="text-xs text-slate-400 font-medium">Distribusi pengeluaran per kategori</p>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="xl:col-span-2 bg-white p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-slate-900 text-lg">Recent Activity</h3>
                            <button class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">View All</button>
                        </div>
                        
                        <div class="space-y-3 flex-1 overflow-y-auto no-scrollbar max-h-[300px]">
                            @forelse($recentTransactions as $trx)
                                <div class="group flex items-center justify-between p-4 rounded-2xl hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all duration-200">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-sm {{ $trx->type == 'income' ? 'bg-brand-100 text-brand-600' : 'bg-red-100 text-red-600' }} group-hover:scale-110 transition-transform">
                                            @if($trx->type == 'income')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-sm group-hover:text-brand-600 transition-colors">
                                                {{ $trx->description ?? $trx->category->nama_kategori ?? 'Tanpa Kategori' }}
                                            </h4>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-[10px] font-medium text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">{{ \Carbon\Carbon::parse($trx->date)->format('d M') }}</span>
                                                <span class="text-[10px] text-slate-400">{{ $trx->account->nama_akun ?? 'Unknown' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="font-mono font-bold text-sm {{ $trx->type == 'income' ? 'text-brand-600' : 'text-slate-900' }}">
                                        {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                    </span>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-10 text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="text-slate-500 font-medium text-sm">Belum ada transaksi.</p>
                                    <p class="text-slate-400 text-xs mt-1">Mulai catat keuanganmu sekarang!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Footer Spacer -->
                <div class="h-10"></div>
            </div>
        </section>
    </div>

    <!-- ================= MODAL INPUT INCOME (HIJAU) ================= -->
    <div x-show="showIncomeModal" style="display: none;" class="fixed inset-0 z-50 flex items-end md:items-center justify-center px-0 md:px-4 pb-0 md:pb-4">
        <!-- Backdrop -->
        <div x-show="showIncomeModal" x-transition:enter="transition ease-out duration-300 z-[61]" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showIncomeModal = false"></div>

        <!-- Modal Panel -->
        <div x-show="showIncomeModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-full scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-full scale-95" class="bg-white w-full md:max-w-lg rounded-t-[2rem] md:rounded-[2rem] shadow-2xl relative z-10 overflow-hidden max-h-[90vh] overflow-y-auto">
            
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="income">
                
                <div class="px-8 pt-8 pb-4 flex justify-between items-start sticky top-0 bg-white z-20">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                            <span class="text-xs font-bold text-brand-600 uppercase tracking-wider">Income</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900">Catat Pemasukan</h3>
                    </div>
                    <button type="button" @click="showIncomeModal = false" class="p-2 bg-slate-50 hover:bg-slate-100 rounded-full text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="px-8 pb-8 space-y-6">
                    <!-- Nominal -->
                    <div class="bg-brand-50 rounded-2xl p-5 border border-brand-100 ring-4 ring-brand-50/50">
                        <label class="block text-xs font-bold text-brand-700 uppercase tracking-wider mb-1">Total Amount</label>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-brand-600 font-mono">Rp</span>
                            <input type="number" name="amount" required class="w-full bg-transparent text-4xl font-bold text-slate-900 placeholder-brand-200 border-none focus:ring-0 p-0 font-mono" placeholder="0">
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Transaksi</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-transparent p-3.5 font-medium transition-shadow">
                    </div>

                    <!-- Pilihan Dropdown (Dinamis) -->
                    <div class="grid grid-cols-2 gap-4 z-50">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sumber</label>
                            <input type="text" name="source" required placeholder="Contoh: Gaji, Dividend, dll" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-transparent p-3.5 font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Masuk Ke</label>
                            <div class="relative">
                                <select name="account_id" required class="w-full bg-white border-2 border-slate-200 text-slate-800 text-sm rounded-xl p-3.5 appearance-none focus:ring-2 focus:ring-brand-500 focus:border-transparent font-medium">
                                    <option value="">Pilih ({{ isset($accounts) ? $accounts->count() : '0' }})</option>
                                        @if(isset($accounts))
                                            @foreach($accounts as $acc)
                                                <option value="{{ $acc->id }}">{{ $acc->nama_akun }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>Data tidak tersedia</option>
                                        @endif
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan</label>
                        <input type="text" name="description" class="w-full bg-slate-50 border-none text-slate-900 text-sm rounded-xl p-4 focus:ring-2 focus:ring-brand-500 placeholder-slate-400 border-slate-200 font-medium" placeholder="Beri Catatan">
                    </div>

                    <button type="submit" class="w-full bg-brand-600 text-white font-bold rounded-xl py-4 hover:bg-brand-700 transition shadow-lg shadow-brand-500/30 active:scale-[0.98]">Simpan Pemasukan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL INPUT EXPENSE (MERAH) ================= -->
    <div x-show="showExpenseModal" style="display: none;" class="fixed inset-0 z-50 flex items-end md:items-center justify-center px-0 md:px-4 pb-0 md:pb-4">
        <!-- Backdrop -->
        <div x-show="showExpenseModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showExpenseModal = false"></div>

        <!-- Modal Panel -->
        <div x-show="showExpenseModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-full scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-full scale-95" class="bg-white w-full md:max-w-lg rounded-t-[2rem] md:rounded-[2rem] shadow-2xl relative z-10 overflow-hidden max-h-[90vh] overflow-y-auto">
            
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="expense">
                
                <div class="px-8 pt-8 pb-4 flex justify-between items-start sticky top-0 bg-white z-20">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Expense</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900">Catat Pengeluaran</h3>
                    </div>
                    <button type="button" @click="showExpenseModal = false" class="p-2 bg-slate-50 hover:bg-slate-100 rounded-full text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="px-8 pb-8 space-y-6">
                    <!-- Nominal -->
                    <div class="bg-red-50 rounded-2xl p-5 border border-red-100 ring-4 ring-red-50/50">
                        <label class="block text-xs font-bold text-red-700 uppercase tracking-wider mb-1">Total Amount</label>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-red-600 font-mono">Rp</span>
                            <input type="number" name="amount" required class="w-full bg-transparent text-4xl font-bold text-slate-900 placeholder-red-200 border-none focus:ring-0 p-0 font-mono" placeholder="0">
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Transaksi</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent p-3.5 font-medium transition-shadow">
                    </div>

                    <!-- Pilihan Dropdown -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Untuk Apa</label>
                            <div class="relative">
                                <select name="category_id" required class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl p-3.5 appearance-none focus:ring-2 focus:ring-red-500 focus:border-transparent font-medium">
                                    @foreach($expenseCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ambil Dari</label>
                            <div class="relative">
                                <select name="account_id" required class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl p-3.5 appearance-none focus:ring-2 focus:ring-red-500 focus:border-transparent font-medium">
                                    @foreach($accounts as $acc)
                                        <option value="{{ $acc->id }}">{{ $acc->nama_akun }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan</label>
                        <input type="text" name="description" class="w-full bg-slate-50 border-none text-slate-900 text-sm rounded-xl p-4 focus:ring-2 focus:ring-red-500 placeholder-slate-400 font-medium" placeholder="Contoh: Makan siang, Bensin, Belanja...">
                    </div>

                    <button type="submit" class="w-full bg-red-600 text-white font-bold rounded-xl py-4 hover:bg-red-700 transition shadow-lg shadow-red-500/30 active:scale-[0.98]">Simpan Pengeluaran</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                confirmButtonColor: '#10B981',
                timer: 2000,
                showConfirmButton: false,
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-2xl',
                    title: 'font-bold text-slate-800',
                    content: 'text-slate-600'
                }
            });
        @endif

        // Grafik Donut
        const ctx = document.getElementById('spendingChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    data: {!! json_encode($chartValues) !!},
                    backgroundColor: ['#F59E0B', '#3B82F6', '#10B981', '#EF4444', '#8B5CF6'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: { 
                cutout: '80%', 
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { family: "'Plus Jakarta Sans', sans-serif" },
                        bodyFont: { family: "'JetBrains Mono', monospace" },
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed);
                                }
                                return label;
                            }
                        }
                    } 
                } 
            }
        });
    </script>

    <!-- BAGIAN KANAN: LIST DOMPET / KANTONG -->
<div class="col-span-12 lg:col-span-4 space-y-6">

    <!-- Header Kantong -->
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800">Kantong Saya</h2>
        <div class="flex gap-2">
            <!-- Tombol Tambah (Icon Plus Kecil di Header) -->
            <button onclick="document.getElementById('addWalletModal').showModal()" class="text-sm text-green-600 font-semibold hover:underline bg-green-50 px-3 py-1 rounded-lg">
                + Tambah
            </button>
        </div>
    </div>

    <!-- Grid Kartu Dompet -->
    <div class="grid grid-cols-2 gap-4">
        
        @foreach($wallets as $wallet)
        <!-- Tambahkan class 'group' untuk efek hover -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-200 flex flex-col justify-between h-32 relative overflow-hidden group">
            
            <!-- TOMBOL HAPUS (Muncul saat Hover) -->
            <!-- Form Delete -->
            <form action="{{ route('wallets.destroy', $wallet->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dompet {{ $wallet->name }}? Semua riwayat transaksi di dompet ini akan ikut terhapus permanen.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="absolute top-2 right-2 z-30 bg-white text-gray-400 hover:text-red-500 hover:bg-red-50 p-1.5 rounded-full shadow-sm opacity-0 group-hover:opacity-100 transition-all duration-200 transform scale-90 group-hover:scale-100" title="Hapus Dompet">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>

            <!-- Hiasan Background -->
            <div class="absolute top-0 right-0 w-16 h-16 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>

            <!-- Icon / Emoji -->
            <div class="z-10 w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-xl mb-2">
                @if(Str::contains(strtolower($wallet->name), 'bank')) 🏦
                @elseif(Str::contains(strtolower($wallet->name), 'tunai')) 💵
                @elseif(Str::contains(strtolower($wallet->name), 'gopay') || Str::contains(strtolower($wallet->name), 'ovo') || Str::contains(strtolower($wallet->name), 'dana')) 📱
                @elseif(Str::contains(strtolower($wallet->name), 'tabungan')) 🐷
                @else 💰
                @endif
            </div>

            <!-- Nama & Saldo -->
            <div class="z-10">
                <p class="text-xs text-gray-500 font-medium truncate">{{ $wallet->name }}</p>
                <p class="text-sm font-bold text-gray-800">
                    Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                </p>
            </div>
        </div>
        @endforeach

        <!-- Tombol Tambah Kantong (Versi Kartu) -->
        <button onclick="document.getElementById('addWalletModal').showModal()" class="bg-yellow-50 border-2 border-dashed border-yellow-200 p-4 rounded-2xl flex flex-col items-center justify-center h-32 hover:bg-yellow-100 transition duration-200 cursor-pointer text-yellow-700 group">
            <div class="w-10 h-10 rounded-full bg-yellow-200 flex items-center justify-center mb-1 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <span class="text-xs font-bold">Tambah Kantong</span>
        </button>

    </div>
</div>

<!-- MODAL TAMBAH DOMPET (Letakkan di bagian bawah file dashboard.blade.php) -->
<dialog id="addWalletModal" class="modal rounded-2xl shadow-2xl p-0 w-full max-w-sm backdrop:bg-gray-900/50">
    <div class="bg-white rounded-2xl overflow-hidden">
        <!-- Header Modal -->
        <div class="bg-green-600 px-6 py-4 flex justify-between items-center">
            <h3 class="font-bold text-lg text-white">Tambah Dompet Baru</h3>
            <form method="dialog">
                <button class="text-white hover:text-green-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Form Isi -->
        <form action="{{ route('wallets.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Dompet</label>
                <input type="text" name="name" placeholder="Contoh: Tabungan Nikah, Jajan, Bank Jago" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Saldo Awal (Opsional)</label>
                <div class="relative">
                    <span class="absolute left-4 top-2 text-gray-500">Rp</span>
                    <input type="number" name="balance" placeholder="0" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition duration-200">
                    Simpan Dompet
                </button>
            </div>
        </form>
    </div>
</dialog>
</body>
</html>