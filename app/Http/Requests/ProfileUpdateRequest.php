<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Email sengaja tidak divalidasi: warga tidak boleh mengubah email lewat
        // profil (pengaman di server, bukan hanya HTML read-only). Jalur resmi
        // penggantian email adalah pengurus RT di panel admin backend.
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
