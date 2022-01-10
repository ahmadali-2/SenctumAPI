<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class NewProjectController extends Controller
{
    public function createProject(Request $request){
        $student_id = auth()->user()->id;
        $validation = $request->validate([
            "name" => "required",
            "description" => "required",
            "duration" => "required",
        ]);
        Project::insert([
           "student_id" => $student_id,
           "name" => $request->name,
           "description" => $request->description,
           "duration" => $request->duration,
        ]);

        return response()->json([
            "status" => 1,
            "message" => "Project created successfuly!",
        ],200);
    }

    public function listProjects(){
        $student_id = auth()->user()->id;
        $projects = Project::where('student_id','=',$student_id)->get();
        if(isset($projects)){
            return response()->json([
                "status" => 1,
                "message" => "Listing projects",
                "data" => $projects,
            ],200);
        }
        else{
            return response()->json([
                "status" => 1,
                "message" => "No projects to show!",
            ],404);
        }
    }

    public function listProject($id){
        $student_id = auth()->user()->id;
        $project = Project::where(["student_id" => $student_id, "id" => $id])->get()->first();
        if(isset($project)){
            return response()->json([
                "status" => 1,
                "message" => "listing project of this ID:",
                "data" => $project,
            ],200);
        }
        else{
            return response()->json([
                "status" => 1,
                "message" => "Project Not Found!",
            ],404);
        }
    }

    public function deleteProject($id){
        $student_id = auth()->user()->id;
        $project = Project::where(["student_id" => $student_id, "id" => $id])->get()->first();
        if(isset($project)){
            $project->delete();
            return response()->json([
                "status" => 1,
                "message" => "Project deleted successfuly!",
            ],200);
        }
        else{
            return response()->json([
                "status" => 0,
                "message" => "Invalid Project ID / Or no project to delete!",
            ],404);
        }
    }
}
