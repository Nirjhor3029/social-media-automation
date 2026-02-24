@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.messageTemplate.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.message-templates.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.messageTemplate.fields.id') }}
                            </th>
                            <td>
                                {{ $messageTemplate->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.messageTemplate.fields.user') }}
                            </th>
                            <td>
                                {{ $messageTemplate->user->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.messageTemplate.fields.title') }}
                            </th>
                            <td>
                                {{ $messageTemplate->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.messageTemplate.fields.message') }}
                            </th>
                            <td>
                                {!! $messageTemplate->message !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.message-templates.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection