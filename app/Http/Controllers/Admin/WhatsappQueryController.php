<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWhatsappQueryRequest;
use App\Http\Requests\StoreWhatsappQueryRequest;
use App\Http\Requests\UpdateWhatsappQueryRequest;
use App\Models\WhstappSubscriber;
use App\Models\WhatsappQuery;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhatsappQueryController extends Controller
{
    public function index()
    {
        abort_if(\Illuminate\Support\Facades\Gate::denies('whstapp_subscriber_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsappQueries = WhatsappQuery::with(['whstapp_subscriber'])->get();

        return view('admin.whatsappQueries.index', compact('whatsappQueries'));
    }

    public function create()
    {
        abort_if(\Illuminate\Support\Facades\Gate::denies('whstapp_subscriber_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whstapp_subscribers = WhstappSubscriber::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.whatsappQueries.create', compact('whstapp_subscribers'));
    }

    public function store(StoreWhatsappQueryRequest $request)
    {
        $whatsappQuery = WhatsappQuery::create($request->all());

        return redirect()->route('admin.whatsapp-queries.index');
    }

    public function edit(WhatsappQuery $whatsappQuery)
    {
        abort_if(\Illuminate\Support\Facades\Gate::denies('whstapp_subscriber_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whstapp_subscribers = WhstappSubscriber::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $whatsappQuery->load('whstapp_subscriber');

        return view('admin.whatsappQueries.edit', compact('whstapp_subscribers', 'whatsappQuery'));
    }

    public function update(UpdateWhatsappQueryRequest $request, WhatsappQuery $whatsappQuery)
    {
        $whatsappQuery->update($request->all());

        return redirect()->route('admin.whatsapp-queries.index');
    }

    public function show(WhatsappQuery $whatsappQuery)
    {
        abort_if(\Illuminate\Support\Facades\Gate::denies('whstapp_subscriber_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsappQuery->load('whstapp_subscriber');

        return view('admin.whatsappQueries.show', compact('whatsappQuery'));
    }

    public function destroy(WhatsappQuery $whatsappQuery)
    {
        abort_if(\Illuminate\Support\Facades\Gate::denies('whstapp_subscriber_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsappQuery->delete();

        return back();
    }

    public function massDestroy(MassDestroyWhatsappQueryRequest $request)
    {
        WhatsappQuery::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
