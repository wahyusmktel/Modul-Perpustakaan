<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->route('member')->id ?? null;
        return [
            'code'       => ['required', 'string', 'max:50', Rule::unique('members', 'code')->ignore($id)],
            'name'       => 'required|string|max:255',
            'email'      => ['nullable', 'email', 'max:255', Rule::unique('members', 'email')->ignore($id)],
            'phone'      => 'nullable|string|max:50',
            'address'    => 'nullable|string|max:500',
            'expires_at' => 'nullable|date',
            'status'     => 'required|in:active,inactive',
        ];
    }
}
