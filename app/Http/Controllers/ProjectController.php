<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller{


    public function AddProject(Request $request){

        $request->validate([
            'name' => 'required|string|max:50',
            'client_name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'workspace_id' => 'required|integer',
        ]);

        $project =  Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'workspace_id' => $request->workspace_id,
        ]);

        return response()->json([
            'message' => 'project added',
            'project' => $project,
        ], 200);


    }


}
