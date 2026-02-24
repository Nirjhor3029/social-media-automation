<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMessageTemplateRequest;
use App\Http\Requests\StoreMessageTemplateRequest;
use App\Http\Requests\UpdateMessageTemplateRequest;
use App\Models\MessageTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class MessageTemplateController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('message_template_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $messageTemplates = MessageTemplate::with(['user'])->get();

        return view('admin.messageTemplates.index', compact('messageTemplates'));
    }

    public function create()
    {
        abort_if(Gate::denies('message_template_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.messageTemplates.create', compact('users'));
    }

    public function store(StoreMessageTemplateRequest $request)
    {
        $messageTemplate = MessageTemplate::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $messageTemplate->id]);
        }

        return redirect()->route('admin.message-templates.index');
    }

    public function edit(MessageTemplate $messageTemplate)
    {
        abort_if(Gate::denies('message_template_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $messageTemplate->load('user');

        return view('admin.messageTemplates.edit', compact('messageTemplate', 'users'));
    }

    public function update(UpdateMessageTemplateRequest $request, MessageTemplate $messageTemplate)
    {
        $messageTemplate->update($request->all());

        return redirect()->route('admin.message-templates.index');
    }

    public function show(MessageTemplate $messageTemplate)
    {
        abort_if(Gate::denies('message_template_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $messageTemplate->load('user');

        return view('admin.messageTemplates.show', compact('messageTemplate'));
    }

    public function destroy(MessageTemplate $messageTemplate)
    {
        abort_if(Gate::denies('message_template_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $messageTemplate->delete();

        return back();
    }

    public function massDestroy(MassDestroyMessageTemplateRequest $request)
    {
        $messageTemplates = MessageTemplate::find(request('ids'));

        foreach ($messageTemplates as $messageTemplate) {
            $messageTemplate->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('message_template_create') && Gate::denies('message_template_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new MessageTemplate();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function getTemplate(Request $request)
    {
        $template = MessageTemplate::where('user_id', auth()->id())
            ->where('id', $request->id)
            ->first();

        if ($template) {
            return response()->json([
                'status' => 'success',
                'message' => $template->message
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Template not found'
        ], 404);
    }

    public function quickStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $template = MessageTemplate::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return response()->json([
            'status' => 'success',
            'template' => $template
        ]);
    }
}
