<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => ['required'],
            'description' => ['required','string','max:255'],
            'image' => ['required','image','mimes:png,jpeg'],
            'category_id' => ['required','exists:categories,id'],
            'condition_id' => ['required','exists:conditions,id'],
            'price' => ['required','integer','min:0'],
        ];
    }
}
