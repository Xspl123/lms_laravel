<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CreateLead;
class CreateLeadRequest extends FormRequest
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
           'p_id'=> 'nullable',
           'Owner'=> 'nullable',
           'lead_Name' => 'required',
            'email' => 'required',
            'fullName' => 'required',
            'phone' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Check if the phone number starts with a plus sign followed by exactly three digits and at most 10 additional digits,
                    // or if it is at most 10 digits without a plus sign and country code
                    if (!preg_match('/^(\+\d{3}\d{0,10}|\d{0,10})$/', $value)) {
                        $fail('The phone must start with a valid country code (e.g., +123) followed by at most 10 additional digits, or it can be at most 10 digits without a country code.');
                    }
                },
            ],
            
            'lead_status' => 'required',
            'company' => 'nullable',
            'lead_Source' => 'nullable',
            'fax' => 'nullable',
            'mobile' => 'nullable',
            'website' => 'nullable',
            'industry' => 'nullable',
            'rating' => 'nullable',
            'noOfEmployees' => 'nullable',
            'annualRevenue' => 'nullable',
            'skypeID' => 'nullable',
            'secondaryEmail' => 'nullable',
            'twitter' => 'nullable',
            'city'=>'nullable',
            'street' => 'nullable',
            'pinCode' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'discription' => 'nullable',
            'title' => 'nullable',
            'related_activities' => 'nullable'
        ];
    }
}
