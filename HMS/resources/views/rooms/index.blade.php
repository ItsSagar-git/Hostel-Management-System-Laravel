<!-- resources/views/rooms/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Available Rooms</h1>
    <div class="row">
        @foreach($rooms as $room)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $room->name }}</h5>
                        <p class="card-text">{{ $room->description }}</p>
                        <p class="card-text"><strong>Price:</strong> ${{ $room->price }}</p>
                        <p class="card-text"><strong>Capacity:</strong> {{ $room->capacity }} people</p>
                        <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
