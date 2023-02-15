<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Notifications\UserChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function list()
    {
        $listTasks = Task::all();

        return response()->json([
            'status' => 'success',
            'list' => $listTasks
        ]);
    }


    public function get($id)
    {
        try {
            $task = Task::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'task' => $task
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 301);
        }
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|string',
                'date_conclusion' => 'required|date',
                'status' => 'required',
            ]);
            $task = Task::create([
                'name' => $request->name,
                'date_conclusion' => $request->date_conclusion,
                'status' => $request->status,
            ]);
            $user = Auth::user();
            $user->notify(new UserChanged('A tarefa ' . $task->name . ' foi criada.'));

            return response()->json([
                'status' => 'success',
                'task' => $task
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 301);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $taskUpdated = Task::findOrFail($id);

            $taskUpdated->name = $request->input('name');
            $taskUpdated->date_conclusion = $request->input(
                'date_conclusion'
            );
            $taskUpdated->status = $request->input('status');

            $taskUpdated->save();

            $user = Auth::user();
            $user->notify(new UserChanged('A tarefa ' . $taskUpdated->name . ' foi alterada.'));

            return response()->json([
                'status' => 'success',
                'task' => $taskUpdated
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 301);
        }
    }

    public function destroy($id)
    {
        try {
            $taskDeleted = Task::findOrFail($id);
            $name = $taskDeleted->name;

            $taskDeleted->delete();

            $user = Auth::user();
            $user->notify(new UserChanged('A tarefa ' . $name . ' foi deletada.'));

            return response()->json([
                'status' => 'success',
                'task' => $taskDeleted
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 301);
        }
    }
}
