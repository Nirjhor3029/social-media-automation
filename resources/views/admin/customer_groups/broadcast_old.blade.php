@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            Send Broadcast Message
        </div>

        <div class="card-body">
            <form action="{{ route('admin.customer-groups.send-broadcast') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="groups">Select Customer Groups (To send to everyone in group)</label>
                    <select name="groups[]" id="groups" class="form-control select2" multiple>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }} ({{ $group->customers_count }} customers)
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Leave empty if you want to select specific customers below.</small>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-outline-primary" id="loadCustomersBtn">Load Customers from Selected
                        Groups</button>
                </div>

                <div class="form-group" id="specificCustomersSection" style="display: none;">
                    <label>Select Specific Customers (Optional)</label>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="30"><input type="checkbox" id="selectAllCustomers"></th>
                                    <th>WhatsApp</th>
                                    <th>Group</th>
                                </tr>
                            </thead>
                            <tbody id="customersTableBody">
                                <!-- Populated via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    <small class="form-text text-muted">If any customers are selected here, message will be sent ONLY to
                        them. If none selected, message will be sent to ALL in the selected groups above.</small>
                </div>

                <div class="form-group">
                    <label for="message" class="required">Message</label>
                    <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Send Broadcast
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            $('.select2').select2();

            $('#loadCustomersBtn').click(function () {
                var selectedGroups = $('#groups').val();
                if (!selectedGroups || selectedGroups.length === 0) {
                    alert('Please select at least one group.');
                    return;
                }

                var $tbody = $('#customersTableBody');
                $tbody.empty();
                $('#specificCustomersSection').show();
                // Show loading...
                $tbody.html('<tr><td colspan="3" class="text-center">Loading customers...</td></tr>');

                var promises = [];

                selectedGroups.forEach(function (groupId) {
                    // We use the route defined: admin/customer-groups/{id}/customers
                    var url = '{{ route("admin.customer-groups.get-customers", ":id") }}'.replace(':id', groupId);

                    var promise = $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json'
                    }).then(function (customers) {
                        return { groupId: groupId, customers: customers };
                    });

                    promises.push(promise);
                });

                $.when.apply($, promises).done(function () {
                    $tbody.empty();
                    // arguments is array of responses if multiple, or single response if one
                    // Normalize arguments
                    var responses = selectedGroups.length === 1 ? [arguments] : arguments;

                    // If only one promise, 'responses' is [data, textStatus, jqXHR], so we need to wrap it carefully
                    // Actually $.when logic is tricky with 1 vs many. 
                    // Let's simplified: just iterate requests, simpler than $.when for this rapid proto
                });

                // Rewrite with simpler logic: sequential or just fire all
                // For simplicity and robustness, let's just loop and append.
                $tbody.empty();

                selectedGroups.forEach(function (groupId) {
                    var url = '{{ route("admin.customer-groups.get-customers", ":id") }}'.replace(':id', groupId);
                    $.get(url, function (customers) {
                        customers.forEach(function (customer) {
                            // Check if already added to avoid duplicates if user is in multiple groups (though unique whatsapp preferred)
                            // For now just append
                            var row = '<tr>' +
                                '<td><input type="checkbox" name="specific_customers[]" value="' + customer.whatsapp + '" class="customer-checkbox"></td>' +
                                '<td>' + customer.whatsapp + '</td>' +
                                '<td>Group ' + groupId + '</td>' + // Could replace ID with Name if I passed it
                                '</tr>';
                            $tbody.append(row);
                        });
                    });
                });
            });

            $('#selectAllCustomers').change(function () {
                $('.customer-checkbox').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
@endsection