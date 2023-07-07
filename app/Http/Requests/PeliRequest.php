<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class PeliRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // temporalmente a cierto
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'titulo'    => 'required|max:255',
                'director'  => 'required|max:255',
                'anyo'      => 'required|integer',                            
                //'descatalogada' => 'required_with:isan',
                'descatalogada' => 'isan|nullable',
                'isan'      => "required_if:descatalogada,1|
                                nullable|
                                regex:/[B-Z]/|
                                unique:pelis,isan",
                'imagen'    => 'sometimes|file|image|mimes:jpg,png,gif,webp|max:2048'
            ];
    }
}
