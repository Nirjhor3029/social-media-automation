<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWhatsappGroupRequest;
use App\Http\Requests\StoreWhatsappGroupRequest;
use App\Http\Requests\UpdateWhatsappGroupRequest;
use App\Models\WhatsappGroup;
use App\Models\WhstappSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class WhatsappGroupController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('whatsapp_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $authUser = auth()->user();
        $subscribers = WhstappSubscriber::where('user_id', $authUser->id)->get();

        $whatsappGroups = WhatsappGroup::with(['whstapp_subscriber'])
            ->whereHas('whstapp_subscriber', function ($query) use ($authUser) {
                $query->where('user_id', $authUser->id);
            })
            ->get();

        return view('admin.whatsappGroups.index', compact('whatsappGroups', 'subscribers'));
    }

    public function syncGroups(Request $request)
    {
        $subscriberId = $request->subscriber_id;
        $subscriber = WhstappSubscriber::find($subscriberId);

        if (!$subscriber || !$subscriber->session) {
            return response()->json(['ok' => false, 'message' => 'Valid subscriber session not found.'], 404);
        }

        try {
            $baseUrl = env('SMA_BASE_URL', 'http://localhost:3000');
            $response = \Illuminate\Support\Facades\Http::get($baseUrl . "/api/groups/{$subscriber->session}");

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['ok']) && $data['ok'] && isset($data['groups'])) {
                    foreach ($data['groups'] as $groupData) {
                        WhatsappGroup::updateOrCreate(
                            [
                                'whstapp_subscriber_id' => $subscriber->id,
                                'group_identification' => $groupData['id'],
                            ],
                            [
                                'subject' => $groupData['subject'] ?? '',
                                'subject_owner' => $groupData['subjectOwner'] ?? null,
                                'subject_time' => $groupData['subjectTime'] ?? null,
                                'creation' => $groupData['creation'] ?? null,
                                'size' => $groupData['size'] ?? 0,
                                'title' => $groupData['subject'] ?? '',
                            ]
                        );
                    }
                    return response()->json(['ok' => true, 'message' => 'Groups synced successfully.']);
                }
            }
            return response()->json(['ok' => false, 'message' => 'Failed to fetch groups from API.'], 400);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('WhatsApp Groups Sync Error: ' . $e->getMessage());
            return response()->json(['ok' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        abort_if(Gate::denies('whatsapp_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whstapp_subscribers = WhstappSubscriber::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.whatsappGroups.create', compact('whstapp_subscribers'));
    }

    public function store(StoreWhatsappGroupRequest $request)
    {
        $whatsappGroup = WhatsappGroup::create($request->all());

        return redirect()->route('admin.whatsapp-groups.index');
    }

    public function edit(WhatsappGroup $whatsappGroup)
    {
        abort_if(Gate::denies('whatsapp_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whstapp_subscribers = WhstappSubscriber::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $whatsappGroup->load('whstapp_subscriber');

        return view('admin.whatsappGroups.edit', compact('whatsappGroup', 'whstapp_subscribers'));
    }

    public function update(UpdateWhatsappGroupRequest $request, WhatsappGroup $whatsappGroup)
    {
        $whatsappGroup->update($request->all());

        return redirect()->route('admin.whatsapp-groups.index');
    }

    public function show(WhatsappGroup $whatsappGroup)
    {
        abort_if(Gate::denies('whatsapp_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsappGroup->load('whstapp_subscriber');

        return view('admin.whatsappGroups.show', compact('whatsappGroup'));
    }

    public function destroy(WhatsappGroup $whatsappGroup)
    {
        abort_if(Gate::denies('whatsapp_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsappGroup->delete();

        return back();
    }

    public function massDestroy(MassDestroyWhatsappGroupRequest $request)
    {
        $whatsappGroups = WhatsappGroup::find(request('ids'));

        foreach ($whatsappGroups as $whatsappGroup) {
            $whatsappGroup->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function broadcastForm(Request $request)
    {
        $subscriberId = $request->subscriber_id;
        $groupIds = $request->ids;

        if (!$subscriberId || empty($groupIds)) {
            return redirect()->back()->with('error', 'Please select a subscriber and at least one group.');
        }

        $subscriber = WhstappSubscriber::findOrFail($subscriberId);
        $groups = WhatsappGroup::whereIn('id', $groupIds)->get();

        return view('admin.whatsappGroups.broadcast', compact('subscriber', 'groups'));
    }

    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'subscriber_id' => 'required',
            'group_jids' => 'required|array',
            'message' => 'required|string',
        ]);

        $subscriber = WhstappSubscriber::findOrFail($request->subscriber_id);
        $baseUrl = env('SMA_BASE_URL', 'http://localhost:3000');

        $successCount = 0;
        $failCount = 0;

        foreach ($request->group_jids as $jid) {
            $group = WhatsappGroup::where('group_identification', $jid)->first();
            $groupName = $group ? ($group->subject ?: $group->title) : 'Group';

            // Personalize message
            $personalizedMessage = str_replace('[Group Name]', $groupName, $request->message);

            try {
                $response = \Illuminate\Support\Facades\Http::post($baseUrl . "/api/groups/send", [
                    'sessionId' => $subscriber->session,
                    'groupJids' => [$jid],
                    'text' => $personalizedMessage,
                    'delayMs' => 1500,
                    'jitterMs' => 500
                ]);

                if ($response->successful()) {
                    $successCount++;
                } else {
                    $failCount++;
                }
            } catch (\Exception $e) {
                $failCount++;
                \Illuminate\Support\Facades\Log::error("Broadcast individual send error ($jid): " . $e->getMessage());
            }
        }

        $subscriber = WhstappSubscriber::findOrFail($request->subscriber_id);
        $groups = WhatsappGroup::whereIn('group_identification', $request->group_jids)->get();

        if ($failCount === 0) {
            session()->flash('success', "Broadcast sent successfully to all $successCount groups!");
        } else {
            session()->flash('success', "Broadcast completed. Success: $successCount, Failed: $failCount");
            if ($successCount === 0) {
                session()->flash('error', "Could not send broadcast to any selected groups.");
            }
        }

        return view('admin.whatsappGroups.broadcast', compact('subscriber', 'groups'));
    }
}
