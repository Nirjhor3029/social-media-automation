@extends('layouts.admin')
@section('styles')
    <style>
        .select2-container--default .select2-selection--multiple {
            background-color: transparent !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            min-height: 48px !important;
            padding: 4px !important;
        }

        .dark .select2-container--default .select2-selection--multiple {
            border-color: #334155 !important;
            background-color: rgba(30, 41, 59, 0.5) !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: rgba(37, 211, 102, 0.1) !important;
            border: 1px solid rgba(37, 211, 102, 0.2) !important;
            color: #25D366 !important;
            border-radius: 9999px !important;
            padding: 2px 12px !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
                margin: 4px !important;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                color: #166534 !important;
                margin-right: 8px !important;
                border: none !important;
            }

            .select2-container--default .select2-search--inline .select2-search__field {
                color: inherit !important;
                font-size: 0.875rem !important;
                padding-left: 8px !important;
            }

            .dark .select2-dropdown {
                background-color: #1e293b !important;
                border-color: #334155 !important;
                color: #f1f5f9 !important;
            }

            .dark .select2-results__option--highlighted[aria-selected] {
                background-color: #25D366 !important;
                color: white !important;
            }

            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 10px;
            }
            .dark .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #4b5563;
            }
        </style>
@endsection

@section('content')
    <form id="broadcastForm" action="{{ route('admin.customer-groups.send-broadcast') }}" method="POST">
        @csrf
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="flex-1 space-y-8">
                    {{-- Section 1: Target Groups --}}
                    <section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden text-slate-900 dark:text-white">
                        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-bold text-sm">1</span>
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Select Target Groups</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Customer Groups</label>
                            <div class="relative">
                                <select name="groups[]" id="groupsSelect" class="w-full select2" multiple data-placeholder="Search and select groups...">
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" data-count="{{ $group->customers_count }}">
                                            {{ $group->name }} ({{ $group->customers_count }} customers)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Leave empty if you want to select specific customers manually below.</p>
                            <div class="mt-4">
                                <button type="button" id="loadCustomersBtn"
                                    class="inline-flex items-center px-4 py-2 border border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg text-sm font-medium transition-all">
                                    <span class="material-icons-round text-sm mr-2">refresh</span>
                                    Load Customers from Selected Groups
                                </button>
                            </div>
                        </div>
                    </section>

                    {{-- Section 2: Specific Customers --}}
                    <section id="specificCustomersSection" class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden hidden">
                        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-bold text-sm">2</span>
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Select Specific Customers <span class="text-sm font-normal text-slate-500 dark:text-slate-500 ml-2">(Optional)</span></h2>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <span class="material-icons-round text-sm">search</span>
                                    </span>
                                    <input id="contactSearch"
                                        class="pl-9 pr-4 py-1.5 text-xs border border-slate-300 dark:border-slate-700 rounded-md bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                        placeholder="Filter contacts..." type="text" />
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto custom-scrollbar max-h-96">
                            <table class="w-full text-left text-sm border-collapse">
                                <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-3 font-medium text-slate-500 w-10 text-center">
                                            <input id="selectAllCustomers" class="rounded border-slate-300 text-primary focus:ring-primary" type="checkbox" />
                                        </th>
                                        <th class="px-6 py-3 font-medium text-slate-500">WhatsApp</th>
                                        <th class="px-6 py-3 font-medium text-slate-500">Name</th>
                                        <th class="px-6 py-3 font-medium text-slate-500">Group</th>
                                    </tr>
                                </thead>
                                <tbody id="customersTableBody" class="divide-y divide-slate-100 dark:divide-slate-800">
                                    {{-- Populated via AJAX --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-3 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 text-xs text-slate-500 dark:text-slate-400 italic text-center">
                            Note: If specific customers are selected, they will be the only recipients.
                        </div>
                    </section>

                    {{-- Section 3: Compose Message --}}
                    <section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden text-slate-900 dark:text-white">
                        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-bold text-sm">3</span>
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Compose Message</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="mb-4 flex flex-wrap gap-2 text-slate-900 dark:text-white">
                                <button type="button" onclick="insertAtCursor('{Name}')"
                                    class="px-3 py-1.5 rounded-md bg-slate-100 dark:bg-slate-800 text-xs font-medium hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                    <span class="text-blue-500 mr-1">{</span>Name<span class="text-blue-500 ml-1">}</span>
                                </button>
                                <button type="button" class="px-3 py-1.5 rounded-md bg-slate-100 dark:bg-slate-800 text-xs font-medium hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                    <span class="material-icons-round text-sm align-middle mr-1">sentiment_satisfied</span>
                                    Emoji
                                </button>
                            </div>
                            <div class="relative">
                                <textarea id="messageTextarea" name="message" required
                                    class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary placeholder-slate-400 text-sm leading-relaxed"
                                    placeholder="Hello {Name}, we have a special update for you..." rows="8"></textarea>
                                <div class="absolute bottom-3 right-3 text-xs text-slate-400 dark:text-slate-500 bg-white/80 dark:bg-slate-800/80 px-2 py-1 rounded">
                                    <span id="charCount">0</span> / 1024
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="flex justify-end pt-4 pb-12">
                        <button type="submit" class="flex items-center gap-2 px-8 py-4 bg-primary text-white hover:bg-green-600 rounded-xl font-bold shadow-lg shadow-primary/20 transition-all transform hover:-translate-y-1 active:scale-95">
                            <span class="material-icons-round">campaign</span>
                            LAUNCH BROADCAST CAMPAIGN
                        </button>
                    </div>
                </div>

                {{-- Sidebar: Summary --}}
                <aside class="lg:w-80 space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 sticky top-24">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-6 font-display">Campaign Summary</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-slate-50 dark:border-slate-800">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Total Recipients</span>
                                <span id="summaryTotalCount" class="text-lg font-bold text-slate-900 dark:text-white font-display">0</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-50 dark:border-slate-800">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Selected Groups</span>
                                <span id="summaryGroupsCount" class="text-sm font-medium text-slate-900 dark:text-white">0 Groups</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-50 dark:border-slate-800">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Est. Send Time</span>
                                <span id="summaryEstTime" class="text-sm font-medium text-slate-900 dark:text-white">~0 minutes</span>
                            </div>
                        </div>
                        <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800/30">
                            <div class="flex gap-3">
                                <span class="material-icons-round text-blue-500 text-sm">info</span>
                                <p class="text-[11px] text-blue-700 dark:text-blue-300 leading-relaxed">
                                    Messages are sent sequentially to comply with platform rate limits and avoid spam flags.
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </form>
@endsection

@section('scripts')
    @parent
    <script>
        function insertAtCursor(text) {
            const textarea = document.getElementById('messageTextarea');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const val = textarea.value;
            textarea.value = val.substring(0, start) + text + val.substring(end);
            textarea.selectionStart = textarea.selectionEnd = start + text.length;
            textarea.focus();
            updateCharCount();
        }

        function updateCharCount() {
            const count = $('#messageTextarea').val().length;
            $('#charCount').text(count);
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: '100%',
                allowClear: true
            });

            $('#groupsSelect').on('change', function () {
                updateSummary();
            });

            $('#messageTextarea').on('input', updateCharCount);

            function updateSummary() {
                const selectedGroups = $('#groupsSelect').select2('data');
                let totalCount = 0;

                selectedGroups.forEach(group => {
                    const count = parseInt(group.element.dataset.count) || 0;
                    totalCount += count;
                });

                const checkedSpecific = $('.customer-checkbox:checked').length;
                if (checkedSpecific > 0) {
                    $('#summaryTotalCount').text(checkedSpecific);
                } else {
                    $('#summaryTotalCount').text(totalCount);
                }

                $('#summaryGroupsCount').text(selectedGroups.length + ' Groups');
                const recipients = checkedSpecific > 0 ? checkedSpecific : totalCount;
                const estMinutes = Math.ceil(recipients * 0.5 / 60); 
                $('#summaryEstTime').text('~' + estMinutes + ' minutes');
            }

            $('#loadCustomersBtn').click(function () {
                var selectedGroups = $('#groupsSelect').val();
                if (!selectedGroups || selectedGroups.length === 0) {
                    alert('Please select at least one group.');
                    return;
                }

                var $tbody = $('#customersTableBody');
                $tbody.empty();
                $('#specificCustomersSection').removeClass('hidden');
                $tbody.html('<tr><td colspan="4" class="px-6 py-4 text-center text-slate-500">Loading customers...</td></tr>');

                let fetchedCount = 0;
                let groupsToFetch = selectedGroups.length;

                selectedGroups.forEach(function (groupId) {
                    var url = '{{ route("admin.customer-groups.get-customers", ":id") }}'.replace(':id', groupId);
                    var groupName = $("#groupsSelect option[value='" + groupId + "']").text().split('(')[0].trim();

                    $.get(url, function (customers) {
                        if (fetchedCount === 0) $tbody.empty();

                        customers.forEach(function (customer) {
                            var row = `<tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors customer-row">
                                        <td class="px-6 py-4 text-center"><input type="checkbox" name="specific_customers[]" value="${customer.whatsapp}" class="rounded border-slate-300 text-primary focus:ring-primary customer-checkbox"></td>
                                        <td class="px-6 py-4 font-mono text-slate-700 dark:text-slate-300">${customer.whatsapp}</td>
                                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">${customer.name || '-'}</td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 rounded bg-slate-100 dark:bg-slate-700 text-xs text-slate-600 dark:text-slate-400">${groupName}</span></td>
                                    </tr>`;
                            $tbody.append(row);
                        });

                        fetchedCount++;
                        if (fetchedCount === groupsToFetch && $tbody.is(':empty')) {
                            $tbody.html('<tr><td colspan="4" class="px-6 py-4 text-center text-slate-500">No customers found in these groups.</td></tr>');
                        }
                        updateSummary();
                    });
                });
            });

            $(document).on('change', '.customer-checkbox', function () {
                updateSummary();
            });

            $('#selectAllCustomers').change(function () {
                $('.customer-checkbox').prop('checked', $(this).prop('checked'));
                updateSummary();
            });

            $('#contactSearch').on('input', function () {
                const query = $(this).val().toLowerCase();
                $('.customer-row').each(function () {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.indexOf(query) > -1);
                });
            });
        });
    </script>
@endsection