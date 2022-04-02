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
            'owner_id' => 'required|integer',
        ]);

        $workspace =  WorkSpace::create([
            'name' => $request->name,
            'description' => $request->description,
            'owner_id' => $request->owner_id,
        ]);

        return response()->json([
            'message' => 'Workspace created successfully',
            'workspace' => $workspace,
        ], 201);

    }


}
