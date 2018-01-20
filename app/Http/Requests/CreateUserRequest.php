<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\AsetJemaat;
use App\Models\Role;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->can('create-user')) 
            return true;

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'id_role' => 'required|numeric',
            'name' => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ];

        if ($this->has('mupel') ) {
            $rules += [
                'mupel' => 'required'
            ];
        }

        if ($this->has('jemaat') ) {
            $rules += [
                'jemaat' => 'required'
            ];
        } 

        // dd($rules);
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required',
            'numeric' => 'The :attribute field must only be letters and numbers (no spaces)'
        ];
    }

    public function formatInput() 
    {
        $input = array_map('trim', $this->all());
        $input['password'] = bcrypt($input['password']);
        $input['pass_prompt'] = "1";

        $accessDataType = ROLE::$accessDataTypes[$input['id_role']];

        if ( $input['id_role'] == '3' ) {
            $input['access_data'] = [$accessDataType => $input['mupel']];
        } elseif ( $input['id_role'] == '4' ) {
            $input['access_data'] = [$accessDataType => $input['jemaat']];
        } else {
            $input['access_data'] = [$accessDataType => 1];
        }

        $exceptionKeys = ['file', '_token'];
        $sanitizedInputs = array_diff_key($input, array_flip($exceptionKeys));

        $this->replace($sanitizedInputs);
        return $this->all();
    }
}
