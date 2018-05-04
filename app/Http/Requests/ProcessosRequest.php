<?php

namespace gv\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessosRequest extends FormRequest
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
          
          'nome' => 'required|max:100',
          'tipo' => 'required|max:100',
          'periodicidade' => 'required|max:100',
          'pasta' => 'required|max:100',
          'coordenacao' => 'required|max:100',
        ];
    }
    
    public function messages()
    {
        return [
        'required' => 'O :attribute é obrigatório',
        ];
    }

}
