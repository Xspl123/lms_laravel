<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CreateLead;
class CreateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can set authorization logic here, e.g. if the user is allowed to create a task
        // if ($this->user()->role_id == 18) {
        //     return true;
        // }

        // throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
        //     'message' => 'This action is unauthorized. you have not permissiable user'
        // ], 403));
    
        // $lead = CreateLead::find($this->route('lead'));
    
        // return $lead && $lead->user_id == $this->user()->id;

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
            'full_name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^\d{10}$/',
            ],
            'email' => 'required|email|unique:employees',
            'job' => 'required',
            'note' => 'nullable|string',
            'uuid' => 'nullable',
            'is_active'=> 'nullable',
            'user_id' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'The Phone number must be exactly 10 digits.',
        ];
    }
}