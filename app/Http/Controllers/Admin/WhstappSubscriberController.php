<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWhstappSubscriberRequest;
use App\Http\Requests\StoreWhstappSubscriberRequest;
use App\Http\Requests\UpdateWhstappSubscriberRequest;
use App\Models\User;
use App\Models\WhstappSubscriber;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
}
