<?php

namespace App\Http\Controllers;

use App\Jobs\GetFood;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Jobs\SendBulkEmails;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;  // Assuming you're using Laravel Excel to read files
use App\Imports\EmailsImport;         // Your custom import class

class EmailController extends Controller
{
    public function showForm()
    {
        return view('upload_emails');  // A view where users upload files
    }


    public function ApiFood()
    {
        try {
            // Dispatch the job to the 'food' queue
            GetFood::dispatch()->onQueue('food');

            // If the dispatch is successful, return a success message
            return response()->json(['message' => 'Job dispatched successfully']);
        } catch (\Exception $e) {
            // Catch any exception that occurs during the dispatch and return the error message
            return response()->json([
                'error' => 'Failed to dispatch job: ' . $e->getMessage()
            ], 500); // You can choose an appropriate status code like 500 for server error
        }
    }

    public function uploadEmails(Request $request): JsonResponse
    {
        try {
            // Validate file input
            $request->validate([
                'email_file' => 'required|file', // Only CSV
            ]);

            // Store uploaded file
            $path = $request->file('email_file')->store('uploads');

            // Get full path
            $fullPath = storage_path('app/' . $path);

            // Read CSV manually
            $emailData = [];

            if (($handle = fopen($fullPath, 'r')) !== false) {
                $header = null;

                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    if (!$header) {
                        $header = array_map('trim', $row);
                    } else {
                        $rowData = array_combine($header, array_map('trim', $row));
                        $emailData[] = $rowData;
                    }
                }

                fclose($handle);
            }

            if (empty($emailData)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No valid email data found in the file.',
                ], 400);
            }

            // Dispatch job
            SendBulkEmails::dispatch($emailData);

            return response()->json([
                'status' => 'success',
                'message' => 'Emails are being processed!',
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to upload and process emails: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process the file. Please try again.',
                'error' => $e->getMessage(), // (you can remove this in production)
            ], 500);
        }
    }


}
