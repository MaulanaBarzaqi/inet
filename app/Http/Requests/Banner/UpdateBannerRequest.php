<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
        $rules = [
            'title' => 'required|max:255',
        ];
         // Image optional untuk update (tidak required)
        if ($this->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpg,jpeg,png|dimensions:width=1000,height=400';
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul banner wajib diisi',
            'title.max' => 'Judul banner maksimal 255 karakter',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Gambar harus format JPG, JPEG, atau PNG',
            'image.dimensions' => 'Dimensi gambar harus 1000x400 pixel',
        ];
    }

     public function attributes(): array
    {
        return [
            'title' => 'judul banner',
        ];
    }
}
