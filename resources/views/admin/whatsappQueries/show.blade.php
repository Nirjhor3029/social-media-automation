@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Show Whatsapp Query
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.whatsapp-queries.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                ID
                            </th>
                            <td>
                                {{ $whatsappQuery->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Whatsapp Subscriber
                            </th>
                            <td>
                                {{ $whatsappQuery->whstapp_subscriber->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Question
                            </th>
                            <td>
                                {{ $whatsappQuery->question }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Answer
                            </th>
                            <td>
                                {!! nl2br(e($whatsappQuery->answer)) !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Hit Count
                            </th>
                            <td>
                                {{ $whatsappQuery->hit_count }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.whatsapp-queries.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection