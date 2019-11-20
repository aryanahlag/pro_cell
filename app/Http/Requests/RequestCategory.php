<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCategory extends FormRequest
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
        if (request()->isMethod('POST')) {
            return [
                'name' => 'required|min:1',
            ];
        }
        else{
            return [
                'name' => 'required',
            ];
        }
    }

    public function messages()
    {
        return[
            'name.required' => 'Nama Kategori Harus Diisi !',
            'name.min' => 'Nama Kategori Minimal 1 Karakkter !',\
        ];
    }
}
