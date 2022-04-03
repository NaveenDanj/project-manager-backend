<?php

use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\WorkSpaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// auth endpoints
Route::prefix('auth')->group(function () {

    Route::post('register', [UserAuthController::class , 'Register']);
    Route::post('login', [UserAuthController::class , 'Login']);
    Route::post('logout', [UserAuthController::class , 'Logout']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [UserAuthController::class , 'Me']);
        Route::get('workspaces', [WorkSpaceController::class , 'UserWorkspaces']);
        Route::put('me' , [UserAuthController::class , 'updateUserAccount']);
        Route::post('reset-password' , [UserAuthController::class , 'resetPassword']);
    });


});

// work space endpoints
Route::prefix('workspace')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/', [WorkSpaceController::class , 'Workspaces']);
        Route::middleware('ensureWorkspaceAccess')->get('/get/{id}', [WorkSpaceController::class , 'GetWorkspace']);
        Route::post('/', [WorkSpaceController::class , 'AddWorkspace']);
        Route::middleware('ensureWorkspaceAccess')->put('/{id}', [WorkSpaceController::class , 'EditWorkspace']);
        Route::middleware('ensureWorkspaceAccess')->post('/invite-user/{id}' , [WorkSpaceController::class , 'InviteUser']);
        Route::middleware('ensureWorkspaceAccess')->post('/remove-user/{id}' , [WorkSpaceController::class , 'removeUser']);
    });

});


// project endpoints
Route::prefix('project')->group(function(){

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/', [ProjectController::class , 'Projects']);
        Route::get('/get/{id}', [ProjectController::class , 'GetProject']);
        Route::post('/', [ProjectController::class , 'AddProject']);
        Route::put('/{id}', [ProjectController::class , 'EditProject']);
        Route::post('/invite-user/{id}' , [ProjectController::class , 'InviteUser']);
        Route::post('/remove-user/{id}' , [ProjectController::class , 'removeUser']);

    });

});
