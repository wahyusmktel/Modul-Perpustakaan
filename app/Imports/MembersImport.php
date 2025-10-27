<?php

namespace App\Imports;

use App\Models\Member;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithUpserts;

class MembersImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    WithBatchInserts,
    WithUpserts,
    SkipsOnError
{
    use SkipsErrors;

    /**
     * Map kolom:
     * code | name | email | phone | address | expires_at(YYYY-MM-DD) | status(active/inactive)
     */

    public function headingRow(): int
    {
        return 1;
    }

    public function model(array $row)
    {
        // Upsert by code
        return new Member([
            'code'       => trim((string)($row['code'] ?? '')),
            'name'       => trim((string)($row['name'] ?? '')),
            'email'      => $row['email'] ?? null,
            'phone'      => $row['phone'] ?? null,
            'address'    => $row['address'] ?? null,
            'expires_at' => $row['expires_at'] ?? null,
            'status'     => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            '*.code'       => ['required', 'string', 'max:50'],
            '*.name'       => ['required', 'string', 'max:255'],
            '*.email'      => ['nullable', 'email', 'max:255'],
            '*.phone'      => ['nullable', 'string', 'max:50'],
            '*.address'    => ['nullable', 'string', 'max:500'],
            '*.expires_at' => ['nullable', 'date'],
            '*.status'     => ['nullable', Rule::in(['active', 'inactive'])],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.code.required' => 'Kolom code wajib diisi.',
            '*.name.required' => 'Kolom name wajib diisi.',
            '*.email.email'   => 'Format email tidak valid.',
        ];
    }

    public function batchSize(): int
    {
        return 500;
    }

    // kolom unik untuk upsert
    public function uniqueBy()
    {
        return 'code';
    }
}
