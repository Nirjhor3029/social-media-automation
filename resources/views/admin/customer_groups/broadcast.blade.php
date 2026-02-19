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
            {{-- Alert Section --}}
            @if(session('message'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-900/30 dark:bg-green-900/20 dark:text-green-400 animate-in fade-in slide-in-from-top-4 duration-300">
                    <span class="material-icons-round">check_circle</span>
                    <p class="text-sm font-medium">{{ session('message') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-900/30 dark:bg-red-900/20 dark:text-red-400 animate-in fade-in slide-in-from-top-4 duration-300">
                    <span class="material-icons-round">error</span>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

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
                            <span class="text-xs text-slate-400" id="charCountLabel">0 / 1024</span>
                        </div>
                        <div class="p-6">
                            <!-- Formatting Toolbar from group broadcast -->
                            <div class="mb-4 flex flex-wrap items-center gap-1 border-b border-slate-100 dark:border-slate-800 pb-3">
                                <button type="button" onclick="applyStyle('*')" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 hover:text-primary dark:text-slate-400 dark:hover:bg-slate-800" title="Bold">
                                    <span class="material-icons-round text-[20px]">format_bold</span>
                                </button>
                                <button type="button" onclick="applyStyle('_')" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 hover:text-primary dark:text-slate-400 dark:hover:bg-slate-800" title="Italic">
                                    <span class="material-icons-round text-[20px]">format_italic</span>
                                </button>
                                <button type="button" onclick="applyStyle('~')" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 hover:text-primary dark:text-slate-400 dark:hover:bg-slate-800" title="Strikethrough">
                                    <span class="material-icons-round text-[20px]">format_strikethrough</span>
                                </button>
                                <button type="button" onclick="applyStyle('```')" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 hover:text-primary dark:text-slate-400 dark:hover:bg-slate-800" title="Monospace">
                                    <span class="material-icons-round text-[20px]">code</span>
                                </button>
                                <div class="mx-2 h-4 w-[1px] bg-slate-200 dark:bg-slate-700"></div>
                                <button type="button" onclick="insertAtCursor('{Name}')"
                                    class="flex h-8 items-center gap-1 rounded-lg px-2 text-xs font-bold text-primary hover:bg-primary/10 transition-colors">
                                    <span class="material-icons-round text-[16px]">person_add</span>
                                    {Name}
                                </button>
                                <button type="button" onclick="insertAtCursor('{Whatsapp}')"
                                    class="flex h-8 items-center gap-1 rounded-lg px-2 text-xs font-bold text-primary hover:bg-primary/10 transition-colors">
                                    <span class="material-icons-round text-[16px]">phone</span>
                                    {Whatsapp}
                                </button>
                            </div>

                            <div class="relative">
                                <textarea id="messageTextarea" name="message" required
                                    class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary placeholder:text-slate-400 text-sm leading-relaxed min-h-[250px]"
                                    placeholder="Hello {Name}, we have a special update for you..." rows="8"></textarea>
                            </div>
                            
                            {{-- Preview Area --}}
                            <div class="mt-6">
                                <h3 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-3">Live Preview</h3>
                                <div class="rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 p-4 min-h-[100px] whitespace-pre-wrap text-sm text-slate-700 dark:text-slate-300 italic" id="messagePreview">
                                    Your message preview will appear here...
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="flex justify-end pt-4 pb-12">
                        <button type="submit" id="submitBtn" class="flex items-center gap-2 px-8 py-4 bg-primary text-white hover:bg-green-600 rounded-xl font-bold shadow-lg shadow-primary/20 transition-all transform hover:-translate-y-1 active:scale-95 group">
                            <span class="material-icons-round group-hover:rotate-12 transition-transform">campaign</span>
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
                                    Messages are sent sequentially with a small delay to comply with platform rate limits and avoid spam flags.
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </form>

    {{-- Processing Overlay --}}
    <div id="sendingOverlay" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-2xl flex flex-col items-center gap-4 max-w-sm text-center">
            <div class="relative w-16 h-16">
                <div class="absolute inset-0 border-4 border-slate-100 dark:border-slate-800 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Launching Campaign</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">We are queueing your messages. Please do not close this page.</p>
        </div>
    </div>
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
            updateLivePreview();
        }

        function applyStyle(style) {
            const textarea = document.getElementById('messageTextarea');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;
            const selectedText = text.substring(start, end);
            
            let wrappedText = '';
            if (style === '```') {
                 wrappedText = '```' + (selectedText || 'text') + '```';
            } else {
                 wrappedText = style + (selectedText || 'text') + style;
            }
            
            textarea.value = text.substring(0, start) + wrappedText + text.substring(end);
            textarea.focus();
            const newPos = start + wrappedText.length;
            textarea.setSelectionRange(newPos, newPos);
            updateLivePreview();
        }

        function updateLivePreview() {
            const textarea = document.getElementById('messageTextarea');
            const preview = document.getElementById('messagePreview');
            const charCount = document.getElementById('charCountLabel');
            const text = textarea.value;
            
            charCount.innerText = `${text.length} / 1024`;

            if (!text) {
                preview.innerHTML = "Your message preview will appear here...";
                preview.classList.add('italic', 'text-slate-400');
                return;
            }
            
            preview.classList.remove('italic', 'text-slate-400');
            
            // Basic WhatsApp Markdown Simulation
            let html = text
                .replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;") // Escape
                .replace(/\*(.*?)\*/g, '<b>$1</b>') // Bold
                .replace(/_(.*?)_/g, '<i>$1</i>') // Italic
                .replace(/~(.*?)~/g, '<strike>$1</strike>') // Strikethrough
                .replace(/```(.*?)```/gs, '<code class="bg-slate-100 dark:bg-slate-700 px-1 rounded">$1</code>') // Code
                .replace(/{Name}/g, '<span class="text-primary font-bold">John Doe</span>') // Placeholder
                .replace(/{Whatsapp}/g, '<span class="text-primary font-bold">+123456789</span>'); // Placeholder
            
            preview.innerHTML = html;
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: '100%',
                allowClear: true
            });

            $('#groupsSelect').on('change', function () {
                updateSummary();
            });

            $('#messageTextarea').on('input', updateLivePreview);

            $('#broadcastForm').on('submit', function() {
                $('#sendingOverlay').removeClass('hidden').addClass('flex');
            });

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
                $tbody.html('<tr><td colspan="4" class="px-6 py-4 text-center text-slate-500"><div class="animate-pulse">Loading customers from selected groups...</div></td></tr>');

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