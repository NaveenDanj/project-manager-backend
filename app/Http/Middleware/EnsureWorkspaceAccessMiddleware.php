<?php

namespace App\Http\Middleware;

use App\Models\UserWorkSpace;
use Closure;
use Illuminate\Http\Request;

class EnsureWorkspaceAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // get the authenticated user
        $user = $request->user();
        //check if user exists
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 404);
        }

        // get the workspace id from the request
        $workspace_id = $request->route('id');
        // check if the workspace id exists
        if (!$workspace_id) {
            return response()->json([
                'message' => 'workspace id not found',
            ], 404);
        }

        // check if the user has access to the workspace
        $workspace_access_check = UserWorkSpace::where('user_id', $user->id)->where('work_space_id', $workspace_id)->first();
        if (!$workspace_access_check) {
            return response()->json([
                'message' => 'You do not have access to this workspace',
            ], 401);
        }

        return $next($request);
    }
}
