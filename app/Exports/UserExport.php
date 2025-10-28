<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::with('role')->get()->map(function ($user) {
            return [
                'ID' => $user->id,
                'Name' => $user->name,
                'Email' => $user->email,
                'Role' => $user->role ? $user->role->name : 'N/A',
                'Gender' => $user->gender,
                'Date of Birth' => $user->date_of_birth,
                'Profile Image' => $user->profile_image,
                'Created At' => $user->created_at,
                'Updated At' => $user->updated_at,
                'Deleted At' => $user->deleted_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Role',
            'Gender',
            'Date of Birth',
            'Profile Image',
            'Created At',
            'Updated At',
            'Deleted At',
        ];
    }
}
