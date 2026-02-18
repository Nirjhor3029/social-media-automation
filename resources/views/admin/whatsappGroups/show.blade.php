@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.whatsappGroup.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whatsapp-groups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappGroup.fields.id') }}
                        </th>
                        <td>
                            {{ $whatsappGroup->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappGroup.fields.whstapp_subscriber') }}
                        </th>
                        <td>
                            {{ $whatsappGroup->whstapp_subscriber->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappGroup.fields.group_identification') }}
                        </th>
                        <td>
                            {{ $whatsappGroup->group_identification }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappGroup.fields.subject') }}
                        </th>
                        <td>
                            {{ $whatsappGroup->subject }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappGroup.fields.subject_owner') }}
                        </th>
                        <td>
                            {{ $whatsappGroup->subject_owner }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappGroup.fields.subject_time') }}
                        </th>
                        <td>
                            {{ $whatsappGroup->subject_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappGroup.fields.creation') }}
                        </th>
                        <td>
                            {{ $whatsappGroup->creation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappGroup.fields.size') }}
                        </th>
                        <td>
                            {{ $whatsappGroup->size }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappGroup.fields.title') }}
                        </th>
                        <td>
                            {{ $whatsappGroup->title }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whatsapp-groups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection