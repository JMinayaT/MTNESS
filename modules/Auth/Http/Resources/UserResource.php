<?php

namespace Modules\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Modules\Auth\Http\Resources\RoleResource;
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>  $this->id,
            'name'=> $this->name,
            'username'=> $this->username ,'email'=>$this->email, 
            'roles'   => RoleResource::collection($this->roles),
            'active'=> ($this->active)?true:false,
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d-m-Y'),
            "updated_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d-m-Y')
        ];
    }
}
