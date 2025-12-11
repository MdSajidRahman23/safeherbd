<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mental Health Chatbot') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <!-- Chat Messages Area -->
                <div id="chat-messages" class="h-96 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-700 space-y-4">
                    @foreach($chatHistories as $chat)
                        <!-- User Message -->
                        <div class="flex justify-end">
                            <div class="max-w-xs bg-blue-500 text-white rounded-lg px-4 py-2">
                                <p class="text-sm">{{ $chat->message }}</p>
                                <span class="text-xs text-blue-100 mt-1 block">{{ $chat->created_at->format('H:i') }}</span>
                            </div>
                        </div>

                        <!-- Bot Reply -->
                        @if($chat->bot_reply)
                            <div class="flex justify-start">
                                <div class="max-w-xs bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2">
                                    <p class="text-sm">{{ $chat->bot_reply }}</p>
                                    <span class="text-xs text-gray-600 dark:text-gray-400 mt-1 block">{{ $chat->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    @if($chatHistories->isEmpty())
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            <p class="text-lg mb-2">👋 Welcome to SafeHer Mental Health Support</p>
                            <p class="text-sm">Start a conversation and I'll be here to listen and support you.</p>
                        </div>
                    @endif
                </div>

                <!-- Chat Input Area -->
                <div class="border-t border-gray-200 dark:border-gray-600 p-6 bg-white dark:bg-gray-800">
                    <form id="chat-form" class="flex gap-2">
                        @csrf
                        <input 
                            type="text" 
                            id="message-input" 
                            name="message" 
                            placeholder="Type your message..." 
                            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                            required
                        >
                        <button 
                            type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition"
                        >
                            Send
                        </button>
                    </form>
                    
                    <div class="mt-4 flex gap-2">
                        <button 
                            type="button"
                            onclick="clearChatHistory()"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded text-sm transition"
                        >
                            Clear History
                        </button>
                        <button 
                            type="button"
                            onclick="requestHumanSupport()"
                            class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded text-sm transition"
                        >
                            Request Human Support
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Help Section -->
            <div class="mt-8 bg-blue-50 dark:bg-blue-900 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">💡 Tips for Getting Help</h3>
                <ul class="text-gray-700 dark:text-gray-300 space-y-2 text-sm">
                    <li>• Be honest and open about your feelings</li>
                    <li>• If you're in immediate danger, contact emergency services (999)</li>
                    <li>• Remember that this bot provides support, not medical treatment</li>
                    <li>• Consider reaching out to a professional counselor</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const chatMessages = document.getElementById('chat-messages');

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = messageInput.value.trim();
            
            if (!message) return;

            // Add user message to chat
            const userMessageEl = document.createElement('div');
            userMessageEl.className = 'flex justify-end';
            userMessageEl.innerHTML = `
                <div class="max-w-xs bg-blue-500 text-white rounded-lg px-4 py-2">
                    <p class="text-sm">${message}</p>
                    <span class="text-xs text-blue-100 mt-1 block">${new Date().toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'})}</span>
                </div>
            `;
            chatMessages.appendChild(userMessageEl);

            // Clear input
            messageInput.value = '';

            // Show typing indicator
            const typingEl = document.createElement('div');
            typingEl.className = 'flex justify-start';
            typingEl.id = 'typing-indicator';
            typingEl.innerHTML = `
                <div class="max-w-xs bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-3">
                    <p class="text-sm">
                        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: currentColor; animation: bounce 1.4s infinite;"></span>
                        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: currentColor; animation: bounce 1.4s infinite; animation-delay: 0.2s;"></span>
                        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: currentColor; animation: bounce 1.4s infinite; animation-delay: 0.4s;"></span>
                    </p>
                </div>
            `;
            chatMessages.appendChild(typingEl);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            try {
                const response = await fetch('{{ route("chatbot.send-message") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();

                // Remove typing indicator
                typingEl.remove();

                // Add bot reply
                const botReplyEl = document.createElement('div');
                botReplyEl.className = 'flex justify-start';
                botReplyEl.innerHTML = `
                    <div class="max-w-xs bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2">
                        <p class="text-sm">${data.bot_reply}</p>
                        <span class="text-xs text-gray-600 dark:text-gray-400 mt-1 block">${data.timestamp}</span>
                    </div>
                `;
                chatMessages.appendChild(botReplyEl);
                chatMessages.scrollTop = chatMessages.scrollHeight;

            } catch (error) {
                console.error('Error:', error);
                typingEl.remove();
                const errorEl = document.createElement('div');
                errorEl.className = 'flex justify-start';
                errorEl.innerHTML = `
                    <div class="max-w-xs bg-red-200 text-red-800 rounded-lg px-4 py-2">
                        <p class="text-sm">Sorry, there was an error. Please try again.</p>
                    </div>
                `;
                chatMessages.appendChild(errorEl);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });

        function clearChatHistory() {
            if (confirm('Are you sure you want to clear all chat history?')) {
                fetch('{{ route("chatbot.clear-history") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(() => {
                    location.reload();
                });
            }
        }

        function requestHumanSupport() {
            alert('Thank you for reaching out. A human counselor will contact you soon. Please ensure your contact number is updated in your profile.');
            // In a real implementation, this would create a support ticket
        }

        // Scroll to bottom on load
        window.addEventListener('load', () => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });

        // Add bounce animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes bounce {
                0%, 80%, 100% { transform: scale(1); opacity: 1; }
                40% { transform: scale(1.2); opacity: 0.8; }
            }
        `;
        document.head.appendChild(style);
    </script>
</x-app-layout>
