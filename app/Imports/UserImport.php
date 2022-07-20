<?php


namespace App\Imports;
use App\Models\User;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

set_time_limit(-1);

class UserImport implements ToCollection, withHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $row){
            $data  = [
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'fullname' => $row['fullname'],
                'phone' => $row['phone'],
                'bio' => $row['bio'],
                'has_profession' => $row['has_profession'],
                'business_id' => $row['business_id'],
                'password' => Hash::make($row['password']),   
            ];

            User::create($data);
        }
    }
}
