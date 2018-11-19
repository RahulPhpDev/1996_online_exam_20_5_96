<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        return [
            //in this we decalre our validation
        'fname' => array('required'),
        'lname' => array('required'),
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
//             // |unique:user
        'fname.required' => ':attribute can\'t be null ',
        'lname.required' => ':attribute can\'t be null ',
// //        'username.required' => ':attribute can\'t be null ',
        'email.required' => ':attribute can\'t be null ',
         'email.unique' => ':attribute Already Exist',
         'password.required' => ':attribute can\'t be null',
         'password.confirmed' => ':attribute is not confirmed',
       ];
    }
}
