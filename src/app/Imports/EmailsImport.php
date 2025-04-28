<?php


namespace App\Imports;


use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToArray;

class EmailsImport implements ToArray
{
    public function array(array $rows)
    {
        // Loop through each row and trim the email before returning it
        foreach ($rows as $key => $row) {
            // Log each email before and after trimming
            if (isset($row['email'])) {
                Log::info('Before Trim: ' . $row['email']); // Log email before trimming
                $rows[$key]['email'] = trim($row['email']);
                Log::info('After Trim: ' . $rows[$key]['email']); // Log email after trimming
            }
        }

        return $rows;
    }



}
