<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Models\User;
use Illuminate\Http\Request;
use Modules\Auth\Http\Resources\UserResource;
use Modules\Auth\Http\Requests\UserStoreRequest;
use Modules\Auth\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{

    /**
     * construct method.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('read', User::class);
       return UserResource::collection(User::all());
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
    public function store(Request $request)
    {
        $this->authorize('store', User::class);
        $user = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'active' => $request['active'],
        ]);
        if($request->roles <> ''){
            $user->roles()->attach($request->roles);
        }
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Modules\Auth\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('read', User::class);
        return new UserResource(User::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Modules\Auth\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Auth\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $this->authorize('update', User::class);
        $user = User::findOrFail($id);
        if($request['updatePassword']){
            $user->update([
                'name' => $request['name'],
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'active' => $request['active'],
            ]);
        }
        else{
            $user->update([
                'name' => $request['name'],
                'username' => $request['username'],
                'email' => $request['email'],
                'active' => $request['active'],
            ]);
        }
        if ($request->roles <> '') {
            $user->roles()->sync($request->roles);        
        }        
        else {
            $user->roles()->detach(); 
        }
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\Auth\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', User::class);
        $user = User::findOrFail($id);
        $user->delete();
    }

    /**
     * Remove the many resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $request)
    {
        $this->authorize('delete', User::class);
        \DB::table('users')->whereIn('id', $request['ids'])->delete(); 
    }
}
