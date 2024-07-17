<?php

namespace App\Http\Requests\agen;

use App\Models\Pesanan;
use Illuminate\Foundation\Http\FormRequest;

class PesananRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            $distributor = Pesanan::find($distributorId);
            if ($distributor) {
                $userId = $distributor->user_id;
            }
        }
        return [
            //
        ];
    }
}