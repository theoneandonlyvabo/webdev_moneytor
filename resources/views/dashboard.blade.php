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
    
    <!-- Config Tailwind Custom Colors -->
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
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background-color: #e2e8f0; border-radius: 20px; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Prose Overrides for Chat */
        .prose p { margin-bottom: 0.5em; }
        .prose p:last-child { margin-bottom: 0; }
        .prose ul { list-style-type: disc; padding-left: 1.2em; }
        
        /* Animations */
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>
</head>
<body class="bg-gray-50 h-screen flex flex-col overflow-hidden text-slate-800 font-sans">

    <!-- HEADER -->
    <header class="bg-white/80 backdrop-blur-lg border-b border-gray-200 sticky top-0 z-50 h-16 flex items-center justify-between px-6 shadow-sm">
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
            
            <!-- Chat History -->
            <div id="chat-container" class="flex-1 overflow-y-auto p-6 space-y-6 scroll-smooth">
                <!-- Welcome Bubble -->
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

            <!-- Input Area -->
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
                    
                    <!-- Balance Card (Compacted Height) -->
                    <!-- Changed py-6 to py-4, reduced margin top inside -->
                    <div class="col-span-12 bg-slate-900 rounded-2xl py-5 px-6 text-white shadow-xl shadow-slate-900/10 relative overflow-hidden group">
                        <!-- Abstract BG -->
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

                        <!-- Reduced margin top from mt-8 to mt-5 -->
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

                    <!-- Quick Actions (Small Cards) -->
                    <div class="col-span-12 grid grid-cols-2 gap-4">
                        <button class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-brand-500 hover:ring-1 hover:ring-brand-500 transition group shadow-sm hover:shadow-md">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-brand-50 rounded-lg flex items-center justify-center group-hover:bg-brand-500 transition duration-300">
                                    <svg class="w-5 h-5 text-brand-600 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="font-bold text-slate-900 text-sm">Input Income</p>
                                    <p class="text-xs text-gray-500">Catat pemasukan</p>
                                </div>
                            </div>
                        </button>
                        <button class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:ring-1 hover:ring-red-500 transition group shadow-sm hover:shadow-md">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center group-hover:bg-red-500 transition duration-300">
                                    <svg class="w-5 h-5 text-red-600 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="font-bold text-slate-900 text-sm">Input Expense</p>
                                    <p class="text-xs text-gray-500">Catat pengeluaran</p>
                                </div>
                            </div>
                        </button>
                    </div>

                    <!-- Left Column: Spending Chart -->
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

                    <!-- Right Column: Recent Transactions -->
                    <div class="col-span-12 md:col-span-7 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-slate-900">Recent Activity</h3>
                            <a href="#" class="text-xs text-brand-600 font-medium hover:underline">View All</a>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Item 1 -->
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

                            <!-- Item 2 -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center group-hover:bg-blue-100 transition">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">Listrik Token</p>
                                        <p class="text-xs text-gray-400">Yesterday</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-slate-900">- Rp 500.000</span>
                            </div>

                            <!-- Item 3 -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-brand-50 text-brand-600 rounded-full flex items-center justify-center group-hover:bg-brand-100 transition">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">Gaji November</p>
                                        <p class="text-xs text-gray-400">1 Nov 2025</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-brand-600">+ Rp 15.000.000</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <script>
        // Set Date
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

        // Chat Logic
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

            // Updated AI Name to Gyro
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

            // Simulate API Call (Replace with real fetch)
            try {
                // Mock delay
                await new Promise(r => setTimeout(r, 1500));
                
                // Remove typing indicator
                document.getElementById(typingId).remove();
                
                // Mock Response
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

        // Chart Config
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