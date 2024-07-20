<!-- resources/views/rooms/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $room->name }}</h1>
    <div class="card">
        <div class="card-body">
            <p class="card-text">{{ $room->description }}</p>
            <p class="card-text"><strong>Price:</strong> ${{ $room->price }}</p>
            <p class="card-text"><strong>Capacity:</strong> {{ $room->capacity }} people</p>
        </div>
    </div>
</div>
@endsection
