<?php

namespace App\Http\Requests;

use App\Models\Agen;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgenRequest extends FormRequest
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
        $agenId = $this->route('id'); // Assuming the route parameter is named 'id'
        $userId = null;

        if ($agenId) {
            $agen = Agen::find($agenId);
            if ($agen) {
                $userId = $agen->user_id;
            }
        }
        return [
            'nama_agen' => 'required|string|max:255',
            'domisili_agen' => 'required|string|max:255',
            'alamat_agen' => 'required|string|max:255',
            'notelp_agen' => 'required|numeric',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
        ];
    }
    /**
     * Get the custom validation messages for the rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_agen.required' => 'Nama tidak boleh kosong!',
            'domisili_agen.required' => 'Domisili tidak boleh kosong!',
            'alamat_agen.required' => 'Alamat tidak boleh kosong!',
            'notelp_agen.required' => 'Nomor telepon tidak boleh kosong!',
            'notelp_agen.numeric' => 'Nomor telepon tidak valid!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email tidak valid!',
            'email.unique' => 'Email sudah digunakan!',
        ];
    }
}