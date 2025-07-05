<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InternetPackageRequest extends FormRequest
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
            //
            'name' => 'required|max:255',
            'category' => 'required|max:255',
            'speed' => 'required|max:255',
            'ideal_device' => 'required|max:255',
            'installation' => 'required|integer',
            'monthly_bill' => 'required|integer',
        ];
    }
}
