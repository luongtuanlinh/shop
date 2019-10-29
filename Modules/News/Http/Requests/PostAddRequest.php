<?php

namespace Modules\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostAddRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'     =>  'required|unique:news_posts,title',
            //'data'      =>  'required',
            'slug'      =>  'required|unique:news_posts,slug',
            'post_type' =>  'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => trans('news::validation.post_title_required'),
            'title.unique'   => trans('news::validation.post_title_unique'),
            'data.required'  => trans('news::validation.post_data_required'),
            'slug.required'  => trans('news::validation.post_slug_required'),
            'slug.unique'    => trans('news::validation.post_slug_unique'),
            'post_type.required' => trans('news::validation.post_type_required')
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
