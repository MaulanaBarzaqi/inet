<?php

namespace App\Http\Requests\Region;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            'name' => 'required|max:255',
            'location' => 'required|max:255',
            'description' => 'required|max:500'
        ];
        // jika ada image
        if($this->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpg,jpeg,png|max:2048|dimensions:width=1000,height=400';
        }
        return $rules;
    }

     /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama region wajib diisi',
            'name.max' => 'Nama region maksimal 255 karakter',
            'location.required' => 'Lokasi region wajib diisi',
            'location.max' => 'Lokasi region maksimal 255 karakter',
            'description.required' => 'Deskripsi region wajib diisi',
            'description.max' => 'Deskripsi region maksimal 500 karakter',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Gambar harus format JPG, JPEG, atau PNG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'image.dimensions' => 'Dimensi gambar harus 800x400 pixel',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama region',
            'location' => 'lokasi region',
            'description' => 'deskripsi region',
            'image' => 'gambar region',
        ];
    }
}
