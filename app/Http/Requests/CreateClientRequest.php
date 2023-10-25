<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can set authorization logic here, e.g. if the user is allowed to create a task
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
            'clfull_name' => 'required',
            'clphone'=>[
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d{10}$/', $value)) {
                        $fail('The phone must be exactly 10 digits.');
                    }
                },
            ],
            'clemail' => 'required|email|unique:clients,clemail',
            'clsection' => 'nullable',
            'clbudget' => 'nullable',
            'cllocation' => 'nullable',
            'clzip' => 'nullable',
            'clcity' => 'nullable',
            'clcountry' => 'nullable',
            'p_id' => 'required'
        ];
    }
}
