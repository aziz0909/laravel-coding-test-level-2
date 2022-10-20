<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Validator;
use App\Http\Traits\ApiResponse;

class TaskController extends Controller
{
    use ApiResponse;
    public $tasks_status = ['NOT_STARTED', 'IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED'];

    public function index()
    {
        $Tasks = Task::all();

        return $this->successResponse($Tasks, "success", 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'description' => 'string',
            'status' => 'string',
            'project_id' => 'required|string',
            'user_id' => 'string',
        ]);


        $fields['user_id'] = $fields['user_id'] ??auth('sanctum')->user()->id;
        $fields['status'] = $fields['status'] ?? 'NOT_STARTED';


        $Task = Task::create($fields);

        if (!$Task) {
            return $this->errorResponse("Error create task", 400);
        }

        return $this->successResponse($Task, "Successfully create task", 201);
    }

    public function show(Task $Task)
    {
        return $this->successResponse($Task, "success", 200);
    }

    public function update(Request $request, Task $Task)
    {

        $request->validate([
            'title' => 'string',
            'description' => 'string',
            'status' => 'string'
        ]);

        $projectBelongsTo = Project::find($Task->project_id)->user_id;

        if(auth('sanctum')->user()->id != $projectBelongsTo){
            return Response::deny('You dont have permission to asign this task');
        }

        $Task = $Task->update($request->all());

        if (!$Task) {
            return $this->errorResponse("Error update task", 400);
        }

        return $this->successResponse($Task, "Successfully update task", 201);
    }


    public function destroy(Task $Task)
    {
        $Task->delete();

        return $this->successResponse($Task, "Successfully delete task", 200);
    }
}
