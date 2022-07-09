<?php

namespace App\Imports;
use App\Models\Vocations;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class VocationImport implements ToCollection, withHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $row){
            $data  = [
                'category_id' => $row['category_id'],
                'vocations' => $row['vocations'],
            ];

            Vocations::create($data);
        }
    }
}
