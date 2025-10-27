<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MembersImport;
use App\Exports\MembersTemplateExport;

class MemberImportController extends Controller
{
    public function form()
    {
        return view('members.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120', // max 5MB
        ]);

        try {
            Excel::import(new MembersImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            // tampilkan ringkas di flash, detail di view
            return back()->with([
                'import_errors' => collect($failures)->map(function ($f) {
                    return [
                        'row' => $f->row(),
                        'attribute' => $f->attribute(),
                        'errors' => $f->errors(),
                        'values' => $f->values(),
                    ];
                }),
            ]);
        }

        return redirect()->route('members.index')->with('success', 'Import anggota berhasil diproses.');
    }

    public function template()
    {
        $filename = 'template-import-anggota.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new MembersTemplateExport, $filename);
    }
}
