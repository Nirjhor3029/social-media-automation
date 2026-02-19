<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendBroadcastMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;
    protected $message;
    protected $sessionId;

    /**
     * Create a new job instance.
     */
    public function __construct($phone, $message, $sessionId)
    {
        $this->phone = $phone;
        $this->message = $message;
        $this->sessionId = $sessionId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = env('SMA_BASE_URL') . '/api/messages/send';

        try {
            $response = Http::post($url, [
                'sessionId' => $this->sessionId,
                'numbers' => [$this->phone],
                'text' => $this->message,
            ]);

            if ($response->failed()) {
                Log::error("Failed to send broadcast to {$this->phone}: " . $response->body());
                // Release back to queue with delay if it's a server error or rate limit?
                // For now, let's just log it. If specific error codes (like 429), we could release.
                if ($response->status() === 429) {
                    $this->release(60);
                }
            } else {
                Log::info("Broadcast sent successfully to {$this->phone}");
            }
        } catch (\Exception $e) {
            Log::error("Exception in SendBroadcastMessage: " . $e->getMessage());
            $this->release(30); // Retry after 30 seconds on exception
        }
    }
}
