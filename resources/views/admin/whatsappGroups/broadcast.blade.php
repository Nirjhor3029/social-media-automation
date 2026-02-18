@extends('layouts.admin')
@section('content')
    <div class="flex flex-col h-full bg-slate-50 dark:bg-background-dark">
        <!-- Header -->
        <header
            class="flex h-16 shrink-0 items-center justify-between border-b border-slate-200 bg-white px-6 dark:border-slate-800 dark:bg-[#1a222c]">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.whatsapp-groups.index') }}"
                    class="flex h-10 w-10 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Create Broadcast</h2>
            </div>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">
                    <span class="material-symbols-outlined mr-1 text-[16px]">groups</span>
                    {{ $groups->count() }} Groups Selected
                </span>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            <div class="mx-auto max-w-4xl">
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
                <form action="{{ route('admin.whatsapp-groups.send-broadcast') }}" method="POST" id="send-broadcast-form">
                    @csrf
                    <input type="hidden" name="subscriber_id" value="{{ $subscriber->id }}">

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                        <!-- Left Column: Details -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Message Input -->
                            <div
                                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1a222c]">
                                <div class="mb-4 flex items-center justify-between">
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Compose Message</h3>
                                    <span class="text-xs text-slate-400" id="char-count">0 characters</span>
                                </div>
                                <!-- Formatting Toolbar -->
                                <div
                                    class="mb-3 flex flex-wrap items-center gap-1 border-b border-slate-100 pb-2 dark:border-slate-800">
                                    <button type="button" data-style="*"
                                        class="format-btn flex h-8 w-8 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 hover:text-primary dark:text-slate-400 dark:hover:bg-slate-800"
                                        title="Bold">
                                        <span class="material-symbols-outlined text-[20px]">format_bold</span>
                                    </button>
                                    <button type="button" data-style="_"
                                        class="format-btn flex h-8 w-8 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 hover:text-primary dark:text-slate-400 dark:hover:bg-slate-800"
                                        title="Italic">
                                        <span class="material-symbols-outlined text-[20px]">format_italic</span>
                                    </button>
                                    <button type="button" data-style="~"
                                        class="format-btn flex h-8 w-8 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 hover:text-primary dark:text-slate-400 dark:hover:bg-slate-800"
                                        title="Strikethrough">
                                        <span class="material-symbols-outlined text-[20px]">format_strikethrough</span>
                                    </button>
                                    <button type="button" data-style="```"
                                        class="format-btn flex h-8 w-8 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 hover:text-primary dark:text-slate-400 dark:hover:bg-slate-800"
                                        title="Monospace">
                                        <span class="material-symbols-outlined text-[20px]">code</span>
                                    </button>
                                    <div class="mx-1 h-4 w-[1px] bg-slate-200 dark:bg-slate-700"></div>
                                    <button type="button"
                                        class="insert-placeholder flex h-8 items-center gap-1 rounded-lg px-2 text-xs font-bold text-primary hover:bg-primary/10">
                                        <span class="material-symbols-outlined text-[16px]">person_add</span>
                                        [Group Name]
                                    </button>
                                </div>
                                <textarea name="message" id="message-text" rows="10"
                                    class="block w-full rounded-xl border-slate-200 bg-slate-50 p-4 text-slate-900 placeholder:text-slate-400 focus:border-primary focus:ring-primary dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500"
                                    placeholder="Type your message here... You can use emojis and line breaks."
                                    required></textarea>
                            </div>

                            <!-- Preview (Optional) -->
                            <div class="rounded-2xl border border-dotted border-slate-300 p-6 dark:border-slate-700">
                                <h3
                                    class="mb-4 text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Preview</h3>
                                <div class="rounded-xl bg-slate-100 p-4 dark:bg-slate-800">
                                    <div id="message-preview"
                                        class="whitespace-pre-wrap text-sm text-slate-700 dark:text-slate-300 italic">Your
                                        message preview will appear here...</div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Settings & Selection -->
                        <div class="space-y-6">
                            <!-- Connected Account -->
                            <div
                                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1a222c]">
                                <h3 class="mb-4 text-sm font-bold text-slate-900 dark:text-white">Sending From</h3>
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 dark:bg-green-900/30">
                                        <span class="material-symbols-outlined">smartphone</span>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="truncate text-sm font-bold text-slate-900 dark:text-white">
                                            {{ $subscriber->phone }}
                                        </div>
                                        <div class="truncate text-xs text-slate-500">{{ $subscriber->name }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Target Groups -->
                            <div
                                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1a222c]">
                                <h3 class="mb-4 text-sm font-bold text-slate-900 dark:text-white">Target Groups
                                    ({{ $groups->count() }})</h3>
                                <div class="max-h-60 overflow-y-auto space-y-2 pr-2 custom-scrollbar">
                                    @foreach($groups as $group)
                                        <div class="flex items-center gap-2 rounded-lg bg-slate-50 p-2 dark:bg-slate-800">
                                            <input type="hidden" name="group_jids[]" value="{{ $group->group_identification }}">
                                            <span class="material-symbols-outlined text-[18px] text-slate-400">group</span>
                                            <span
                                                class="truncate text-xs font-medium text-slate-700 dark:text-slate-300">{{ $group->subject ?: $group->title }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Action -->
                            <button type="submit" id="send-broadcast-btn"
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-4 text-base font-bold text-white shadow-lg shadow-primary/30 transition-all hover:scale-[1.02] active:scale-[0.98]">
                                <span>Send Broadcast Now</span>
                                <span class="material-symbols-outlined">send</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Processing Overlay -->
    <div id="sending-overlay"
        class="hidden fixed inset-0 z-[100] items-center justify-center bg-slate-900/50 backdrop-blur-sm">
        <div class="flex flex-col items-center gap-4 rounded-2xl bg-white p-8 shadow-2xl dark:bg-[#1a222c]">
            <div class="h-16 w-16 relative">
                <div class="absolute inset-0 animate-ping rounded-full bg-primary/20"></div>
                <div
                    class="relative flex h-full w-full items-center justify-center rounded-full bg-white text-primary shadow-sm dark:bg-slate-800">
                    <span class="material-symbols-outlined text-3xl animate-bounce">send</span>
                </div>
            </div>
            <div class="text-center">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Sending Broadcast...</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">This may take a moment depending on the number of
                    groups.</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            const $textarea = $('#message-text');
            const $preview = $('#message-preview');
            const $charCount = $('#char-count');
            const $form = $('#send-broadcast-form');
            const $overlay = $('#sending-overlay');

            // Update preview and count
            function updatePreview() {
                let text = $textarea.val();
                $charCount.text(text.length + ' characters');

                if (!text) {
                    $preview.html('Your message preview will appear here...')
                        .addClass('italic text-slate-400').removeClass('text-slate-900 dark:text-white');
                    return;
                }

                $preview.removeClass('italic text-slate-400').addClass('text-slate-900 dark:text-white');

                // Basic WhatsApp Markdown Parser for Preview
                let html = text
                    .replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;") // Escape HTML
                    .replace(/\*(.*?)\*/g, '<strong>$1</strong>') // Bold
                    .replace(/_(.*?)_/g, '<em>$1</em>') // Italic
                    .replace(/~(.*?)~/g, '<del>$1</del>') // Strikethrough
                    .replace(/```(.*?)```/gs, '<code class="bg-slate-200 dark:bg-slate-700 px-1 rounded">$1</code>') // Monospace
                    .replace(/\n/g, '<br>'); // Newlines

                $preview.html(html);
            }

            $textarea.on('input', updatePreview);

            // Formatting Buttons Logic
            $('.format-btn').on('click', function () {
                const style = $(this).data('style');
                const startPos = $textarea.prop('selectionStart');
                const endPos = $textarea.prop('selectionEnd');
                const text = $textarea.val();
                const selectedText = text.substring(startPos, endPos);

                let replacement = '';
                if (style === '```') {
                    replacement = '```' + (selectedText || 'text') + '```';
                } else {
                    replacement = style + (selectedText || 'text') + style;
                }

                const newText = text.substring(0, startPos) + replacement + text.substring(endPos);
                $textarea.val(newText).focus();

                // Set cursor position after the styling
                const newCursorPos = startPos + replacement.length;
                $textarea[0].setSelectionRange(newCursorPos, newCursorPos);

                updatePreview();
            });

            // Form submission overlay
            $form.on('submit', function () {
                $overlay.removeClass('hidden').addClass('flex');
            });

            // Placeholder insertion logic
            $('.insert-placeholder').on('click', function () {
                const placeholder = "[Group Name]";
                const startPos = $textarea.prop('selectionStart');
                const endPos = $textarea.prop('selectionEnd');
                const text = $textarea.val();

                const newText = text.substring(0, startPos) + placeholder + text.substring(endPos);
                $textarea.val(newText).focus();

                const newCursorPos = startPos + placeholder.length;
                $textarea[0].setSelectionRange(newCursorPos, newCursorPos);

                updatePreview();
            });
        });
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
        }
    </style>
@endsection