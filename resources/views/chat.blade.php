@extends('layouts.app_user')

@section('content')
    <div class="container">
        <h1>Chat</h1>
        @livewire('chat') <!-- Include the Livewire chat component -->
    </div>
@endsection
