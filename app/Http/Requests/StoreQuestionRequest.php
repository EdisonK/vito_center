<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'category_id' => 'required|Integer',
            'title' => 'required|String',
            'answer' => 'nullable',
            'logo' => 'nullable|String',
            'vedio_url' => 'nullable|String',
            'is_show' => 'required|Integer',
            'z_index' => 'nullable|Integer'
        ];
    }
}
