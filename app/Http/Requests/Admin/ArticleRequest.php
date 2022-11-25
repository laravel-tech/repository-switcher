<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'heading'       => 'required|max:255',
            'content'       => 'nullable|string',
            'title'         => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'nullable|in:0,1,2,3,4,5,6',
        ];
        $rules['slug'] = match ($this->method()) {
            'POST' => 'required|max:255|alpha_dash|unique:articles',
            'PATCH', 'PUT' => 'required|max:255|alpha_dash|unique:articles,id,' . $this->id,
        };
        return $rules;
    }
}
