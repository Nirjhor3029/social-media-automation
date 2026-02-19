@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.customerGroup.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="mb-2">
                <a class="btn btn-success" href="{{ route('admin.customer-groups.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.customerGroup.title_singular') }}
                </a>
                <a class="btn btn-primary" href="{{ route('admin.customer-groups.broadcast') }}">
                    Send Broadcast
                </a>
            </div>
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-CustomerGroup">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Customers</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $key => $group)
                            <tr data-entry-id="{{ $group->id }}">
                                <td></td>
                                <td>{{ $group->id }}</td>
                                <td>{{ $group->name }}</td>
                                <td>{{ $group->status ? 'Active' : 'Inactive' }}</td>
                                <td>{{ $group->customers_count }}</td>
                                <td>
                                    <a class="btn btn-xs btn-primary"
                                        href="{{ route('admin.customer-groups.show', $group->id) }}">
                                        {{ trans('global.view') }}
                                    </a>

                                    <a class="btn btn-xs btn-info" href="{{ route('admin.customer-groups.edit', $group->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>

                                    <form action="{{ route('admin.customer-groups.destroy', $group->id) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-CustomerGroup:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection