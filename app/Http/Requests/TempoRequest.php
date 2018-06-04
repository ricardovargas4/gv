<?php

namespace gv\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TempoRequest extends FormRequest
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

    public function rules()
    {
        return [
          
          'data_inicial' => 'required',
          'data_final' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
        'required' => 'O :attribute é obrigatório',
        ];
    }
}
