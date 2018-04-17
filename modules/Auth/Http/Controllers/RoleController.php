<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Http\Resources\RoleResource;
use Modules\Auth\Http\Resources\PermissionResource;
use Modules\Auth\Models\Role;
use Modules\Auth\Models\Permission;
use Modules\Auth\Http\Requests\RoleStoreRequest;
use Modules\Auth\Http\Requests\RoleUpdateRequest;


class RoleController extends Controller
{
    /**
     * construct method.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth','permission:browse_roles']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    /**
     * Display a listing permission of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPermission()
    {
        return PermissionResource::collection(Permission::all());
    }
    public function getRolesPermissions($id) {
        $role = Role::findOrFail($id);
        $plucked = $role->permissions->pluck('pivot')->pluck('permission_id');
        return $plucked;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->save();
        if($request->permissions <> ''){
            $role->permissions()->attach($request->permissions);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new RoleResource(Role::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $input = $request->except(['permissions']);
        $role->fill($input)->save();
        if($request->permissions <> '') {
            $role->permissions()->sync($request->permissions);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
