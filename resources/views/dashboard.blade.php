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
<!-- Update x-data untuk handle 2 modal -->
<body x-data="{ showIncomeModal: false, showExpenseModal: false }" class="bg-gray-50 h-screen flex flex-col overflow-hidden text-slate-800 font-sans">

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
                <!-- 2. KONTEN UTAMA -->
    <main class="flex-1 overflow-y-auto p-6 md:p-12 relative w-full">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Overview</h1>
                <p class="text-gray-500 text-sm mt-1">Snapshot keuangan per {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('home.show') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Home</a>
                
                <!-- Tombol Logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold hover:bg-gray-800 transition text-xs" title="Logout">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Kartu Hitam (Net Worth) -->
        <div class="bg-[#0F172A] text-white rounded-3xl p-6 md:p-10 shadow-2xl mb-8 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                    <div>
                        <p class="text-gray-400 text-xs font-bold tracking-widest uppercase mb-2">Total Net Worth</p>
                        <h2 class="text-4xl md:text-6xl font-bold tracking-tight">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h2>
                    </div>
                    <span class="bg-white/10 backdrop-blur-md border border-white/10 text-green-300 text-xs font-medium px-3 py-1.5 rounded-full flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span> Live Update
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-8 border-t border-gray-800 pt-6">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider mb-1">Total Income</p>
                        <p class="text-lg md:text-2xl font-semibold text-green-400">+ Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider mb-1">Total Expense</p>
                        <p class="text-lg md:text-2xl font-semibold text-red-400">- Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <!-- Hiasan Background -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-purple-600/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Tombol Aksi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Tombol Input Income -->
            <button @click="showIncomeModal = true" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-green-200 transition flex items-center gap-5 group text-left w-full relative overflow-hidden">
                <div class="absolute inset-0 bg-green-50 translate-x-[-100%] group-hover:translate-x-0 transition duration-500 ease-out"></div>
                <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-3xl font-light relative z-10 group-hover:scale-110 transition">+</div>
                <div class="relative z-10">
                    <h3 class="font-bold text-gray-900 text-lg">Input Income</h3>
                    <p class="text-sm text-gray-500">Catat pemasukan baru</p>
                </div>
            </button>
            
            <!-- Tombol Input Expense -->
            <button @click="showExpenseModal = true" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-red-200 transition flex items-center gap-5 group text-left w-full relative overflow-hidden">
                <div class="absolute inset-0 bg-red-50 translate-x-[-100%] group-hover:translate-x-0 transition duration-500 ease-out"></div>
                <div class="w-14 h-14 bg-red-100 text-red-500 rounded-2xl flex items-center justify-center text-3xl font-light relative z-10 group-hover:scale-110 transition">−</div>
                <div class="relative z-10">
                    <h3 class="font-bold text-gray-900 text-lg">Input Expense</h3>
                    <p class="text-sm text-gray-500">Catat pengeluaran baru</p>
                </div>
            </button>
        </div>

        <!-- Grafik & Riwayat -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Grafik -->
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center justify-center">
                <h3 class="font-bold text-gray-900 mb-4 w-full text-left">Spending Breakdown</h3>
                <div class="relative w-48 h-48">
                    <canvas id="spendingChart"></canvas>
                </div>
                <p class="text-xs text-gray-400 mt-6 text-center">Pengeluaran per Kategori</p>
            </div>

            <!-- Recent Activity -->
            <div class="lg:col-span-2 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-900">Recent Activity</h3>
                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded">Latest 5</span>
                </div>
                <div class="space-y-4">
                    @forelse($recentTransactions as $trx)
                        <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-2xl transition cursor-default border border-transparent hover:border-gray-100">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $trx->type == 'income' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    @if($trx->type == 'income')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">
                                        {{ $trx->description ?? $trx->category->nama_kategori ?? 'Tanpa Kategori' }}
                                    </h4>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }} • {{ $trx->account->nama_akun ?? 'Akun Terhapus' }}
                                    </p>
                                </div>
                            </div>
                            <span class="font-bold {{ $trx->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-400 text-sm">
                            Belum ada transaksi bulan ini. Yuk mulai catat!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </main>

    <!-- ================= MODAL INPUT INCOME (HIJAU) ================= -->
    <div x-show="showIncomeModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6">
        <div x-show="showIncomeModal" x-transition.opacity class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="showIncomeModal = false"></div>

        <div x-show="showIncomeModal" x-transition.scale.origin.bottom class="bg-white w-full max-w-lg rounded-[2rem] shadow-2xl relative z-10 overflow-hidden">
            
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="income">
                
                <div class="px-8 pt-8 pb-4 flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">New Income</h3>
                        <p class="text-sm text-gray-500 mt-1">Rejeki anak soleh, catat dong! 🤑</p>
                    </div>
                    <button type="button" @click="showIncomeModal = false" class="p-2 bg-gray-100 rounded-full text-gray-500 hover:bg-gray-200 transition">✕</button>
                </div>

                <div class="px-8 pb-8 space-y-6">
                    <!-- Nominal -->
                    <div class="bg-green-50/50 p-4 rounded-2xl border border-green-100">
                        <label class="block text-xs font-bold text-green-600 uppercase tracking-wider mb-2">Total Amount</label>
                        <div class="flex items-center">
                            <span class="text-3xl font-bold text-green-600 mr-2">Rp</span>
                            <input type="number" name="amount" required class="w-full bg-transparent text-4xl font-bold text-gray-900 placeholder-gray-300 border-none focus:ring-0 p-0" placeholder="0">
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full bg-gray-50 border-none text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-green-500 p-4 font-medium">
                    </div>

                    <!-- Pilihan Dropdown (Dinamis) -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sumber</label>
                            <select name="category_id" required class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl p-3.5">
                                @foreach($incomeCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-green-600 uppercase tracking-wider mb-2">Masuk Ke</label>
                            <select name="account_id" required class="w-full bg-green-50 border border-green-200 text-green-900 text-sm rounded-xl p-3.5 font-bold">
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->nama_akun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <input type="text" name="description" class="w-full bg-gray-50 border-none text-gray-900 text-sm rounded-xl p-4" placeholder="Catatan (Opsional)...">

                    <button type="submit" class="w-full bg-green-600 text-white font-bold rounded-xl py-4 hover:bg-green-700 transition">Simpan Pemasukan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL INPUT EXPENSE (MERAH) ================= -->
    <div x-show="showExpenseModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6">
        <div x-show="showExpenseModal" x-transition.opacity class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="showExpenseModal = false"></div>

        <div x-show="showExpenseModal" x-transition.scale.origin.bottom class="bg-white w-full max-w-lg rounded-[2rem] shadow-2xl relative z-10 overflow-hidden">
            
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="expense">
                
                <div class="px-8 pt-8 pb-4 flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">New Expense</h3>
                        <p class="text-sm text-gray-500 mt-1">Jangan boros-boros ya! 💸</p>
                    </div>
                    <button type="button" @click="showExpenseModal = false" class="p-2 bg-gray-100 rounded-full text-gray-500 hover:bg-gray-200 transition">✕</button>
                </div>

                <div class="px-8 pb-8 space-y-6">
                    <!-- Nominal -->
                    <div class="bg-red-50/50 p-4 rounded-2xl border border-red-100">
                        <label class="block text-xs font-bold text-red-600 uppercase tracking-wider mb-2">Total Amount</label>
                        <div class="flex items-center">
                            <span class="text-3xl font-bold text-red-600 mr-2">Rp</span>
                            <input type="number" name="amount" required class="w-full bg-transparent text-4xl font-bold text-gray-900 placeholder-gray-300 border-none focus:ring-0 p-0" placeholder="0">
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full bg-gray-50 border-none text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-red-500 p-4 font-medium">
                    </div>

                    <!-- Pilihan Dropdown -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Untuk Apa</label>
                            <select name="category_id" required class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl p-3.5">
                                @foreach($expenseCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-red-600 uppercase tracking-wider mb-2">Pakai Uang</label>
                            <select name="account_id" required class="w-full bg-red-50 border border-red-200 text-red-900 text-sm rounded-xl p-3.5 font-bold">
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->nama_akun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <input type="text" name="description" class="w-full bg-gray-50 border-none text-gray-900 text-sm rounded-xl p-4" placeholder="Catatan (Opsional)...">

                    <button type="submit" class="w-full bg-red-600 text-white font-bold rounded-xl py-4 hover:bg-red-700 transition">Simpan Pengeluaran</button>
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
                showConfirmButton: false
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
                    hoverOffset: 5
                }]
            },
            options: { cutout: '75%', plugins: { legend: { display: false } } }
        });
    </script>
</body>
</html>