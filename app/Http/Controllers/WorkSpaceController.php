<?php

namespace App\Http\Controllers;

use App\Models\WorkSpace;
use Illuminate\Http\Request;

class WorkSpaceController extends Controller
{

    public function addWorkspace(Request $request){

        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
        ]);

        $workspace =  WorkSpace::create([
            'name' => $request->name,
            'description' => $request->description,
            'owner_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Workspace created successfully',
            'workspace' => $workspace,
        ], 201);

    }

    public function EditWorkspace(Request $request , $id){

        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
        ]);

        // check if the workspace id is exists in

        // check if user is the owner of the workspace
        $workspace_check = WorkSpace::where('id', $id)->where('owner_id', $request->user()->id)->first();
        if(!$workspace_check){
            return response()->json([
                'message' => 'You are not the owner of this workspace',
            ], 401);
        }


        $workspace =  WorkSpace::find($id);
        $workspace->name = $request->name;
        $workspace->description = $request->description;

        $workspace->save();

        return response()->json([
            'message' => 'Workspace updated successfully',
            'workspace' => $workspace,
        ], 201);


    }


}
