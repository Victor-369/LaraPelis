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
                                regex:/[A-Z]/|
                                unique:pelis,isan",
                'imagen'    => 'sometimes|file|image|mimes:jpg,png,gif,webp|max:2048'
            ];
    }

    public function messages() {
        return [            
            'isan.regex' => "El ISAN debe tener el formato texto",
            'color.regex' => "El color debe estar en formato RGB HEX, comezando por #",
            'anyo.number' => "El año debe ser mayor que 1900",
            'imagen.image' => "El fichero debe ser una imagen",
            'imagen.mimes' => "La imagen debe ser de tipo jpg, png, gif o webp",
        ];
    }
}
