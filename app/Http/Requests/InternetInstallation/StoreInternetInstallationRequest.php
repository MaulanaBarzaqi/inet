<?php

namespace App\Http\Requests\InternetInstallation;

use Illuminate\Foundation\Http\FormRequest;

class StoreInternetInstallationRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'internet_package_id' => 'required|integer|exists:internet_packages,id',
        ];
    }

     /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama maksimal 255 karakter',
            'nik.required' => 'NIK wajib diisi',
            'nik.string' => 'NIK harus berupa teks',
            'nik.max' => 'NIK maksimal 16 karakter',
            'phone.required' => 'Nomor telepon wajib diisi',
            'phone.string' => 'Nomor telepon harus berupa teks',
            'phone.max' => 'Nomor telepon maksimal 15 karakter',
            'address.required' => 'Alamat wajib diisi',
            'address.string' => 'Alamat harus berupa teks',
            'address.max' => 'Alamat maksimal 255 karakter',
            'internet_package_id.required' => 'Paket internet wajib dipilih',
            'internet_package_id.integer' => 'Paket internet harus berupa angka',
            'internet_package_id.exists' => 'Paket internet tidak valid',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama lengkap',
            'nik' => 'NIK',
            'phone' => 'nomor telepon',
            'address' => 'alamat',
            'internet_package_id' => 'paket internet',
        ];
    }
}
