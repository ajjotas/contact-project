<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddContatoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|max:100',
            'email' => 'required|email|max:100',
            'telefone' => 'required|digits_between:10,11',
            'mensagem' => 'required|max:400',
            'arquivo' => 'required|mimes:pdf,doc,docx,odt,txt|max:500'
        ];
    }
}
