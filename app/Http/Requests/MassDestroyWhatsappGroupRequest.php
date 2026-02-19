<?php

namespace App\Http\Requests;

use App\Models\WhatsappGroup;
Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWhatsappGroupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('whatsapp_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:whatsapp_groups,id',
        ];
    }
}
