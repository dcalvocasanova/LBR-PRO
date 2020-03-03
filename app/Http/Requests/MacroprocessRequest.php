<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MacroprocessRequest extends FormRequest
{
    /**
     * Determine if the Macroprocess is authorized to make this request.
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
          'macroprocess' => 'required|string|max:100',
          'input' => 'required|string|max:100',
          'provider' => 'required|string|max:100',
        ];
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'macroprocess' => 'Macroproceso',
            'input' => 'Entrada',
            'provider' => 'Proveedor',
            'activity' => 'Actividad',
            'resposible' => 'Responsable',
        ];
    }
}
