<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return PermissionResource::collection(Permission::orderBy('created_at')
            ->get());
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:20|unique:permissions'
        ]);
        if ($validator->fails()){
            return response([
                'validation' => $validator->errors()
            ]);
        }

        // Creating Permission
        Permission::create([
           'name' => $request->name
        ]);

        return response([
            'success' => 'Successfully Added',
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // Getting The Permission
        $permission = Permission::findOrFail($id);

        // Validation
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:20|unique:permissions,name,'.$permission->id.',id',
        ]);
        if ($validator->fails()){
            return response([
                'validation' => $validator->errors()
            ]);
        }

        // Updating Permission
        $permission->update([
            'name' => $request->name
        ]);

        return response([
            'success' => 'Successfully Updated',
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // Getting The Permission
        $permission = Permission::findOrFail($id);

        $permission->delete();

        return response([
            'success' => "Record Deleted Successfully!"
        ], 201);
    }
}
