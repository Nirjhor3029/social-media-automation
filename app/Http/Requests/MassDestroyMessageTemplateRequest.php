<?php

namespace App\Http\Requests;

use App\Models\MessageTemplate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMessageTemplateRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('message_template_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:message_templates,id',
        ];
    }
}
