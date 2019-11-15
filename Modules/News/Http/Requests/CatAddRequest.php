<?php

namespace Modules\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatAddRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  =>  'required',
            'slug'=>  'required',
            'position' => 'min:0|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('news::validation.category_name_required'),
            'slug.required'   => trans('news::validation.category_slug_required'),
            'position.min' => trans('news::validation.category_position_min'),
            'position.integer' => trans('news::validation.category_position_integer')
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
