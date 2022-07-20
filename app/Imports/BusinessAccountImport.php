<?php

namespace App\Imports;
use App\Models\BusinessAccount;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BusinessAccountImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $row) {
            $data = [
                "business_name" => $row["business_name"],
                "business_descripition"=> $row["business_descripition"],
                "opening_time"=> $row["opening_time)"],
                "closing_time"=> $row["closing_time)"],
                "email"=> $row["email"],
                "phone"=> $row["phone"],
                "business_sub_category"=> $row["business_sub_category"],
                "full_address"=> $row["full_address"],
                "house_no"=> $row["house_no"],
                "postal_code"=> $row["postal_code"],
                "city_or_town"=> $row["city_or_town"],
                "county_locality"=> $row["county_locality"],
                "country_nation"=> $row["country_nation"],
                "latitude"=> $row["latitude"],
                "longtitude"=> $row["longtitude"],
                "active_days"=> $row["active_days"],
            ];


        }
    }
}
