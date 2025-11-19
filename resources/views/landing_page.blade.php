<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Moneytor | Gacorkan Cuanmu</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    {{-- Kalau masih ada masalah Vite, bisa comment baris @vite dan uncomment CDN di bawah --}}
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    <style>
        body { font-family: 'Inter', sans-serif; }
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
<body class="antialiased bg-gray-50 text-gray-800">

    <!-- Header Navigasi -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <img src="/img/logo.png" alt="Moneytor Logo" class="h-8 w-auto">
                    <span class="font-bold text-xl tracking-tight text-gray-900">Moneytor</span>
                </div>

                <!-- Tombol Header Navigasi -->
                <div class="hidden md:flex space-x-8">
                    <a href="#fitur" class="text-gray-600 hover:text-green-600 font-medium transition">Fitur Web</a>
                    <a href="#framework" class="text-gray-600 hover:text-green-600 font-medium transition">Framework</a>
                    <a href="#team" class="text-gray-600 hover:text-green-600 font-medium transition">Team Kami</a>
                </div>

                <!-- Tombol Login -->
                <div class="flex items-center gap-4">
                    <a href="#" class="text-sm font-medium text-gray-600 hover:text-gray-900">Log in</a>
                    <a href="#" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-full hover:bg-green-700 transition shadow-lg shadow-green-500/30">
                       Buka Moneytor Web
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
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-cyan-500">cuanmu kabur.</span>
                </h1>
                <p class="mt-4 text-xl text-gray-500 mb-8 leading-relaxed">
                    Moneytor memberi Anda kejelasan yang Anda butuhkan untuk melacak pengeluaran, mematuhi anggaran, dan menumbuhkan tabungan dengan mudah.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#" class="px-8 py-4 text-lg font-bold text-white bg-green-600 rounded-xl hover:bg-green-700 transition shadow-xl shadow-green-500/30 transform hover:-translate-y-1">
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

            <!-- Preview Dashboard -->
            <div class="mt-16 relative max-w-5xl mx-auto">
                <div class="absolute -top-10 -left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute -top-10 -right-10 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-20 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
                
                <div class="relative rounded-2xl bg-gray-900 p-2 shadow-2xl ring-1 ring-gray-900/10">
                    <div class="rounded-xl bg-white overflow-hidden">
                        <!-- Header mockup -->
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50">
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <div class="text-xs text-gray-400 font-mono">dashboard.moneytor.app</div>
                        </div>
                        <!-- Konten mockup -->
                        <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Sidebar mockup -->
                            <div class="hidden md:block col-span-1 space-y-4">
                                <div class="h-8 bg-gray-100 rounded-lg w-3/4"></div>
                                <div class="h-8 bg-green-50 rounded-lg w-full border-l-4 border-green-500"></div>
                                <div class="h-8 bg-gray-100 rounded-lg w-5/6"></div>
                                <div class="h-40 bg-gray-50 rounded-xl mt-8"></div>
                            </div>
                            <!-- Main content mockup -->
                            <div class="col-span-2 space-y-6">
                                <div class="flex justify-between items-end">
                                    <div>
                                        <div class="h-4 bg-gray-200 rounded w-24 mb-2"></div>
                                        <div class="h-10 bg-gray-800 rounded w-48"></div>
                                    </div>
                                    <div class="h-10 w-10 bg-green-100 rounded-full"></div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="h-24 bg-green-50 rounded-xl border border-green-100"></div>
                                    <div class="h-24 bg-red-50 rounded-xl border border-red-100"></div>
                                    <div class="h-24 bg-blue-50 rounded-xl border border-blue-100"></div>
                                </div>
                                <div class="h-48 bg-gray-50 rounded-xl border border-gray-100 flex items-end justify-around p-4 pb-0">
                                    <div class="w-8 bg-green-200 rounded-t-lg h-20"></div>
                                    <div class="w-8 bg-green-300 rounded-t-lg h-32"></div>
                                    <div class="w-8 bg-green-500 rounded-t-lg h-40"></div>
                                    <div class="w-8 bg-green-300 rounded-t-lg h-28"></div>
                                    <div class="w-8 bg-green-200 rounded-t-lg h-24"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-green-600 font-bold tracking-wide uppercase text-sm">Features</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Semua yang Anda butuhkan untuk mengelola keuangan Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-green-600 to-blue-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative px-7 py-8 bg-white ring-1 ring-gray-900/5 rounded-xl leading-none flex items-top justify-start space-x-6">
                        <div class="space-y-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 3.666A5.976 5.976 0 013 12a5.976 5.976 0 013.386-5.25m9.96 0A5.978 5.978 0 0121 12c0 3.314-2.686 6-6 6a5.976 5.976 0 01-5.364-2.955" />
                                </svg>
                            </div>
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
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
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
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Bank-Level Security</h3>
                            <p class="text-gray-500 leading-relaxed">Your financial data is encrypted and secure. We prioritize your privacy above all else.</p>
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
                <a href="#" class="px-8 py-4 bg-white text-green-600 font-bold rounded-xl shadow-lg hover:bg-gray-50 transition">
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
                    <div class="w-6 h-6 bg-green-500 rounded flex items-center justify-center text-white text-xs font-bold">M</div>
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

</body>
</html>