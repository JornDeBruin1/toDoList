<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'ToDoItem' => 'required|string|max:255',
        ]);

        $task = Task::create([
            'ToDoItem' => $request->ToDoItem,
            'voltooid' => false,
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ToDoItem' => 'sometimes|required|string|max:255',
            'voltooid' => 'sometimes|required|boolean',
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}