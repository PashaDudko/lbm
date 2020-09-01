<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWagerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // почитать почему тру???!?!?
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'condition' => 'required|max:150', // Можно переписать ['required', 'unique:wagers'...],
            'rate' => 'max:50', //required|unique:wagers|
            'start_date' => 'required|date|after:yesterday',
            'finish_date' => 'required|date|after:start_date',
        ];
    }
}
