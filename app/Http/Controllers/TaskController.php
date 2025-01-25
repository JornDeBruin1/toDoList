<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // alle taken ophalen
        return Task::all();
    }

    public function store(Request $request)
    {
         // validatie van de request
        $request->validate([
            'ToDoItem' => 'required|string|max:255',
        ]);

        // nieuwe taak aanmaken
        $task = Task::create([
            'ToDoItem' => $request->ToDoItem,
            'voltooid' => false,
        ]);

        // teruggeven van de nieuwe taak
        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        // validatie van de request
        $request->validate([
            'ToDoItem' => 'sometimes|required|string|max:255',
            'voltooid' => 'sometimes|required|boolean',
        ]);

        // taak ophalen en updaten
        $task = Task::findOrFail($id);
        $task->update($request->all());

        // teruggeven van de geupdatete taak
        return response()->json($task);
    }

    public function destroy($id)
    {
        // taak ophalen en verwijderen
        $task = Task::findOrFail($id);
        $task->delete();

        // teruggeven van een lege response
        return response()->json(null, 204);
    }
}