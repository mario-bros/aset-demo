<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
{
    public function __construct($userModels)
    {
        $this->users = $userModels;
    }

    public function collection()
    {
        // dd($this->users);
        return $this->users;
        // return $this->users->all();
    }
}