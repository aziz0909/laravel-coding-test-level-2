<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Validator;
use App\Http\Traits\ApiResponse;

class ProjectController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $Projects = Project::all();

        return $this->successResponse($Projects, "success", 200);
    }

    public function store(Request $request)
    {

        $fields = $request->validate([
            'name' => 'required|string|unique:projects,name',
            'user_id' => 'string',
        ]);

        $fields['user_id'] = $fields['user_id'] ?? auth('sanctum')->user()->id;

        $Project = Project::create($fields);

        if (!$Project) {
            return $this->errorResponse("Error create project", 400);
        }

        return $this->successResponse($Project, "Successfully create project", 201);
    }

    public function show(Project $Project)
    {
        return $this->successResponse($Project, "success", 200);
    }

    public function update(Request $request, Project $Project)
    {
        $request->validate([
            'name' => 'required|unique:projects',
        ]);

        $Project = $Project->update($request->all());

        if (!$Project) {
            return $this->errorResponse("Error update project", 400);
        }

        return $this->successResponse($Project, "Successfully update project", 201);
    }

    public function destroy(Project $Project)
    {
        $Project->delete();

        return $this->successResponse($Project, "Successfully delete project", 200);
    }
}
