<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\Role;

class CreateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->can('update-user')) 
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
            'access_data_type' => 'required|numeric',
            'access_data' => 'required|numeric'
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

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required',
            'numeric' => 'The :attribute field must only be numbers'
        ];
    }

    public function formatInput() 
    {
        $input = array_map('trim', $this->all());

        $accessDataType = ROLE::$accessDataTypes[$input['access_data_type']];

        $input['access_data'] = [$accessDataType => $input['access_data']];

        $exceptionKeys = ['access_data_type', 'access_data_mupel', '_token'];
        $sanitizedInputs = array_diff_key($input, array_flip($exceptionKeys));

        $this->replace($sanitizedInputs);
        return $this->all();
    }
}
