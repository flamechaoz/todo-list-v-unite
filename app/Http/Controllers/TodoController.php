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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task' => 'required|string|max:255',
            'status' => 'required|string|max:255'
        ]);

        // Create todo item
        $todo = Todo::create($validated);

        // Return the created todo item
        return response()->json($todo, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'task' => 'required|string|max:255',
            'status' => 'required|string|max:255'
        ]);

        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todo item not found',
            ], 404);
        }

        // Update the todo item
        $todo->update($validated);

         // Return the updated todo item
         return response()->json([
            'status' => 'success',
            'data' => $todo,
        ], 200);
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todo item not found',
            ], 404);
        }

        $todo->delete();

         // Return a success response
         return response()->json([
            'status' => 'success',
            'message' => 'Todo item deleted successfully',
        ], 200);
    }
}
