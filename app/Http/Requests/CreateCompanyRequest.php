<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Company;
class CreateCompanyRequest extends FormRequest
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
            'cname' => 'required',
            'company' => 'required',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $domain = explode('@', $value)[1];
                    $count = \DB::table('companies')->where('email', 'like', '%@'.$domain)->count();
                    if ($count > 0) {
                        $fail('This email domain is already in use.');
                    }
                }
            ],
            'cphone'=>[
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d{10}$/', $value)) {
                        $fail('The phone must be exactly 10 digits.');
                    }
                },
            ],
            'role' => 'required|string',
            'experience' => 'required',
            'ctax_number' => 'nullable',
            'location' => 'required',
            'industry' => 'required',
            'cemployees_size' => 'nullable',
            'cfax' => 'nullable',
            'cdescription' => 'nullable',
        ];
    }
}
