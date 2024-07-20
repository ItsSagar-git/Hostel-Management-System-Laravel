<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Display a list of rooms
    public function index()
    {
        $rooms = Room::all(); // Fetch all rooms from the database
        return view('rooms.index', compact('rooms'));
    }

    // Display a specific room's details
    public function show($id)
    {
        $room = Room::findOrFail($id); // Fetch room by ID or show 404
        return view('rooms.show', compact('room'));
    }
}
