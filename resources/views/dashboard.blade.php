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
</head>

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

                <!-- Tombol Kembali -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('home.show') }}" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-full hover:bg-green-700 transition shadow-lg shadow-green-500/30">
                        Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </nav>

<!-- Plalceholder Gambar -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <img src="/img/placeholder.png" alt="Hehe abar yak" class="mx-auto h-100 w-auto block">
            </div>
        </div>
    </section>
</body>
</html>