<?php

namespace App\Http\Requests\krs;
use Illuminate\Foundation\Http\FormRequest;

class krsRequest extends FormRequest
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
        return [
            'id_matakuliah'     => 'required|string|max:100',
            'total_sks'      => 'required|numeric|max:10',
        ];
    }
}
