<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTemnplateRequest;
use App\Http\Requests\StoreTemnplateRequest;
use App\Http\Requests\UpdateTemnplateRequest;
use App\Models\Temnplate;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class TemnplateController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('temnplate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $temnplates = Temnplate::with(['user'])->get();

        return view('admin.temnplates.index', compact('temnplates'));
    }

    public function create()
    {
        abort_if(Gate::denies('temnplate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.temnplates.create', compact('users'));
    }

    public function store(StoreTemnplateRequest $request)
    {
        $temnplate = Temnplate::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $temnplate->id]);
        }

        return redirect()->route('admin.temnplates.index');
    }

    public function edit(Temnplate $temnplate)
    {
        abort_if(Gate::denies('temnplate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $temnplate->load('user');

        return view('admin.temnplates.edit', compact('temnplate', 'users'));
    }

    public function update(UpdateTemnplateRequest $request, Temnplate $temnplate)
    {
        $temnplate->update($request->all());

        return redirect()->route('admin.temnplates.index');
    }

    public function show(Temnplate $temnplate)
    {
        abort_if(Gate::denies('temnplate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $temnplate->load('user');

        return view('admin.temnplates.show', compact('temnplate'));
    }

    public function destroy(Temnplate $temnplate)
    {
        abort_if(Gate::denies('temnplate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $temnplate->delete();

        return back();
    }

    public function massDestroy(MassDestroyTemnplateRequest $request)
    {
        $temnplates = Temnplate::find(request('ids'));

        foreach ($temnplates as $temnplate) {
            $temnplate->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('temnplate_create') && Gate::denies('temnplate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Temnplate();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
