<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Auth;
class updateProfileRequest extends FormRequest
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
        $user =  $user = Auth::user();
        // dd($user->id);
        return [
            'fname' => array('required'),
            'lname' => array('required'),
            'phone_no' => array('regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:10,12|unique:users,phone_no'.$user->id)
        ];
    }

    public function messages()
    {
        return [
//             // |unique:user
        'fname.required' => ':attribute can\'t be null ',
        'lname.required' => ':attribute can\'t be null ',
        'phone_no.unique' => 'Mobile Number should be unique',
        'phone_no.max' => 'Mobile Number should be less than 12',
        'phone_no.integer' => 'Mobile Number should be digit',
       ];
    }
}
