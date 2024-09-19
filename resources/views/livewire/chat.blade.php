<div>
    <div class="chat-box" style="height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
        @foreach($messages as $message)
            <div class="message">
                <strong>{{ $message['user']['name'] }}:</strong> {{ $message['content'] }}
                {{-- <strong>{{ $message->user->name }}:</strong> {{ $message->content }} --}}
            </div>
        @endforeach
    </div>

    <div class="chat-input" style="margin-top: 10px;">
        <textarea wire:model="newMessage" style="width: 100%;" rows="3" placeholder="Type a message..."></textarea>
        <button wire:click="sendMessage" style="width: 100%; margin-top: 5px;">Send</button>
    </div>

    <script>
        // Scroll to the bottom after message is sent
        // Livewire.on('messageSent', () => {
        //     const chatBox = document.querySelector('.chat-box');
        //     chatBox.scrollTop = chatBox.scrollHeight;
        //     Livewire.emit('getMessages'); // If you want to trigger Livewire method from JavaScript
        //     @this.getMessages(); // Call the getMessages method to update the message list
        //     @this.call('getMessages');  // Call the method to refresh the messages
        // });

       
        document.addEventListener('livewire:load', () => {
            // Listen for the 'messageSent' event
            Livewire.on('messageSent', () => {
                const chatBox = document.querySelector('.chat-box');
                chatBox.scrollTop = chatBox.scrollHeight;
            });

            // Function to periodically fetch new messages
            setInterval(() => {
                Livewire.emit('fetchMessages');
            }, 5000);
        });
   
    </script>

</div>
