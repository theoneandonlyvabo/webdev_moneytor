<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Moneytor AI Assistant</title>
    <link rel="icon" href="/img/logo.png" type="image/png">
    
    <!-- Tailwind CSS (CDN for simplicity) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Markdown Parser -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    
    <!-- Custom Style for Scrollbar & Markdown -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Space Grotesk', sans-serif; }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar { -ms-overflow-style: none;  scrollbar-width: none; }

        /* Markdown Styles inside Chat Bubble */
        .prose ul { list-style-type: disc; margin-left: 1.5em; }
        .prose ol { list-style-type: decimal; margin-left: 1.5em; }
        .prose strong { color: inherit; font-weight: 700; }
        .prose p { margin-bottom: 0.5em; }
        .prose p:last-child { margin-bottom: 0; }
    </style>
</head>
<body class="bg-gray-50 h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-white/90 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50 px-4 py-3 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <a href="/" class="p-2 rounded-full hover:bg-gray-100 transition text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </a>
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center border border-green-200">
                    <!-- Icon Robot/AI -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-gray-900 text-lg leading-tight">Moneytor AI</h1>
                    <p class="text-xs text-green-600 flex items-center gap-1 font-medium">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Online
                    </p>
                </div>
            </div>
        </div>
        <!-- Clear Chat Button -->
        <button onclick="clearChat()" class="text-gray-400 hover:text-red-500 transition" title="Hapus Chat">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    </header>

    <!-- CHAT CONTAINER -->
    <main id="chat-container" class="flex-1 overflow-y-auto p-4 space-y-4 scroll-smooth">
        <!-- Welcome Bubble -->
        <div class="flex gap-3 max-w-3xl mx-auto">
            <div class="w-8 h-8 bg-green-100 rounded-full flex-shrink-0 flex items-center justify-center mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-gray-100 text-gray-800 max-w-[85%] text-sm leading-relaxed">
                Halo! Saya asisten AI Moneytor. Ada yang bisa saya bantu soal keuangan, budgeting, atau fitur aplikasi hari ini? 👋
            </div>
        </div>
    </main>

    <!-- INPUT AREA -->
    <div class="bg-white border-t border-gray-200 p-4 sticky bottom-0">
        <div class="max-w-3xl mx-auto relative">
            <form id="chat-form" class="flex items-end gap-2 bg-gray-50 border border-gray-300 rounded-2xl px-4 py-2 focus-within:ring-2 focus-within:ring-green-500 focus-within:border-transparent transition shadow-sm">
                <textarea 
                    id="user-input"
                    rows="1"
                    class="w-full bg-transparent border-0 focus:ring-0 p-2 text-gray-900 placeholder-gray-400 resize-none max-h-32 overflow-y-auto no-scrollbar"
                    placeholder="Ketik pertanyaanmu..."
                    oninput="autoResize(this)"
                    onkeydown="handleEnter(event)"
                ></textarea>
                <button type="submit" id="send-btn" class="p-2 bg-green-600 text-white rounded-full hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition mb-1 shadow-lg shadow-green-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rotate-90" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                </button>
            </form>
            <div class="text-center mt-2">
                <p class="text-[10px] text-gray-400">AI bisa saja salah. Cek kembali informasi penting.</p>
            </div>
        </div>
    </div>

    <script>
        const chatContainer = document.getElementById('chat-container');
        const chatForm = document.getElementById('chat-form');
        const userInput = document.getElementById('user-input');
        const sendBtn = document.getElementById('send-btn');

        // Auto resize textarea
        function autoResize(el) {
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
            // Reset if empty
            if(!el.value) el.style.height = 'auto';
        }

        // Handle Enter to send (Shift+Enter for new line)
        function handleEnter(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        }

        // Clear Chat
        function clearChat() {
            if(confirm('Hapus semua riwayat chat?')) {
                // Keep only first bubble
                const firstBubble = chatContainer.firstElementChild;
                chatContainer.innerHTML = '';
                chatContainer.appendChild(firstBubble);
            }
        }

        function appendMessage(role, text) {
            const isUser = role === 'user';
            
            const wrapper = document.createElement('div');
            wrapper.className = `flex gap-3 max-w-3xl mx-auto ${isUser ? 'justify-end' : ''} animate-fade-in-up`;
            
            const avatar = isUser 
                ? `<div class="w-8 h-8 bg-gray-200 rounded-full flex-shrink-0 flex items-center justify-center mt-1">
                    <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                   </div>`
                : `<div class="w-8 h-8 bg-green-100 rounded-full flex-shrink-0 flex items-center justify-center mt-1">
                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                   </div>`;

            const bubbleClass = isUser 
                ? 'bg-green-600 text-white rounded-2xl rounded-tr-none' 
                : 'bg-white border border-gray-100 text-gray-800 rounded-2xl rounded-tl-none shadow-sm prose prose-sm max-w-none';

            // Parse Markdown for Bot, Plain text for User
            const content = isUser ? text : marked.parse(text);

            wrapper.innerHTML = isUser 
                ? `<div class="${bubbleClass} px-4 py-2 shadow-md max-w-[85%] text-sm leading-relaxed">${content}</div>${avatar}`
                : `${avatar}<div class="${bubbleClass} px-4 py-3 max-w-[85%] leading-relaxed">${content}</div>`;

            chatContainer.appendChild(wrapper);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function showTyping() {
            const id = 'typing-indicator';
            const html = `
                <div id="${id}" class="flex gap-3 max-w-3xl mx-auto">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex-shrink-0 flex items-center justify-center mt-1">
                        <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-gray-100 text-gray-500 text-sm flex items-center gap-1">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
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

            // 1. Show User Message
            appendMessage('user', text);
            userInput.value = '';
            autoResize(userInput);
            sendBtn.disabled = true;

            // 2. Show Typing Indicator
            const typingId = showTyping();

            try {
                // 3. Call API
                const response = await fetch('/api/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ question: text })
                });

                const result = await response.json();

                // Remove Typing Indicator
                document.getElementById(typingId).remove();

                if (response.ok) {
                    appendMessage('bot', result.data.answer);
                } else {
                    appendMessage('bot', `**Error:** ${result.message || 'Terjadi kesalahan.'}`);
                }

            } catch (error) {
                document.getElementById(typingId).remove();
                appendMessage('bot', '**Network Error:** Gagal menghubungi server.');
                console.error(error);
            } finally {
                sendBtn.disabled = false;
                userInput.focus();
            }
        });
    </script>
</body>
</html>
```

### 2. Update Route buat nampilin view ini

Buka **`routes/web.php`** (BUKAN `api.php`), tambahin route ini biar lo bisa akses UI-nya di browser:

```php
// routes/web.php
use Illuminate\Support\Facades\Route;

Route::get('/chat', function () {
    return view('chat');
});