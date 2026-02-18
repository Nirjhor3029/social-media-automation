<?php

namespace App\Http\Controllers\Admin;

use App\Models\WhstappSubscriber;
use Illuminate\Support\Facades\Auth;

class HomeController
{
    public function index()
    {
        $subscriber = WhstappSubscriber::where('user_id', Auth::id())->first();

        // If supposedly connected, do a quick background check to verify
        if ($subscriber && $subscriber->session && in_array($subscriber->status, ['connected', 'authenticated', 'ready'])) {
            try {
                $baseUrl = env('SMA_BASE_URL', 'http://localhost:3000');
                $response = \Illuminate\Support\Facades\Http::get($baseUrl . "/api/sessions/{$subscriber->session}/status");
                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['ok']) && $data['ok']) {
                        $newStatus = $data['status'] ?? $subscriber->status;
                        if ($newStatus != $subscriber->status) {
                            $subscriber->update(['status' => $newStatus]);
                        }
                    }
                } else {
                    $data = $response->json();
                    if ($data['message'] == 'session not found') {
                        $subscriber->update([
                            'status' => 'closed',
                            'qr' => null,
                            'session' => null,
                            'qr_updated_at' => null,
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Silently fail to not break the dashboard load
            }
        }

        $whatsappSubscriber = $subscriber;
        return view('home', compact('whatsappSubscriber'));
    }
}
