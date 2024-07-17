<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'alamat' => 'required|string',
            'domisili' => 'required|string|max:255',
            'no_telp' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'domisili.required' => 'Domisili wajib diisi.',
            'no_telp.required' => 'No. Telepon wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'name.max' => 'Name maksimal 255 karakter.',
            'domisili.max' => 'Domisili maksimal 255 karakter.',
        ];
    }
}
