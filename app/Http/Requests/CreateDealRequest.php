<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Deals;
class CreateDealRequest extends FormRequest
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
            'dealName' => 'required',
            'accountName' => 'nullable',
            'type' => 'nullable',
            'amount' => 'integer|nullable',
            'closingDate' => 'nullable',
            'stage' => 'nullable',
            'probability' => 'nullable',
            'expectedRevenue' => 'nullable',
            'campaignSource' => 'nullable',
            'description' => 'nullable',
            'p_id'=> 'required',
            'reason_for_loss' => 'nullable',
            'Owner' => 'nullable',
            'created_by' => 'nullable',
        ];
    }
}
