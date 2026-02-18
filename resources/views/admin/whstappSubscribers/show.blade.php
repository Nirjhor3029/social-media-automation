@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.whstappSubscriber.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whstapp-subscribers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.id') }}
                        </th>
                        <td>
                            {{ $whstappSubscriber->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.user') }}
                        </th>
                        <td>
                            {{ $whstappSubscriber->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.name') }}
                        </th>
                        <td>
                            {{ $whstappSubscriber->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.phone') }}
                        </th>
                        <td>
                            {{ $whstappSubscriber->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.session') }}
                        </th>
                        <td>
                            {{ $whstappSubscriber->session }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.qr') }}
                        </th>
                        <td>
                            {{ $whstappSubscriber->qr }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.qr_updated_at') }}
                        </th>
                        <td>
                            {{ $whstappSubscriber->qr_updated_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.status') }}
                        </th>
                        <td>
                            {{ $whstappSubscriber->status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whstapp-subscribers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#whstapp_subscriber_whatsapp_groups" role="tab" data-toggle="tab">
                {{ trans('cruds.whatsappGroup.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="whstapp_subscriber_whatsapp_groups">
            @includeIf('admin.whstappSubscribers.relationships.whstappSubscriberWhatsappGroups', ['whatsappGroups' => $whstappSubscriber->whstappSubscriberWhatsappGroups])
        </div>
    </div>
</div>

@endsection