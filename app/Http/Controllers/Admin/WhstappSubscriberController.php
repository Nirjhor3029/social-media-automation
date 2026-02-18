<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWhstappSubscriberRequest;
use App\Http\Requests\StoreWhstappSubscriberRequest;
use App\Http\Requests\UpdateWhstappSubscriberRequest;
use App\Models\User;
use App\Models\WhstappSubscriber;
// use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isNull;

class WhstappSubscriberController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('whstapp_subscriber_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whstappSubscribers = WhstappSubscriber::with(['user'])->get();

        return view('admin.whstappSubscribers.index', compact('whstappSubscribers'));
    }

    public function create()
    {
        abort_if(Gate::denies('whstapp_subscriber_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.whstappSubscribers.create', compact('users'));
    }

    public function store(StoreWhstappSubscriberRequest $request)
    {
        $whstappSubscriber = WhstappSubscriber::create($request->all());

        return redirect()->route('admin.whstapp-subscribers.index');
    }

    public function edit(WhstappSubscriber $whstappSubscriber)
    {
        abort_if(Gate::denies('whstapp_subscriber_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $whstappSubscriber->load('user');

        return view('admin.whstappSubscribers.edit', compact('users', 'whstappSubscriber'));
    }

    public function update(UpdateWhstappSubscriberRequest $request, WhstappSubscriber $whstappSubscriber)
    {
        $whstappSubscriber->update($request->all());

        return redirect()->route('admin.whstapp-subscribers.index');
    }

    public function show(WhstappSubscriber $whstappSubscriber)
    {
        abort_if(Gate::denies('whstapp_subscriber_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whstappSubscriber->load('user', 'whstappSubscriberWhatsappGroups');

        return view('admin.whstappSubscribers.show', compact('whstappSubscriber'));
    }

    public function destroy(WhstappSubscriber $whstappSubscriber)
    {
        abort_if(Gate::denies('whstapp_subscriber_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whstappSubscriber->delete();

        return back();
    }

    public function massDestroy(MassDestroyWhstappSubscriberRequest $request)
    {
        $whstappSubscribers = WhstappSubscriber::find(request('ids'));

        foreach ($whstappSubscribers as $whstappSubscriber) {
            $whstappSubscriber->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }




    // New
    public function connect(Request $request)
    {
        // abort_if(Gate::denies('whstapp_subscriber_connect'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriber_id = $request->subscriber_id ?? null;
        $authUser = Auth::user();

        if (!isset($authUser->phone)) {
            return Redirect::back()->with('warning', 'Please update your phone number first.');
        }

        if ($subscriber_id == null) {
            $subcriber = WhstappSubscriber::where('phone', $authUser->phone)->first();
            if (!isset($subcriber)) {
                $subcriber = new WhstappSubscriber();
                $subcriber->name = $authUser->name;
                $subcriber->phone = $authUser->phone;
                $subcriber->user_id = $authUser->id;
                $subcriber->save();
            }
        } else {
            $subcriber = WhstappSubscriber::find($subscriber_id);
        }

        if (!$subcriber) {
            return Redirect::back()->with('error', 'Subscriber not found.');
        }

        // Only hit QR API if we don't have a QR OR if previous session is explicitly disconnected/failed
        $needsQr = !$subcriber->qr || in_array($subcriber->status, ['closed', 'disconnected', 'expired']);

        // Quick fix: if status is connected/authenticated/ready, we definitely DON'T need a new QR
        if (in_array($subcriber->status, ['connected', 'authenticated', 'ready'])) {
            $needsQr = false;
        }

        if ($needsQr) {
            try {
                $baseUrl = env('SMA_BASE_URL', 'http://localhost:3000');
                $response = \Illuminate\Support\Facades\Http::post($baseUrl . '/api/sessions/qr', [
                    'name' => $subcriber->name,
                    'number' => $subcriber->phone,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['ok']) && $data['ok']) {
                        $subcriber->update([
                            'session' => $data['sessionId'] ?? $subcriber->session,
                            'qr' => $data['qr'] ?? null,
                            'status' => $data['status'] ?? 'pending',
                            'qr_updated_at' => now(),
                        ]);
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('WhatsApp QR API Error: ' . $e->getMessage());
            }
        }

        return view('admin.whstappSubscribers.connect', compact('subcriber'));
    }

    public function checkStatus(Request $request)
    {
        $subscriber_id = $request->subscriber_id;
        $subcriber = WhstappSubscriber::find($subscriber_id);

        if (!$subcriber || !$subcriber->session) {
            return response()->json(['ok' => false, 'status' => 'error', 'message' => 'No session found'], 404);
        }

        try {
            $baseUrl = env('SMA_BASE_URL', 'http://localhost:3000');
            $response = \Illuminate\Support\Facades\Http::get($baseUrl . "/api/sessions/{$subcriber->session}/status");

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['ok']) && $data['ok']) {
                    $newStatus = $data['status'] ?? $subcriber->status;

                    // Update local DB if status changed
                    if ($newStatus != $subcriber->status) {
                        $subcriber->update(['status' => $newStatus]);
                    }

                    return response()->json([
                        'ok' => true,
                        'status' => $newStatus,
                        'session' => $subcriber->session
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'status' => 'error', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['ok' => false, 'status' => $subcriber->status]);
    }
}
