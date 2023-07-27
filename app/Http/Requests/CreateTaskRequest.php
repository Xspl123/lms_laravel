<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
            
            'Subject' => 'required|string|max:255',
            'DueDate' => 'nullable|date',
            'Status' => 'nullable|string|max:255',
            'Priority' => 'nullable|string|max:255',
            'Reminder' => 'nullable',
            'Repeat' => 'nullable|string|max:255',
            'Description' => 'nullable|string',
            'p_id' => 'nullable|integer',
            'owner_id' =>  'nullable|integer'
        ];
    }
}
