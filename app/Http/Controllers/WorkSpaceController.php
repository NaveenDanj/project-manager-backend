<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserWorkSpace;
use App\Models\WorkSpace;
use Illuminate\Http\Request;

class WorkSpaceController extends Controller
{


    public function GetWorkspace(Request $request , $id){

        // check if user has access to workspace

        $workspace_access_check = UserWorkSpace::where('user_id',$request->user()->id)->where('work_space_id',$id)->first();
        if(!$workspace_access_check){
            return response()->json([
                'message' => 'You do not have access to this workspace',
            ], 401);
        }

        // check if workspace is exists
        $workspace_check = WorkSpace::find($id);
        if(!$workspace_check){
            return response()->json([
                'message' => 'workspace not found',
            ], 404);
        }

        return response()->json([
            'message' => 'workspace found',
            'workspace' => $workspace_check,
        ], 200);


    }


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

        UserWorkSpace::create([
            'user_id' => $request->user()->id,
            'work_space_id' => $workspace->id,
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

    // get user accessible workspaces
    public function UserWorkspaces(Request $request){

        $workspaces = User::where('id',$request->user()->id)->first()->workspaces;

        return response()->json([
            'workspaces' => $workspaces,
        ], 200);

    }


    // invite user to workspace
    public function InviteUser(Request $request , $id){

        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);

        // check if user is the owner of the workspace
        $workspace_check = WorkSpace::where('id', $id)->where('owner_id', $request->user()->id)->first();
        if(!$workspace_check){
            return response()->json([
                'message' => 'You are not the owner of this workspace',
            ], 401);
        }

        // check if user is exists
        $user_check = User::where('email', $request->email)->first();
        if(!$user_check){
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        // check if user is already invited
        $invite_check = UserWorkSpace::where('user_id', $user_check->id)->where('work_space_id', $id)->first();
        if($invite_check){
            return response()->json([
                'message' => 'User already invited',
            ], 401);
        }

        UserWorkSpace::create([
            'user_id' => $user_check->id,
            'work_space_id' => $id,
        ]);

        return response()->json([
            'message' => 'User invited successfully',
        ], 201);

    }



}
