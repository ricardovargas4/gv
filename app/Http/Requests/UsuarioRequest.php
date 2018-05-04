<?php

namespace gv\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
     public function rules()
     {
         return [
           
           'name' => 'required|max:100',
           'email' => 'required|max:100',
           'password' => 'required|max:100',
         ];
     }
     
     public function messages()
     {
         return [
         'required' => 'O :attribute é obrigatório',
         ];
     }
}
