@extends('layouts.admin')
@section('content')
    @can('whatsapp_group_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.whatsapp-groups.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.whatsappGroup.title_singular') }}
                </a>
            </div>
        </div>
    @endcan

    <!-- Main Content -->
    <main class="flex flex-1 flex-col overflow-hidden bg-background-light dark:bg-background-dark">
        <!-- Header -->
        <header
            class="flex h-16 shrink-0 items-center justify-between border-b border-slate-200 bg-white px-6 dark:border-slate-800 dark:bg-[#1a222c]">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">WhatsApp Groups
                    ({{ $whatsappGroups->count() }})</h2>
                <span
                    class="hidden rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400 sm:inline-flex">
                    <span class="mr-1.5 flex h-2 w-2 items-center justify-center">
                        <span class="absolute inline-flex h-2 w-2 animate-ping rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-green-500"></span>
                    </span>
                    Sync Active
                </span>
            </div>
            <div class="flex items-center gap-3">
                <button id="refresh-groups-btn"
                    class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <span class="material-symbols-outlined text-[18px]">refresh</span>
                    <span class="hidden sm:inline">Refresh Groups</span>
                </button>
                <button
                    class="relative rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-red-500"></span>
                </button>
            </div>
        </header>
        <!-- Scrollable Content Area -->
        <form id="broadcast-form" action="{{ route('admin.whatsapp-groups.broadcast-form') }}" method="POST"
            class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            @csrf

            @if(session('success'))
                <div
                    class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-900/30 dark:bg-green-900/20 dark:text-green-400">
                    <span class="material-symbols-outlined">check_circle</span>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div
                    class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-900/30 dark:bg-red-900/20 dark:text-red-400">
                    <span class="material-symbols-outlined">error</span>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <input type="hidden" name="subscriber_id" id="form-subscriber-id" value="">
            <!-- Filters & Actions -->
            <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div class="flex w-full flex-col gap-4 sm:w-auto lg:flex-row lg:items-end">
                    <div class="relative w-full sm:w-72">
                        <label class="sr-only" for="search">Search groups</label>
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="material-symbols-outlined text-slate-400">search</span>
                        </div>
                        <input
                            class="block w-full rounded-lg border-0 py-2.5 pl-10 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary dark:bg-slate-800 dark:ring-slate-700 dark:text-white sm:text-sm sm:leading-6"
                            id="search" name="search" placeholder="Search by name or number..." type="text" />
                    </div>
                    <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">
                        <div class="w-full sm:w-64">
                            <select
                                class="block w-full rounded-lg border-0 py-2.5 pl-3 pr-10 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-primary dark:bg-slate-800 dark:ring-slate-700 dark:text-white sm:text-sm sm:leading-6"
                                id="number-filter" name="number-filter">
                                <option value="">All Connected Numbers</option>
                                @foreach($subscribers as $subscriber)
                                    <option value="{{ $subscriber->id }}">{{ $subscriber->phone }} ({{ $subscriber->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" id="sync-now-btn"
                            class="flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[18px]">sync</span>
                            <span class="whitespace-nowrap">Sync Now</span>
                        </button>
                    </div>
                </div>
                <!-- View Toggle -->
                <div
                    class="flex items-center rounded-lg bg-white p-1 shadow-sm ring-1 ring-slate-200 dark:bg-slate-800 dark:ring-slate-700">
                    <button
                        class="rounded p-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white">
                        <span class="material-symbols-outlined text-[20px]">view_list</span>
                    </button>
                    <button class="rounded bg-slate-100 p-1.5 text-primary shadow-sm dark:bg-slate-700 dark:text-white">
                        <span class="material-symbols-outlined text-[20px]">grid_view</span>
                    </button>
                </div>
            </div>
            <!-- Bulk Selection Summary (Simulated State) -->
            <div id="selection-summary"
                class="hidden mb-4 items-center justify-between rounded-lg border border-primary/20 bg-primary/5 px-4 py-3 dark:border-primary/30 dark:bg-primary/10">
                <div class="flex items-center gap-3">
                    <div class="flex h-5 w-5 items-center justify-center rounded bg-primary text-white">
                        <span class="material-symbols-outlined text-[16px]">check</span>
                    </div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-200">
                        <span id="selected-count" class="font-bold text-primary">0 groups</span> selected
                    </span>
                </div>
                <button type="button" id="clear-selection"
                    class="text-sm font-medium text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white">Clear
                    selection</button>
            </div>
            <!-- Grid Layout -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
                @forelse($whatsappGroups as $group)
                    <div
                        class="group-card group relative flex cursor-pointer flex-col overflow-hidden rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-primary hover:shadow-md dark:border-slate-700 dark:bg-[#1a222c] dark:hover:border-primary">
                        <div class="absolute right-3 top-3 opacity-0 transition-opacity group-hover:opacity-100">
                            <input
                                class="h-5 w-5 rounded border-slate-300 text-primary focus:ring-primary dark:border-slate-600 dark:bg-slate-700"
                                type="checkbox" name="ids[]" value="{{ $group->id }}" />
                        </div>
                        <div class="mb-3 flex items-center justify-center pt-2">
                            <div
                                class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 text-primary ring-4 ring-slate-50 dark:bg-primary/20 dark:text-primary-light dark:ring-slate-800">
                                <span class="material-symbols-outlined text-3xl">groups</span>
                            </div>
                        </div>
                        <div class="mb-4 text-center">
                            <h3 class="line-clamp-1 text-base font-bold text-slate-900 dark:text-white">
                                {{ $group->subject ?: $group->title }}
                            </h3>
                            <div class="mt-1 flex items-center justify-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                                <span class="material-symbols-outlined text-[14px]">group</span>
                                <span>{{ $group->size }} Participants</span>
                            </div>
                        </div>
                        <div
                            class="mt-auto flex items-center justify-between border-t border-slate-100 pt-3 dark:border-slate-800">
                            <span
                                class="inline-flex items-center rounded bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                <span class="material-symbols-outlined mr-1 text-[12px]">smartphone</span>
                                {{ $group->whstapp_subscriber->phone ?? 'N/A' }}
                            </span>
                            <span class="text-[10px] text-slate-400">
                                {{ $group->created_at ? $group->created_at->diffForHumans() : '' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500 dark:text-slate-400">
                        No groups found. Please sync or connect your WhatsApp account.
                    </div>
                @endforelse
            </div>
            <!-- Pagination / Loader -->
            <div class="mt-8 flex items-center justify-center">
                <button
                    class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    Load More Groups
                </button>
            </div>
            <div class="h-20"></div> <!-- Spacer for FAB -->
        </form>
        </div>
        <!-- Floating Action Bar -->
        <div id="floating-bar"
            class="hidden fixed bottom-6 left-0 right-0 z-10 mx-auto flex w-fit flex-col items-center gap-2 px-4 sm:bottom-8 lg:left-20">
            <div
                class="flex items-center gap-2 rounded-full bg-slate-900 p-1 pl-4 pr-1 shadow-xl ring-1 ring-slate-900/10 backdrop-blur-sm dark:bg-white dark:ring-white/10">
                <div
                    class="flex flex-col text-xs font-medium text-slate-200 dark:text-slate-700 sm:flex-row sm:gap-1 sm:text-sm">
                    <span>Ready to broadcast to</span>
                    <span id="floating-selected-count" class="font-bold text-white dark:text-black">0 selected groups</span>
                </div>
                <button type="button" id="submit-broadcast"
                    class="flex items-center gap-2 rounded-full bg-primary px-4 py-2 text-sm font-bold text-white transition-transform hover:scale-105 active:scale-95 shadow-lg shadow-primary/30">
                    <span>Send Broadcast</span>
                    <span class="material-symbols-outlined text-[18px]">send</span>
                </button>
            </div>
        </div>
        <!-- Sync Loading Overlay -->
        <div id="sync-loader"
            class="hidden fixed inset-0 z-[100] items-center justify-center bg-slate-900/50 backdrop-blur-sm">
            <div class="flex flex-col items-center gap-4 rounded-2xl bg-white p-8 shadow-2xl dark:bg-[#1a222c]">
                <div class="h-12 w-12 animate-spin rounded-full border-4 border-primary border-t-transparent"></div>
                <div class="text-center">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Syncing Groups</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Please wait while we fetch groups from WhatsApp...
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            const $checkboxes = $('input[name="ids[]"]');
            const $summary = $('#selection-summary');
            const $floatingBar = $('#floating-bar');
            const $countText = $('#selected-count');
            const $floatingCountText = $('#floating-selected-count');

            function updateSelection() {
                const checkedCount = $checkboxes.filter(':checked').length;

                // Update visual state of cards
                $('.group-card').each(function () {
                    const $card = $(this);
                    const isChecked = $card.find('input[name="ids[]"]').is(':checked');

                    if (isChecked) {
                        $card.addClass('border-primary bg-primary/5 dark:bg-primary/10 ring-1 ring-primary/20')
                            .removeClass('border-slate-200 dark:border-slate-700');
                        $card.find('.absolute').removeClass('opacity-0'); // Show checkbox
                    } else {
                        $card.removeClass('border-primary bg-primary/5 dark:bg-primary/10 ring-1 ring-primary/20')
                            .addClass('border-slate-200 dark:border-slate-700');
                        $card.find('.absolute').addClass('opacity-0'); // Hide checkbox unless hovered (default behavior)
                    }
                });

                if (checkedCount > 0) {
                    $summary.removeClass('hidden').addClass('flex');
                    $floatingBar.removeClass('hidden').addClass('flex');
                    $countText.text(checkedCount + (checkedCount === 1 ? ' group' : ' groups'));
                    $floatingCountText.text(checkedCount + (checkedCount === 1 ? ' selected group' : ' selected groups'));
                } else {
                    $summary.addClass('hidden').removeClass('flex');
                    $floatingBar.addClass('hidden').removeClass('flex');
                }
            }

            $('.group-card').on('click', function (e) {
                // Prevent toggle if clicking on other interactive elements if needed
                if (!$(e.target).closest('input[type="checkbox"]').length) {
                    const $cb = $(this).find('input[name="ids[]"]');
                    $cb.prop('checked', !$cb.is(':checked')).trigger('change');
                }
            });

            $checkboxes.on('change', updateSelection);

            $('#clear-selection').on('click', function () {
                $checkboxes.prop('checked', false);
                updateSelection();
            });

            // Handle Search (Local filter)
            $('#search').on('keyup', function () {
                const value = $(this).val().toLowerCase();
                $('.grid > div').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Handle Syncing (Common Logic)
            function performSync() {
                const subscriberId = $('#number-filter').val();
                if (!subscriberId) {
                    alert('Please select a WhatsApp number first to sync groups.');
                    return;
                }
                
                $('#sync-loader').removeClass('hidden').addClass('flex');
                
                $.ajax({
                    url: "{{ route('admin.whatsapp-groups.sync') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        subscriber_id: subscriberId
                    },
                    success: function(response) {
                        if (response.ok) {
                            window.location.reload();
                        } else {
                            $('#sync-loader').addClass('hidden').removeClass('flex');
                            alert(response.message || 'Sync failed');
                        }
                    },
                    error: function(xhr) {
                        $('#sync-loader').addClass('hidden').removeClass('flex');
                        const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'An error occurred during sync';
                        alert(errorMsg);
                    }
                });
            }

            $('#refresh-groups-btn, #sync-now-btn').on('click', performSync);

            // Handle Number Filter (Local only)
            $('#number-filter').on('change', function () {
                const subscriberId = $(this).val();
                $('#form-subscriber-id').val(subscriberId); // Vital for broadcast form

                if (!subscriberId) {
                    $('.group-card').show(); // Show all group cards
                    return;
                }

                const selectedText = $(this).find('option:selected').text().split(' ')[0].toLowerCase().trim();

                $('.group-card').each(function () {
                    const cardPhone = $(this).find('.inline-flex').text().toLowerCase().trim();
                    if (cardPhone.indexOf(selectedText) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Initial sync of the hidden field if a filter is already selected (e.g. browser back)
            $('#form-subscriber-id').val($('#number-filter').val());

            // Handle Broadcast Submit
            $('#submit-broadcast').on('click', function () {
                const subscriberId = $('#form-subscriber-id').val();
                const selectedGroups = $('input[name="ids[]"]:checked').length;

                if (!subscriberId) {
                    alert('Please select a WhatsApp number first.');
                    return;
                }

                if (selectedGroups === 0) {
                    alert('Please select at least one group to broadcast.');
                    return;
                }

                $('#broadcast-form').submit();
            });
        });
    </script>
@endsection