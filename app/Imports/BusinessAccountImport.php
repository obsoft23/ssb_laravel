<?php

namespace App\Imports;
use App\Models\BusinessAccount;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class BusinessAccountImport implements ToCollection,  withHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $row) {
            $data = [
                "business_account_id" => $row["business_account_id"],
                "user_id" => $row["user_id"],
                "business_name" => $row["business_name"],
                "business_descripition"=> $row["business_descripition"],
                "opening_time"=> $row["opening_time"],
                "closing_time"=> $row["closing_time"],
                "email"=> $row["email"],
                "phone"=> $row["phone"],
                "business_sub_category"=> $row["business_sub_category"],
                "active_days"=> $row["active_days"],
            ];

            BusinessAccount::create($data);


        }
    }
}
