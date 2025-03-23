<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function all()
    {
        $users = User::all();
        $status = $users->isEmpty() ? 204 : 200;
        return response()->json($users, $status);
    }


    public function create(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                "msg" => "missing attr",
                "errors" => $validator->errors()
            ], 422);
        }

        // store request body in a variable
        $inputData = $request->all();

        try {
            // Attempt to create the user
            $user = User::create($inputData);

            return response()->json([
                "msg" => "create",
                "inserted entity" => $user,
            ], 201);
        } catch (QueryException $e) {
            // Check if it's a duplicate entry error (unique constraint violation)
            if ($e->getCode() == 23000) {
                return response()->json([
                    "msg" => "Duplicate username",
                    "error" => "The username has already been taken. Please choose a different one.",
                ], 409); // Conflict status code
            }

            // Handle other database-related errors
            return response()->json([
                "msg" => "user creation failed",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function read($id)
    {
        $user = User::find($id);
        if (!$user)
            return response()->json(["msg" => 'not found'], 404);

        return response()->json($user, 200);
    }

    public function createOrUpdate(Request $request, $id = "add")
    {
        $user = User::find($id);

        if (!$user) {
            return $this->create($request);
        }

        $user->update($request->all());
        return response()->json($user);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(["msg" => "User not found"], 404);
        }

        // Soft delete the user (set 'deleted_at' to the current timestamp)
        $user->delete();

        return response()->json(["msg" => "User deleted successfully"]);
    }

    function login(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                "msg" => "missing attr",
                "errors" => $validator->errors()
            ], 422);
        }
        $credentials = [
            "username" => $request["username"],
            "password" => $request["password"]
        ];

        if (! $token = Auth::attempt($credentials)) {
            return response()->json([
                "success" => false,
                "error" => "Unauthorized"
            ], 401);
        }

        $user = Auth::user();
        $user->token = $token;

        return response()->json([
            "success" => true,
            "user" => $user
        ]);
    }
}
