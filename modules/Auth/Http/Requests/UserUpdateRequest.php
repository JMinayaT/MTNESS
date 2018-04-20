<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->updatePassword){
            return [
                'name' => 'string|max:255',
                'username' => 'required|string|max:255|unique:users,username,'. $this->id,
                'email' => 'required|email|unique:users,email,'. $this->id,
                'password' => 'required|min:6|confirmed',
            ];
        }
        else{
            return [
                'name' => 'string|max:255',
                'username' => 'required|string|max:255|unique:users,username,'. $this->id,
                'email' => 'required|email|unique:users,email,'. $this->id,
            ];
        }
    }
}
