<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\WhstappSubscriber;
use App\Models\WhatsappQuery;
use Illuminate\Http\Request;

class WhatsappApiController extends Controller
{
    public function getQueries(Request $request)
    {
        $sessionId = $request->query('sessionId');

        if (!$sessionId) {
            return response()->json([
                'ok' => false,
                'message' => 'sessionId is required'
            ], 400);
        }

        $subscriber = WhstappSubscriber::where('session', $sessionId)->first();

        if (!$subscriber) {
            return response()->json([
                'ok' => false,
                'message' => 'Subscriber not found with this sessionId'
            ], 404);
        }

        $queries = WhatsappQuery::where('whstapp_subscriber_id', $subscriber->id)
            ->select('id', 'question', 'hit_count')
            ->get();

        return response()->json([
            'ok' => true,
            'data' => $queries
        ]);
    }

    public function getAnswer(Request $request)
    {
        $sessionId = $request->query('sessionId');
        $questionId = $request->query('question_id'); // User referred to question_no, but I'll use ID/index

        if (!$sessionId || !$questionId) {
            return response()->json([
                'ok' => false,
                'message' => 'sessionId and question_id are required'
            ], 400);
        }

        $subscriber = WhstappSubscriber::where('session', $sessionId)->first();

        if (!$subscriber) {
            return response()->json([
                'ok' => false,
                'message' => 'Subscriber not found'
            ], 404);
        }

        $query = WhatsappQuery::where('whstapp_subscriber_id', $subscriber->id)
            ->where('id', $questionId)
            ->first();

        if (!$query) {
            return response()->json([
                'ok' => false,
                'message' => 'Question not found for this subscriber'
            ], 404);
        }

        // Increment hit counter
        $query->increment('hit_count');

        return response()->json([
            'ok' => true,
            'answer' => $query->answer,
            'hit_count' => $query->hit_count
        ]);
    }
}
