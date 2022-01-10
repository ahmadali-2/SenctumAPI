<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function studentRegister(Request $request){
        $validation = $request->validate([
            "name" => "required",
            "email" => "required|email|unique:students",
            "password" => "required|confirmed",
        ]);

        Student::insert([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "phone_no" => isset($request->phone_no) ? $request->phone_no : "",
            "gender" => isset($request->gender) ? $request->gender : "",
            "age" => isset($request->age) ? $request->age : "",
        ]);

        return response()->json([
            "status" => 1,
            "message" => "Student registered successfully!",
        ],200);
    }

    public function studentLogin(Request $request){
        $validation = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $student = Student::where('email','=',$request->email)->first();
        if(isset($student->id)){
            if(Hash::check($request->password, $student->password)){
                $token = $student->createToken("auth_token")->plainTextToken;
                return response()->json([
                    "status" => 1,
                    "message" => "Login Success!",
                    "auth_token" => $token,
                ],200);
            }
            else{
                return response()->json([
                    "status" => 0,
                    "message" => "Password didn't match!",
                ],404);
            }
        }
        else{
            return response()->json([
                "status" => 1,
                "message" => "Student does not exist!",
            ],404);
        }
    }

    public function studentProfile(){
        return response()->json([
            "status" => 1,
            "message" => "Profile Information",
            "data" => auth()->user(),
        ]);
    }

    public function studentLogout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => 1,
            "message" => "Student Logged Out Success!",
        ]);
    }
}
