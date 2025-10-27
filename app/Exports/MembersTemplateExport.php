<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MembersTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['code', 'name', 'email', 'phone', 'address', 'expires_at', 'status'];
    }

    public function array(): array
    {
        return [
            ['SIS001', 'Adi Nugroho', 'adi@example.com', '08123456789', 'Jl. Merdeka 1', '2026-12-31', 'active'],
            ['GRU101', 'Bu Rina', 'rina@example.com', '08129876543', 'Jl. Melati 2', '', 'inactive'],
        ];
    }
}
