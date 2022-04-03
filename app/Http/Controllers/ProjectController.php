<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\WorkSpace;
use Illuminate\Http\Request;

class ProjectController extends Controller{


    public function AddProject(Request $request , $id){

        $request->validate([
            'name' => 'required|string|max:50',
            'client_name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'workspace_id' => 'required|integer',
        ]);

        // check if route id and request id are the same
        if ($id != $request->workspace_id) {
            return response()->json([
                'message' => 'workspace id does not match',
            ], 404);
        }


        $project =  Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'client_name' => $request->client_name,
            'workspace_id' => $request->workspace_id,
        ]);

        return response()->json([
            'message' => 'project added',
            'project' => $project,
        ], 200);

    }

    public function getProjects(Request $request , $id){

        $workspace = WorkSpace::find($id);
        $workspace->projects;

        return response()->json([
            'message' => 'projects retrieved',
            'workspace' => $workspace,
        ], 200);

    }


}
