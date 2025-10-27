<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'code'       => 'required|string|max:50|unique:members,code',
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|max:255|unique:members,email',
            'phone'      => 'nullable|string|max:50',
            'address'    => 'nullable|string|max:500',
            'expires_at' => 'nullable|date',
            'status'     => 'required|in:active,inactive',
        ];
    }
}
