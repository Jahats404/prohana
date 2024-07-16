<?php

namespace App\Http\Requests;

use App\Models\Distributor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DistributorRequest extends FormRequest
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
        $distributorId = $this->route('id'); // Assuming the route parameter is named 'id'
        $userId = null;

        if ($distributorId) {
            $distributor = Distributor::find($distributorId);
            if ($distributor) {
                $userId = $distributor->user_id;
            }
        }
        return [
            'nama_distributor' => 'required|string|max:255',
            'domisili_distributor' => 'required|string|max:255',
            'alamat_distributor' => 'required|string|max:255',
            'notelp_distributor' => 'required|numeric',
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
            'nama_distributor.required' => 'Nama tidak boleh kosong!',
            'domisili_distributor.required' => 'Domisili tidak boleh kosong!',
            'alamat_distributor.required' => 'Alamat tidak boleh kosong!',
            'notelp_distributor.required' => 'Nomor telepon tidak boleh kosong!',
            'notelp_distributor.numeric' => 'Nomor telepon tidak valid!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email tidak valid!',
            'email.unique' => 'Email sudah digunakan!',
        ];
    }
}
