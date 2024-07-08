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
    // GET /api/todos
    public function index()
    {
        $todos = Todo::all();

        return response()->json(TodoResource::collection($todos)->resolve());
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
            'status' => 'required|string|max:255'
        ]);

        $todo = Todo::create($validated);

        return response()->json($todo, 201);
    }
}
