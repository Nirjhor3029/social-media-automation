@extends('layouts.admin')
@section('content')
@can('whstapp_subscriber_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.whstapp-subscribers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.whstappSubscriber.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.whstappSubscriber.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-WhstappSubscriber">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.qr_updated_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.whstappSubscriber.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($whstappSubscribers as $key => $whstappSubscriber)
                        <tr data-entry-id="{{ $whstappSubscriber->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $whstappSubscriber->id ?? '' }}
                            </td>
                            <td>
                                {{ $whstappSubscriber->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $whstappSubscriber->name ?? '' }}
                            </td>
                            <td>
                                {{ $whstappSubscriber->phone ?? '' }}
                            </td>
                            <td>
                                {{ $whstappSubscriber->qr_updated_at ?? '' }}
                            </td>
                            <td>
                                {{ $whstappSubscriber->status ?? '' }}
                            </td>
                            <td>
                                @can('whstapp_subscriber_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.whstapp-subscribers.show', $whstappSubscriber->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('whstapp_subscriber_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.whstapp-subscribers.edit', $whstappSubscriber->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('whstapp_subscriber_delete')
                                    <form action="{{ route('admin.whstapp-subscribers.destroy', $whstappSubscriber->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

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
@can('whstapp_subscriber_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.whstapp-subscribers.massDestroy') }}",
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
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-WhstappSubscriber:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection