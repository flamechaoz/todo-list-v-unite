<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TodoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $todos = Todo::all();

        return Inertia::render('Todos/Index', [
            'data' => TodoResource::collection($todos)->resolve(),
        ]);
    }

    public function show(Todo $todo)
    {
        return response()->json($todo);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $todo = Todo::create($validated);

        return response()->json($todo, 201);
    }
}
