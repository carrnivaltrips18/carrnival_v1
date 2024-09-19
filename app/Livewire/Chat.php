<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message; // Make sure you have a Message model
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $messages = [];
    public $newMessage;

    protected $rules = [
        'newMessage' => 'required|string|max:255',
    ];

    public function mount()
    {
        // Fetch messages from the database
      //  $messagesFromDB = Message::with('user')->latest()->take(10)->get();

        // Make sure $messagesFromDB is always an array
       // $this->messages = array_merge($this->messages ?? [], $messagesFromDB->toArray());
          $this->getMessages();
       // dd($messagesFromDB);
      
        // Load the latest messages when the component is mounted
        //$this->messages = Message::with('user')->latest()->take(10)->get()->reverse(); // Reverse for latest messages on bottom
    }

    public function sendMessage()
    {
        // Validate the new message input
        $this->validate([
            'newMessage' => 'required|string|max:255',
        ], [
            'newMessage.required' => 'Message cannot be empty.',
            'newMessage.string' => 'Message must be a string.',
            'newMessage.max' => 'Message cannot be longer than 255 characters.',
        ]);

        // Save the new message to the database
        $message = Message::create([
            'content' => $this->newMessage,
            'user_id' => Auth::id(),
        ]);

        // Reset the new message input field
        $this->newMessage = '';

        // Refresh the message list to include the newly added message
        //$this->messages->push($message);

        // Reload the messages collection with the new message included
        //$this->messages = Message::with('user')->latest()->take(10)->get()->reverse();
        $this->getMessages();

        // Optionally, you can emit a browser event for scroll down
       // $this->emit('messageSent');
      // $this->emit('messageSent');
        $this->dispatch('messageSent');
        // Trigger a full-page refresh
        $this->dispatch('refreshPage');
    }

    // Ensure this method is public so it can be called from the view
    public function getMessages()
    {
        // Fetch the latest messages and assign them to $messages
        $this->messages = Message::with('user')->latest()->take(10)->get()->reverse();
    }

    public function fetchMessages()
    {
        $this->getMessages();
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
