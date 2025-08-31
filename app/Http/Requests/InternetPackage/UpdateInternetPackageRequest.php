<?php

namespace App\Http\Requests\InternetPackage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInternetPackageRequest extends FormRequest
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
            'name' => 'required|max:255',
            'category' => 'required|max:255',
            'speed' => 'required|max:255',
            'ideal_device' => 'required|max:255',
            'installation' => 'required|integer',
            'monthly_bill' => 'required|integer',
        ];
         // Image optional untuk update
        if ($this->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpg,jpeg,png|dimensions:width=512,height=512';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama paket internet wajib diisi',
            'name.max' => 'Nama paket internet maksimal 255 karakter',
            'category.required' => 'Kategori paket wajib diisi',
            'category.max' => 'Kategori paket maksimal 255 karakter',
            'speed.required' => 'Kecepatan internet wajib diisi',
            'speed.max' => 'Kecepatan internet maksimal 255 karakter',
            'ideal_device.required' => 'Device ideal wajib diisi',
            'ideal_device.max' => 'Device ideal maksimal 255 karakter',
            'installation.required' => 'Biaya instalasi wajib diisi',
            'installation.integer' => 'Biaya instalasi harus berupa angka',
            'monthly_bill.required' => 'Biaya bulanan wajib diisi',
            'monthly_bill.integer' => 'Biaya bulanan harus berupa angka',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Gambar harus format JPG, JPEG, atau PNG',
            'image.dimensions' => 'Dimensi gambar harus 512x512 pixel',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama paket',
            'category' => 'kategori',
            'speed' => 'kecepatan',
            'ideal_device' => 'device ideal',
            'installation' => 'biaya instalasi',
            'monthly_bill' => 'biaya bulanan',
        ];
    }

}
