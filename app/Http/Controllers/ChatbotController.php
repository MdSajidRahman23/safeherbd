<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class ChatbotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display chatbot interface
     */
    public function index()
    {
        $chatHistories = ChatHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('chatbot.index', compact('chatHistories'));
    }

    /**
     * Send message to chatbot via API
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'session_id' => 'nullable|string',
        ]);

        $userMessage = $request->input('message');
        $sessionId = $request->input('session_id') ?? uniqid('chat_');

        // Call OpenAI or mock chatbot
        $botReply = $this->getBotReply($userMessage);

        // Save to database
        $chatHistory = ChatHistory::create([
            'user_id' => Auth::id(),
            'message' => $userMessage,
            'bot_reply' => $botReply,
            'session_id' => $sessionId,
        ]);

        return response()->json([
            'success' => true,
            'session_id' => $sessionId,
            'bot_reply' => $botReply,
            'timestamp' => $chatHistory->created_at->format('H:i:s'),
        ], Response::HTTP_CREATED);
    }

    /**
     * Get chatbot response (using mock or OpenAI)
     */
    private function getBotReply(string $userMessage): string
    {
        $apiKey = env('OPENAI_API_KEY');

        if ($apiKey && $apiKey !== 'your-openai-api-key') {
            return $this->getOpenAIReply($userMessage, $apiKey);
        }

        // Mock response for testing
        return $this->getMockBotReply($userMessage);
    }

    /**
     * Get response from OpenAI API
     */
    private function getOpenAIReply(string $userMessage, string $apiKey): string
    {
        try {
            $client = \OpenAI\Client::factory()
                ->withApiKey($apiKey)
                ->make();

            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a compassionate mental health support bot for women. Provide supportive, non-judgmental advice. If the user is in crisis, encourage them to seek professional help.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage
                    ]
                ],
                'max_tokens' => 500,
                'temperature' => 0.7,
            ]);

            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            \Log::error('OpenAI API Error: ' . $e->getMessage());
            return $this->getMockBotReply($userMessage);
        }
    }

    /**
     * Mock chatbot response for testing
     */
    private function getMockBotReply(string $userMessage): string
    {
        $responses = [
            'help' => 'I\'m here to help! You can talk to me about anything. What\'s on your mind?',
            'unsafe' => 'I\'m sorry to hear that. Your safety is important. Please reach out to local authorities or a trusted person if you\'re in immediate danger.',
            'health' => 'Taking care of your mental health is important. Remember to practice self-care and seek professional help if needed.',
            'support' => 'You\'re not alone. There are many resources available. Would you like me to share some helpful contacts?',
            'hello' => 'Hello! I\'m here to support you. How can I help today?',
            'hi' => 'Hi there! It\'s great to see you. What can I assist you with?',
        ];

        $lowerMessage = strtolower($userMessage);
        
        foreach ($responses as $keyword => $response) {
            if (str_contains($lowerMessage, $keyword)) {
                return $response;
            }
        }

        return 'Thank you for sharing. I\'m listening and here to support you. Can you tell me more about how you\'re feeling?';
    }

    /**
     * Get chat history
     */
    public function getHistory(Request $request)
    {
        $histories = ChatHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        return response()->json($histories);
    }

    /**
     * Clear chat history
     */
    public function clearHistory(Request $request)
    {
        ChatHistory::where('user_id', Auth::id())->delete();

        return response()->json(['success' => true, 'message' => 'Chat history cleared.']);
    }
}
