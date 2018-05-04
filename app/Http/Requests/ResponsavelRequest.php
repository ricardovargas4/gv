<?php

namespace gv\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResponsavelRequest extends FormRequest
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
           
           'id_processo' => 'required|max:100',
           'usuario' => 'required|max:100',
         ];
     }
     
     public function messages()
     {
         return [
         'required' => 'O :attribute é obrigatório',
         ];
     }
 
}
