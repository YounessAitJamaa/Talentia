<!-- resources/views/messages/chat.blade.php -->

<x-app-layout>

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-3xl mx-auto">

        <!-- Chat Header -->
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-xl font-semibold text-gray-700">Conversation avec {{ $receiver->name }}</h4>
        </div>

        <!-- Messages List -->
        <div class="space-y-4 max-h-96 overflow-y-auto p-2 bg-gray-50 rounded-lg mb-4">
            @foreach($messages as $message)
                <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs {{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black' }} p-3 rounded-lg">
                        <p>{{ $message->content }}</p>
                        <span class="block text-sm text-gray-500">{{ $message->created_at->format('H:i') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Message Input Area -->
        <div class="flex items-center space-x-2">
            <form action="{{ route('messages.send') }}" method="POST" class="w-full">
                @csrf
                <input 
                    type="text" 
                    name="content" 
                    class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Tapez un message..." 
                    required
                />
                <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                <button type="submit" class="bg-blue-500 text-white p-3 rounded-lg ml-2 hover:bg-blue-600 focus:outline-none">
                    Envoyer
                </button>
            </form>
        </div>

    </div>
</div>
</x-app-layout>
