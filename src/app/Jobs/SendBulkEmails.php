<?php

namespace App\Jobs;

use App\Mail\BulkEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBulkEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $emailData;

    /**
     * Create a new job instance.
     *
     * @param array $emailData
     * @return void
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sheet = $this->emailData;

        foreach ($sheet as $email) {
            try {
                if (isset($email['email']) && !empty($email['email'])) {
                    Mail::to(trim($email['email']))->queue(new BulkEmail($email));
                    Log::info('Queued email to: ' . json_encode($email));
                } else {
                    Log::warning('Email missing or empty for row: ' . json_encode($email));
                }
            } catch (\Exception $e) {
                Log::error('Failed to queue email to: ' . ($email['email'] ?? 'unknown') . '. Error: ' . $e->getMessage());
            }
        }
    }




}
