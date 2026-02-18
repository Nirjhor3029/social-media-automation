<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWhatsappGroupRequest;
use App\Http\Requests\StoreWhatsappGroupRequest;
use App\Http\Requests\UpdateWhatsappGroupRequest;
use App\Models\WhatsappGroup;
use App\Models\WhstappSubscriber;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhatsappGroupController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('whatsapp_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsappGroups = WhatsappGroup::with(['whstapp_subscriber'])->get();

        return view('admin.whatsappGroups.index', compact('whatsappGroups'));
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
}
