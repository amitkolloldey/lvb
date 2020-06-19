<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Role;
use App\User;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        // Getting Users
        return UserResource::collection(User::orderBy('created_at', 'desc')
            ->get())
            ->additional([
                'roles' => Role::orderBy('name')
                    ->get([
                        'name',
                        'id'
                    ])
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed|string',
            'status' => 'required',
            'role' => 'required'
        ]);
        if ($validator->fails()) {
            return response([
                'validation' => $validator->errors()
            ]);
        }

        // Creating The User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'gravatar_url' => Gravatar::get($request->email)
        ]);

        // Assigning Role To The User
        if ($request->has('role') && $request->role != null) {
            $user->assignRole($request->role);
        }


        // Sending User Verification Email
        $user->sendEmailVerificationNotification();

        return response([
            'success' => 'Successfully Added'
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // Getting The User
        $user = User::findOrFail($id);

        // Updating User's Password
        if (!empty($request->password)) {
            // Validation For Password
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8|confirmed|string',
            ]);
            if ($validator->fails()) {
                return response([
                    'validation' => $validator->errors()
                ]);
            }

            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id . ',id',
            'status' => 'required',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'validation' => $validator->errors()
            ]);
        }

        // Updating The User's Data
        $user->update([
            'name' => $request->name,
            'status' => $request->status,
            'gravatar_url' => Gravatar::get($request->email)
        ]);

        // Assigning Role To The User
        $user->syncRoles($request->role['name']);

        return response([
            'success' => 'Successfully Updated!'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        // Getting The User
        $user = User::findOrFail($id);

        $user->delete();

        return response([
            'success' => "Record Deleted Successfully!"
        ], 201);
    }
}
