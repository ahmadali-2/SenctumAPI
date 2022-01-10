<?php

use App\Http\Controllers\Api\NewProjectController;
use App\Http\Controllers\Api\StudentController;
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

//Routes without authentication:
Route::post("student-register",[StudentController::class,"studentRegister"]);
Route::post("student-login",[StudentController::class,"studentLogin"]);

//Routes with authentication:
Route::middleware("auth:sanctum")->group(function(){
    Route::get("student-profile",[StudentController::class,"studentProfile"]);
    Route::get("student-logout",[StudentController::class,"studentLogout"]);
    Route::post("create-project",[NewProjectController::class,"createProject"]);
    Route::get("list-projects",[NewProjectController::class,"listProjects"]);
    Route::get("list-project/{id}",[NewProjectController::class,"listProject"]);
    Route::delete("delete-project/{id}",[NewProjectController::class,"deleteProject"]);
});