<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/img/logo.png" type="image/png">
    <title>Moneytor #ANTIRUNGKAD</title>

    <!-- Scripts -->
    {{-- Kalau masih ada masalah Vite, bisa comment baris @vite dan uncomment CDN di bawah --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    <style>
        /* Animasi blob background */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</head>
<!-- CLASS PENTING: "font-sans" di sini menghubungkan ke font Space Grotesk di app.css -->
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <!-- Header Navigasi -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <img src="/img/logo.png" alt="Moneytor Logo" class="h-7 w-auto">
                    <span class="font-bold text-xl tracking-tight text-gray-900">Moneytor</span>
                </div>

                <!-- Tombol Header Navigasi -->
                <div class="hidden md:flex space-x-8">
                    <a href="#news" class="text-gray-600 hover:text-purple-600 font-medium transition">Berita</a>
                    <a href="#fitur" class="text-gray-600 hover:text-green-600 font-medium transition">Fitur Web</a>
                    <a href="#framework" class="text-gray-600 hover:text-blue-600 font-medium transition">Arsitektur</a>
                    <a href="#team" class="text-gray-600 hover:text-orange-600 font-medium transition">Team Kami</a>
                </div>

                <!-- Tombol Login -->
                <div class="flex items-center gap-4">
                    <a href="#" class="text-sm font-medium text-gray-600 hover:text-gray-900">Log in</a>
                    <a href="{{ route('dashboard.show') }}" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-full hover:bg-green-700 transition shadow-lg shadow-green-500/30">
                        Buka Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center px-3 py-1 rounded-full border border-green-100 bg-green-50 text-green-600 text-xs font-semibold tracking-wide uppercase mb-6">
                    <span class="w-2 h-2 bg-green-600 rounded-full mr-2 animate-pulse"></span>
                    New: Analisis Pengeluaran AI
                </div>
                <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 mb-6 leading-tight">
                    Stop menerawang ke mana <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-400">cuanmu kabur.</span>
                </h1>
                <p class="mt-4 text-xl text-gray-500 mb-8 leading-relaxed">
                    Moneytor memberi Anda kejelasan yang Anda butuhkan untuk melacak pengeluaran, mematuhi anggaran, dan menumbuhkan tabungan dengan mudah.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('dashboard.show') }}" class="px-8 py-4 text-lg font-bold text-white bg-green-600 rounded-xl hover:bg-green-700 transition shadow-xl shadow-green-500/30 transform hover:-translate-y-1">
                        Mulai Sekarang
                    </a>
                    <a href="#demo" class="px-8 py-4 text-lg font-bold text-green-700 bg-white border border-green-100 rounded-xl hover:bg-green-50 transition flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        Tonton Demo
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-30 bg-gradient-to-t from-black/25 to-transparent pointer-events-none"></div>
    </section>

    <!-- News Slider Section -->
    <section id="news" class="py-16 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Ingfo Terkini Maseh</h2>
            </div>

            <!-- Slider Container -->
            <div class="relative w-full rounded-2xl overflow-hidden shadow-2xl group">
                <!-- Navigation Buttons (Inside Container) -->
                <button id="btn-prev" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white hover:bg-white hover:text-green-600 transition-all duration-300 shadow-lg opacity-0 group-hover:opacity-100 translate-x-[-10px] group-hover:translate-x-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <button id="btn-next" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white hover:bg-white hover:text-green-600 transition-all duration-300 shadow-lg opacity-0 group-hover:opacity-100 translate-x-[10px] group-hover:translate-x-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                </button>

                <!-- Inner Track -->
                <div id="slider-track" class="flex w-full transition-transform duration-700 ease-in-out h-[400px] md:h-[500px]">
                    <!-- Slide 1 -->
                    <div class="min-w-full w-full shrink-0 relative h-full">
                        <img src="/img/news-1.jpg" onerror="this.src='https://monitorday.com/wp-content/uploads/2025/04/Nvidia.jpg'" class="w-full h-full object-cover brightness-75 group-hover:scale-105 transition duration-700">
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/50 to-transparent p-8 md:p-12">
                            <span class="inline-block px-3 py-1 mb-3 text-xs font-bold tracking-wider text-green-900 uppercase bg-green-400 rounded-full">Berita Baru</span>
                            <h3 class="text-3xl md:text-4xl font-bold text-white mb-2">Saham NVDA Tembus USD $200!</h3>
                            <p class="text-gray-200 text-lg line-clamp-2">Pelajari metode 50/30/20 yang telah terbukti membantu ribuan orang mencapai kebebasan finansial lebih cepat.</p>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="min-w-full w-full shrink-0 relative h-full">
                        <img src="/img/news-2.jpg" onerror="this.src='https://assets-a1.kompasiana.com/items/album/2020/07/03/imageforentry1-enb-5efed00d097f3678616f97a2.jpg'" class="w-full h-full object-cover brightness-75 group-hover:scale-105 transition duration-700">
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/50 to-transparent p-8 md:p-12">
                            <span class="inline-block px-3 py-1 mb-3 text-xs font-bold tracking-wider text-indigo-900 uppercase bg-indigo-400 rounded-full">Fitur Baru</span>
                            <h3 class="text-3xl md:text-4xl font-bold text-white mb-2">Analisis Pengeluaran Berbasis AI Kini Hadir</h3>
                            <p class="text-gray-200 text-lg line-clamp-2">Moneytor kini bisa memprediksi kebocoran anggaranmu sebelum terjadi menggunakan teknologi AI terbaru.</p>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="min-w-full w-full shrink-0 relative h-full">
                        <img src="/img/news-3.jpg" onerror="this.src='https://images.wallpapersden.com/image/download/cybersecurity-core_bmdrZ2mUmZqaraWkpJRmbmdsrWZlbWU.jpg'" class="w-full h-full object-cover brightness-75 group-hover:scale-105 transition duration-700">
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/50 to-transparent p-8 md:p-12">
                            <span class="inline-block px-3 py-1 mb-3 text-xs font-bold tracking-wider text-orange-900 uppercase bg-orange-400 rounded-full">Keamanan</span>
                            <h3 class="text-3xl md:text-4xl font-bold text-white mb-2">Data Anda Aman dengan Enkripsi Bank-Level</h3>
                            <p class="text-gray-200 text-lg line-clamp-2">Kami meningkatkan protokol keamanan kami untuk memastikan privasi data keuangan Anda adalah prioritas nomor satu.</p>
                        </div>
                    </div>
                </div>

                <!-- Dots -->
                <div class="absolute bottom-6 right-8 flex space-x-2 z-20">
                    <button id="dot-0" class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition"></button>
                    <button id="dot-1" class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition"></button>
                    <button id="dot-2" class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section id="fitur" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-green-600 font-bold tracking-wide uppercase text-sm">Fitur</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Km jgn tkt lg khilangan money yh...
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-green-600 to-blue-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative px-7 py-8 bg-white ring-1 ring-gray-900/5 rounded-xl leading-none flex items-top justify-start space-x-6">
                        <div class="space-y-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 3.666A5.976 5.976 0 013 12a5.976 5.976 0 013.386-5.25m9.96 0A5.978 5.978 0 0121 12c0 3.314-2.686 6-6 6a5.976 5.976 0 01-5.364-2.955" /></svg></div>
                            <h3 class="text-xl font-bold text-gray-900">Smart Budgeting</h3>
                            <p class="text-gray-500 leading-relaxed">Set limits for specific categories like food or transport. We'll notify you before you overspend.</p>
                        </div>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative px-7 py-8 bg-white ring-1 ring-gray-900/5 rounded-xl leading-none flex items-top justify-start space-x-6">
                        <div class="space-y-4">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg></div>
                            <h3 class="text-xl font-bold text-gray-900">Visual Analytics</h3>
                            <p class="text-gray-500 leading-relaxed">Understand your spending habits instantly with beautiful, easy-to-read charts and graphs.</p>
                        </div>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative px-7 py-8 bg-white ring-1 ring-gray-900/5 rounded-xl leading-none flex items-top justify-start space-x-6">
                        <div class="space-y-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg></div>
                            <h3 class="text-xl font-bold text-gray-900">Bank-Level Security</h3>
                            <p class="text-gray-500 leading-relaxed">Your financial data is encrypted and secure. We prioritize your privacy above all else.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Stack Section (New) -->
    <section id="framework" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-blue-600 font-bold tracking-wide uppercase text-sm">Arsitektur Web</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Dibalik Layar Moneytor
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Aplikasi ini dibangun dengan kombinasi teknologi modern yang menjamin kecepatan, keamanan, dan skalabilitas.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <!-- Laravel -->
                <div class="flex flex-col items-center p-6 bg-white rounded-2xl hover:shadow-lg transition duration-300 border border-transparent hover:border-red-100 group">
                    <div class="h-16 w-16 mb-4 flex items-center justify-center bg-gray-50 rounded-xl shadow-sm group-hover:scale-110 transition duration-300">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" alt="Laravel" class="h-10 w-10">
                    </div>
                    <h3 class="font-bold text-gray-900">Laravel 10</h3>
                    <p class="text-sm text-gray-500 mt-1">Framework Backend</p>
                </div>

                <!-- MySQL -->
                <div class="flex flex-col items-center p-6 bg-white rounded-2xl hover:shadow-lg transition duration-300 border border-transparent hover:border-blue-100 group">
                    <div class="h-16 w-16 mb-4 flex items-center justify-center bg-gray-50 rounded-xl shadow-sm group-hover:scale-110 transition duration-300">
                         <img src="https://www.vectorlogo.zone/logos/mysql/mysql-icon.svg" alt="MySQL" class="h-10 w-10">
                    </div>
                    <h3 class="font-bold text-gray-900">MySQL</h3>
                    <p class="text-sm text-gray-500 mt-1">Manajemen Database</p>
                </div>

                <!-- Tailwind -->
                <div class="flex flex-col items-center p-6 bg-white rounded-2xl hover:shadow-lg transition duration-300 border border-transparent hover:border-cyan-100 group">
                    <div class="h-16 w-16 mb-4 flex items-center justify-center bg-gray-50 rounded-xl shadow-sm group-hover:scale-110 transition duration-300">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d5/Tailwind_CSS_Logo.svg" alt="Tailwind" class="h-8 w-auto">
                    </div>
                    <h3 class="font-bold text-gray-900">Tailwind</h3>
                    <p class="text-sm text-gray-500 mt-1">Styling Frontend</p>
                </div>

                 <!-- Vite -->
                 <div class="flex flex-col items-center p-6 bg-white rounded-2xl hover:shadow-lg transition duration-300 border border-transparent hover:border-purple-100 group">
                    <div class="h-16 w-16 mb-4 flex items-center justify-center bg-gray-50 rounded-xl shadow-sm group-hover:scale-110 transition duration-300">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/Vitejs-logo.svg" alt="Vite" class="h-10 w-10">
                    </div>
                    <h3 class="font-bold text-gray-900">Vite</h3>
                    <p class="text-sm text-gray-500 mt-1">Alat Frontend</p>
                </div>

                <!-- OpenAI -->
                <div class="flex flex-col items-center p-6 bg-white rounded-2xl hover:shadow-lg transition duration-300 border border-transparent hover:border-green-100 group">
                    <div class="h-16 w-16 mb-4 flex items-center justify-center bg-gray-50 rounded-xl shadow-sm group-hover:scale-110 transition duration-300">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQS3PwERLLNB9XKFpeMgAMPxl5VvN3HRJnXQQ&s" alt="OpenAI" class="h-10 w-10">
                    </div>
                    <h3 class="font-bold text-gray-900">OpenAI</h3>
                    <p class="text-sm text-gray-500 mt-1">Mesin Kecerdasan AI</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section (UPDATED: 4 Columns) -->
    <section id="team" class="py-24 bg-white relative overflow-hidden">
        <!-- Decorative Blobs -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-64 h-64 bg-orange-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute bottom-20 right-10 w-64 h-64 bg-orange-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-orange-600 font-bold tracking-wide uppercase text-sm">TEAM APEX 30</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Izin Perkenalan Diri 🙏
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Kami adalah tim kecil dengan mimpi besar untuk merevolusi cara Anda mengatur keuangan.
                </p>
            </div>

            <!-- Grid Updated: lg:grid-cols-4 untuk 4 sejajar di layar besar -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Team Member 1 -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl blur opacity-0 group-hover:opacity-75 transition duration-500"></div>
                    <div class="relative bg-white rounded-2xl overflow-hidden shadow-lg h-full flex flex-col">
                        <div class="h-64 overflow-hidden relative">
                            <img src="/img/team/vano.png" alt="Vano" class="w-full h-full object-cover object-top transform group-hover:scale-110 transition duration-700 ease-out">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-4 backdrop-blur-sm">
                                <a href="#" class="p-2 bg-white rounded-full text-gray-900 hover:bg-green-500 hover:text-white transition transform hover:-translate-y-1"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg></a>
                                <a href="#" class="p-2 bg-white rounded-full text-gray-900 hover:bg-blue-600 hover:text-white transition transform hover:-translate-y-1"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"/></svg></a>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col items-center text-center relative bg-white">
                            <h3 class="text-xl font-bold text-gray-900">Airel Adrivano</h3>
                            <p class="text-green-600 font-medium mb-3">2410512135</p>
                            <p class="text-gray-500 text-sm">"If you wanna make history, you gotta call your own shots.<br>-Lebron James"</p>
                        </div>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl blur opacity-0 group-hover:opacity-75 transition duration-500"></div>
                    <div class="relative bg-white rounded-2xl overflow-hidden shadow-lg h-full flex flex-col">
                        <div class="h-64 overflow-hidden relative">
                            <img src="/img/team/dafit.png" alt="Dafit" class="w-full h-full object-cover object-top transform group-hover:scale-110 transition duration-700 ease-out">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-4 backdrop-blur-sm">
                                <a href="#" class="p-2 bg-white rounded-full text-gray-900 hover:bg-blue-600 hover:text-white transition transform hover:-translate-y-1"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"/></svg></a>
                                <a href="#" class="p-2 bg-white rounded-full text-gray-900 hover:bg-gray-800 hover:text-white transition transform hover:-translate-y-1"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg></a>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col items-center text-center relative bg-white">
                            <h3 class="text-xl font-bold text-gray-900">Daffa Fitriano Arisandi</h3>
                            <p class="text-indigo-600 font-medium mb-3">2410512125</p>
                            <p class="text-gray-500 text-sm">"Belom ngisi quotes hehe"</p>
                        </div>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl blur opacity-0 group-hover:opacity-75 transition duration-500"></div>
                    <div class="relative bg-white rounded-2xl overflow-hidden shadow-lg h-full flex flex-col">
                        <div class="h-64 overflow-hidden relative">
                            <img src="/img/team/bagas.png" alt="Bagas" class="w-full h-full object-cover object-top transform group-hover:scale-110 transition duration-700 ease-out">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-4 backdrop-blur-sm">
                                <a href="#" class="p-2 bg-white rounded-full text-gray-900 hover:bg-pink-600 hover:text-white transition transform hover:-translate-y-1"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.46 3.052c.636-.247 1.363-.416 2.427-.465C8.901 2.534 9.256 2.52 11.685 2.52h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/></svg></a>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col items-center text-center relative bg-white">
                            <h3 class="text-xl font-bold text-gray-900">M. Bagas Farshaldy</h3>
                            <p class="text-purple-600 font-medium mb-3">2410512136</p>
                            <p class="text-gray-500 text-sm">"Belom ngisi quotes hehe"</p>
                        </div>
                    </div>
                </div>

                <!-- Team Member 4 (NEW: Dewi Larasati) -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl blur opacity-0 group-hover:opacity-75 transition duration-500"></div>
                    <div class="relative bg-white rounded-2xl overflow-hidden shadow-lg h-full flex flex-col">
                        <div class="h-64 overflow-hidden relative">
                        <img src="/img/team/ali.png" alt="Ali" class="w-full h-full object-cover object-top transform group-hover:scale-110 transition duration-700 ease-out">    
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-4 backdrop-blur-sm">
                                <a href="#" class="p-2 bg-white rounded-full text-gray-900 hover:bg-orange-500 hover:text-white transition transform hover:-translate-y-1"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg></a>
                                <a href="#" class="p-2 bg-white rounded-full text-gray-900 hover:bg-blue-600 hover:text-white transition transform hover:-translate-y-1"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"/></svg></a>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col items-center text-center relative bg-white">
                            <h3 class="text-xl font-bold text-gray-900">Ali Mahdi Muhtiar</h3>
                            <p class="text-orange-600 font-medium mb-3">2410512147</p>
                            <p class="text-gray-500 text-sm">"Belom ngisi quotes hehe"</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-green-700 relative overflow-hidden">
        <div class="absolute inset-0">
            <svg class="h-full w-full opacity-10" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
            </svg>
        </div>
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-24 lg:px-8 relative z-10 flex flex-col lg:flex-row items-center justify-between">
            <div class="text-center lg:text-left mb-8 lg:mb-0">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">Yuk, Tor Monitor Sekarang!</span>
                    <span class="block text-green-200">Gunakan Moneytor hari ini.</span>
                </h2>
                <p class="mt-4 text-lg text-green-200 max-w-xl">
                    Bergabung dengan 0 user lainnya dalam memantau cuan kesayanganmu.
                </p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('dashboard.show') }}" class="px-8 py-4 bg-white text-green-600 font-bold rounded-xl shadow-lg hover:bg-gray-50 transition">
                    Mulai Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <img src="/img/logo.png" alt="Moneytor Logo" class="h-6 w-auto">
                    <span class="text-white font-bold text-lg">Moneytor</span>
                </div>
                <p class="text-sm text-gray-400">Membuat kebebasan finansial dapat diakses oleh semua orang, di mana saja.</p>
            </div>  
            <div>
                <h4 class="text-white font-semibold mb-4">Produk</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition">Fitur</a></li>
                    <li><a href="#" class="hover:text-white transition">Kebijakan</a></li>
                    <li><a href="#" class="hover:text-white transition">Integrasi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Perusahaan</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition">Tentang</a></li>
                    <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    <li><a href="#" class="hover:text-white transition">Karir</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Legal</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition">Privasi</a></li>
                    <li><a href="#" class="hover:text-white transition">Syarat</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-800 text-center text-xs text-gray-500">
            &copy; All rights to Pt. Apexindo 30 Sukses Tbk.
        </div>
    </footer>

    <!-- Script Slider Sederhana (Diperbaiki) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentSlide = 0;
            const totalSlides = 3;
            const track = document.getElementById('slider-track');
            const dots = document.querySelectorAll('.slider-dot');
            
            // Tombol Navigasi
            const btnPrev = document.getElementById('btn-prev');
            const btnNext = document.getElementById('btn-next');

            // Fungsi Update Posisi Slider
            window.updateSlider = function() {
                // Geser track (Translasi negatif berdasarkan width container 100%)
                track.style.transform = `translateX(-${currentSlide * 100}%)`;
                
                // Update dots active state
                dots.forEach((dot, index) => {
                    if (index === currentSlide) {
                        dot.classList.remove('bg-white/50');
                        dot.classList.add('bg-white', 'scale-125');
                    } else {
                        dot.classList.add('bg-white/50');
                        dot.classList.remove('bg-white', 'scale-125');
                    }
                });
            }

            window.nextSlide = function() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }

            window.prevSlide = function() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSlider();
            }

            window.goToSlide = function(index) {
                currentSlide = index;
                updateSlider();
            }

            // Event Listeners untuk tombol panah
            if(btnNext) btnNext.addEventListener('click', nextSlide);
            if(btnPrev) btnPrev.addEventListener('click', prevSlide);

            // Event Listeners untuk dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => goToSlide(index));
            });

            // Initialize first state
            updateSlider();

            // Auto slide setiap 5 detik
            setInterval(nextSlide, 5000);
        });
    </script>

</body>
</html>