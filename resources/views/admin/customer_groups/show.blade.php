@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.customerGroup.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.customer-groups.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.customerGroup.fields.id') }}
                            </th>
                            <td>
                                {{ $customerGroup->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.customerGroup.fields.name') }}
                            </th>
                            <td>
                                {{ $customerGroup->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.customerGroup.fields.description') }}
                            </th>
                            <td>
                                {{ $customerGroup->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.customerGroup.fields.status') }}
                            </th>
                            <td>
                                {{ $customerGroup->status ? 'Active' : 'Inactive' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Add Single Customer
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.customer-groups.add-customer', $customerGroup->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="whatsapp" class="required">WhatsApp Number</label>
                            <input type="text" name="whatsapp" class="form-control" required placeholder="88017XXXXXXXX">
                        </div>
                        <div class="form-group">
                            <label for="name">Name (Optional)</label>
                            <input type="text" name="name" class="form-control" placeholder="John Doe">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Customer</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Import Customers (CSV)
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.customer-groups.import-customers', $customerGroup->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file" class="required">CSV File</label>
                            <input type="file" name="file" class="form-control-file" required>
                            <small class="form-text text-muted">File should be .csv or .txt. First column must be phone
                                number.</small>
                        </div>
                        <button type="submit" class="btn btn-info">Import Customers</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Customers in Group ({{ $customerGroup->customers->count() }})
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Customers">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>WhatsApp</th>
                            <th>Name</th>
                            <!-- Assuming name is not on customer table but maybe needed? For now just what's there -->
                            <th>Joined At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customerGroup->customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->whatsapp }}</td>
                                <td>{{ $customer->name ?? 'N/A' }}</td>
                                <td>{{ $customer->created_at }}</td>
                                <td>
                                    <!-- Add delete/remove logic later if requested -->
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
                order: [[0, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-Customers:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection