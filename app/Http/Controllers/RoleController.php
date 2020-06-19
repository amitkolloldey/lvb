<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Permission;
use App\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|object
     */
    public function index()
    {
        // Getting Roles
        return RoleResource::collection(Role::orderBy('created_at', 'desc')
            ->get())
            ->additional([
                'permissions' => Permission::orderBy('name')
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
     * @return Response
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|without_spaces|unique:roles',
            'label' => 'required|max:20',
        ]);
        if ($validator->fails()) {
            return response([
                'validation' => $validator->errors()
            ]);
        }

        // Creating Role
        $role = Role::create([
            'name' => strtolower($request->name),
        ]);

        // Assigning Permissions To The Role
        if ($request->has('permissions') && !empty($request->permissions)){
            foreach ($request->permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        return response([
            'success' => 'Successfully Added',
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
        // Getting The Role
        $role = Role::findOrFail($id);

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|without_spaces|unique:roles,name,'.$role->id.',id',
            'label' => 'required|max:20',
        ]);
        if ($validator->fails()) {
            return response([
                'validation' => $validator->errors()
            ]);
        }

        // Updating The Role
        $role->update([
            'name' => $request->name,
            'label' => $request->label,
        ]);

        // Assigning PermissionResource To The Role
        if ($request->has('permissions') && !empty($request->permissions)){
            $role->syncPermissions(collect($request->permissions)
                ->pluck('id')
                ->toArray()
            );
        }

        return response([
            'success' => 'Successfully Updated',
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
        // Getting The Role
        $role = Role::findOrFail($id);

        $role->delete();

        return response([
            'success' => "Record Deleted Successfully!"
        ], 201);
    }
}
