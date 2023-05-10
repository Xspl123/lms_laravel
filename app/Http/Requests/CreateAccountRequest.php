<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CreateLead;
class CreateAccountRequest extends FormRequest
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
        'Owner' => 'nullable',
        'AccountName' => 'required|string|max:255',
        'AccountSite' => 'nullable',
        'ParentAccount' => 'nullable',
        'AccountNumber' => 'nullable',
        'AccountType' => 'nullable',
        'Industry' => 'nullable',
        'AnnualRevenue' => 'nullable',
        //'Rating' => 'nullable',
        'phone' => [
            'required',
            'string',
            'regex:/^\d{10}$/',
        ],
        'Fax' => 'nullable',
        'Website' => 'nullable',
        'TickerSymbol' => 'nullable',
        //'Ownership' => 'nullable',
        'Employees' => 'nullable',
        'SICCode' => 'nullable',
        'BillingStreet' => 'nullable',
        'BillingCity' => 'nullable',
        'BillingState' => 'nullable',
        'BillingCode' => 'nullable',
        'BillingCountry' => 'nullable',
        'ShippingStreet' => 'nullable',
        'ShippingCity' => 'nullable',
        'ShippingState' => 'nullable',
        'ShippingCode' => 'nullable',
        'ShippingCountry' => 'nullable',
        'Description'  => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'The phone number must be exactly 10 digits.',
        ];
    }
}