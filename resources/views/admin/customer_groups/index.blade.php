@extends('layouts.admin')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Customer Groups</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage your WhatsApp campaign segments and
                    group lists.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.customer-groups.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-success hover:bg-emerald-600 text-white font-medium rounded-lg transition-all shadow-sm">
                    <span class="material-icons-outlined text-sm mr-2">add</span>
                    Create New Group
                </a>
                <a href="{{ route('admin.customer-groups.broadcast') }}"
                    class="inline-flex items-center px-4 py-2 bg-primary hover:bg-indigo-700 text-white font-medium rounded-lg transition-all shadow-sm">
                    <span class="material-icons-outlined text-sm mr-2">campaign</span>
                    Start Campaign
                </a>
            </div>
        </div>
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div
                class="p-4 border-b border-slate-200 dark:border-slate-700 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <form id="searchForm" action="{{ route('admin.customer-groups.index') }}" method="GET"
                    class="flex flex-wrap items-center gap-2 w-full lg:w-auto">
                    <div class="relative w-full lg:w-96">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <span class="material-icons-outlined text-lg">search</span>
                        </span>
                        <input id="searchInput" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Search groups..." type="text" />
                    </div>
                </form>
                <div class="flex items-center space-x-1">
                    <button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg"
                        title='Export CSV'>
                        <span class="material-icons-outlined text-xl">description</span>
                    </button>
                    <!-- Other export buttons can remain static or be implemented later -->
                </div>
            </div>

            <div id="groupsTableContainer" class="overflow-x-auto custom-scrollbar">
                @include('admin.customer_groups.table', ['groups' => $groups])
            </div>
        </div>

        <button
            class="fixed bottom-6 right-6 p-3 bg-white dark:bg-slate-800 rounded-full shadow-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:scale-110 transition-transform"
            onclick="document.documentElement.classList.toggle('dark')">
            <span class="material-icons-outlined block dark:hidden">dark_mode</span>
            <span class="material-icons-outlined hidden dark:block">light_mode</span>
        </button>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            let debounceTimer;
            const searchInput = $('#searchInput');
            const tableContainer = $('#groupsTableContainer');

            // Search on Type
            searchInput.on('input', function () {
                clearTimeout(debounceTimer);
                const query = $(this).val();

                debounceTimer = setTimeout(function () {
                    fetchGroups(query);
                }, 300); // 300ms debounce
            });

            function fetchGroups(query) {
                $.ajax({
                    url: "{{ route('admin.customer-groups.index') }}",
                    type: "GET",
                    data: { search: query, ajax_search: true },
                    beforeSend: function () {
                        // Optional: Add loading indicator
                        tableContainer.addClass('opacity-50');
                    },
                    success: function (response) {
                        tableContainer.html(response.html);
                        tableContainer.removeClass('opacity-50');
                    },
                    error: function (xhr) {
                        console.error("Search failed: " + xhr.statusText);
                        tableContainer.removeClass('opacity-50');
                    }
                });
            }

            // Status Toggle
            $(document).on('change', '.status-toggle', function() {
                const groupId = $(this).data('id');
                const isChecked = $(this).is(':checked');
                const label = $(this).siblings('.status-label');

                $.ajax({
                    url: "{{ url('admin/customer-groups') }}/" + groupId + "/toggle-status",
                    type: "POST", // Use POST for state change
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: isChecked ? 1 : 0
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.status) {
                                label.text('Active')
                                     .removeClass('text-slate-400 dark:text-slate-500')
                                     .addClass('text-emerald-600 dark:text-emerald-400');
                            } else {
                                label.text('Inactive')
                                     .removeClass('text-emerald-600 dark:text-emerald-400')
                                     .addClass('text-slate-400 dark:text-slate-500');
                            }
                        } else {
                            alert('Failed to update status.');
                            $(this).prop('checked', !isChecked); // Revert
                        }
                    },
                    error: function() {
                        alert('Error updating status.');
                        $(this).prop('checked', !isChecked); // Revert
                    }
                });
            });
        });
    </script>
@endsection