<?php

namespace App\Http\Controllers\API\V2;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\TaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class());
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        return TaskResource::collection(Task::where('user_id', $user->id)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        Task::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'status' => $request->status
        ]);
        // return $request->all();
        return response()->json([
            'message' => 'Task saved successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // $this->authorize('view', $task);
        $user = request()->user();
        return TaskResource::make(Task::where('user_id', $user->id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('view', $task);
        $task->update([
            'name' => $request->name
        ]);
        return TaskResource::make($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('view', $task);
        $task->delete();
        return response()->json([
            'message' => 'Task deleted successfully'
        ], 201);
    }
}
