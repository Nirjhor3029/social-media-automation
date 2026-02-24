@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.whatsapp-queries.create') }}">
                Add New Query
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Whatsapp Query List
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-WhatsappQuery">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                ID
                            </th>
                            <th>
                                Subscriber
                            </th>
                            <th>
                                Question
                            </th>
                            <th>
                                Answer
                            </th>
                            <th>
                                Hits
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($whatsappQueries as $key => $whatsappQuery)
                            <tr data-entry-id="{{ $whatsappQuery->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $whatsappQuery->id ?? '' }}
                                </td>
                                <td>
                                    {{ $whatsappQuery->whstapp_subscriber->name ?? '' }}
                                </td>
                                <td>
                                    {{ $whatsappQuery->question ?? '' }}
                                </td>
                                <td>
                                    {{ Str::limit($whatsappQuery->answer, 50) ?? '' }}
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $whatsappQuery->hit_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-primary"
                                        href="{{ route('admin.whatsapp-queries.show', $whatsappQuery->id) }}">
                                        {{ trans('global.view') }}
                                    </a>

                                    <a class="btn btn-xs btn-info"
                                        href="{{ route('admin.whatsapp-queries.edit', $whatsappQuery->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>

                                    <form action="{{ route('admin.whatsapp-queries.destroy', $whatsappQuery->id) }}"
                                        method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.whatsapp-queries.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')
                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: { 'x-csrf-token': _token },
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }
                        })
                            .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-WhatsappQuery:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection