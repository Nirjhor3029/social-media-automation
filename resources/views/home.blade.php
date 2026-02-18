@extends('layouts.admin')
@section('content')
    <div class="py-8 max-w-7xl mx-auto space-y-8">
        <!-- Welcome & Stats -->
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Welcome back, Alex
                </h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400">Here's what's happening with your messaging
                    campaigns today.</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700 dark:hover:bg-slate-700">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Add Number
                </button>
                <button
                    class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                    <span class="material-symbols-outlined text-[20px]">send</span>
                    Send Broadcast
                </button>
            </div>
        </div>
        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Connected Numbers -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-50 text-green-600 dark:bg-green-900/20">
                        <span class="material-symbols-outlined">perm_phone_msg</span>
                    </div>
                    <span
                        class="flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                        <span class="material-symbols-outlined text-[14px]">arrow_upward</span>
                        2 new
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Connected Numbers</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">12</p>
                </div>
            </div>
            <!-- Messages Sent -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-50 text-primary dark:bg-blue-900/20">
                        <span class="material-symbols-outlined">send</span>
                    </div>
                    <span
                        class="flex items-center gap-1 rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-primary dark:bg-blue-900/30 dark:text-blue-300">
                        <span class="material-symbols-outlined text-[14px]">arrow_upward</span>
                        15%
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Sent Today</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">1,402</p>
                </div>
            </div>
            <!-- Failed Messages -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-50 text-red-600 dark:bg-red-900/20">
                        <span class="material-symbols-outlined">error</span>
                    </div>
                    <span
                        class="flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                        <span class="material-symbols-outlined text-[14px]">arrow_downward</span>
                        5%
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Failed Messages</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">23</p>
                </div>
            </div>
            <!-- Pending Queue -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-900/20">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">In Queue</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">56</p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Recent Activity Table -->
            <div
                class="lg:col-span-2 flex flex-col rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-slate-800">
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Recent Activity</h3>
                    <a class="text-sm font-medium text-primary hover:text-primary/80" href="#">View
                        all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-500 dark:bg-slate-800/50 dark:text-slate-400">
                            <tr>
                                <th class="px-6 py-3 font-medium" scope="col">Recipient</th>
                                <th class="px-6 py-3 font-medium" scope="col">Message Snippet</th>
                                <th class="px-6 py-3 font-medium" scope="col">Time</th>
                                <th class="px-6 py-3 font-medium" scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-900 dark:text-white">
                                    +1 (555) 012-3456</td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400 max-w-xs truncate">Your
                                    appointment is confirmed for tomorrow...</td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-500 dark:text-slate-400">2
                                    mins ago</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-500/30">Sent</span>
                                </td>
                            </tr>
                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-900 dark:text-white">
                                    +1 (555) 999-8888</td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400 max-w-xs truncate">
                                    Alert: New login detected from Chrome...</td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-500 dark:text-slate-400">5
                                    mins ago</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20 dark:bg-red-900/30 dark:text-red-400 dark:ring-red-500/30">Failed</span>
                                </td>
                            </tr>
                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-900 dark:text-white">
                                    +44 7700 900077</td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400 max-w-xs truncate">
                                    Thank you for your recent purchase! He...</td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-500 dark:text-slate-400">12
                                    mins ago</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-500/30">Sent</span>
                                </td>
                            </tr>
                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-900 dark:text-white">
                                    +1 (202) 555-0143</td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400 max-w-xs truncate">
                                    Reminder: Invoice #4023 is due in 3 days.</td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-500 dark:text-slate-400">25
                                    mins ago</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20 dark:bg-amber-900/30 dark:text-amber-400 dark:ring-amber-500/30">Pending</span>
                                </td>
                            </tr>
                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-900 dark:text-white">
                                    +61 491 570 156</td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400 max-w-xs truncate">
                                    Welcome to the community! Reply STOP to...</td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-500 dark:text-slate-400">1
                                    hour ago</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-500/30">Sent</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Platform Status -->
            <div class="flex flex-col gap-6">
                <!-- Quick Actions Panel (Mobile/Small Screen emphasis or additional shortcuts) -->
                <div
                    class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <button
                            class="flex flex-col items-center justify-center gap-2 rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 text-sm font-medium text-slate-600 hover:border-primary hover:bg-blue-50 hover:text-primary dark:border-slate-700 dark:bg-slate-800 dark:text-slate-400 dark:hover:border-primary dark:hover:bg-slate-800/80 transition-all">
                            <span class="material-symbols-outlined text-[28px]">group_add</span>
                            Create Group
                        </button>
                        <button
                            class="flex flex-col items-center justify-center gap-2 rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 text-sm font-medium text-slate-600 hover:border-primary hover:bg-blue-50 hover:text-primary dark:border-slate-700 dark:bg-slate-800 dark:text-slate-400 dark:hover:border-primary dark:hover:bg-slate-800/80 transition-all">
                            <span class="material-symbols-outlined text-[28px]">upload_file</span>
                            Import Contacts
                        </button>
                    </div>
                </div>
                <!-- Platforms -->
                <div
                    class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">Platform Status
                    </h3>
                    <div class="space-y-4">
                        <!-- WhatsApp -->
                        <div
                            class="flex items-center justify-between rounded-lg bg-green-50 p-3 ring-1 ring-green-100 dark:bg-green-900/10 dark:ring-green-900/30">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-green-500 text-white shadow-sm">
                                    <!-- Simple chat bubble icon representing whatsapp generic concept -->
                                    <span class="material-symbols-outlined text-[20px]">chat</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900 dark:text-white">WhatsApp
                                    </p>
                                    <p class="text-xs text-green-700 dark:text-green-400">Connected • Active
                                    </p>
                                </div>
                            </div>
                            <div class="flex h-2.5 w-2.5">
                                <span
                                    class="animate-ping absolute inline-flex h-2.5 w-2.5 rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                            </div>
                        </div>
                        <!-- Telegram -->
                        <div
                            class="flex items-center justify-between rounded-lg bg-slate-50 p-3 opacity-60 grayscale dark:bg-slate-800">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-400 text-white shadow-sm">
                                    <span class="material-symbols-outlined text-[20px]">send</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900 dark:text-white">Telegram
                                    </p>
                                    <p class="text-xs text-slate-500">Coming Soon</p>
                                </div>
                            </div>
                        </div>
                        <!-- Instagram -->
                        <div
                            class="flex items-center justify-between rounded-lg bg-slate-50 p-3 opacity-60 grayscale dark:bg-slate-800">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-pink-500 text-white shadow-sm">
                                    <span class="material-symbols-outlined text-[20px]">photo_camera</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900 dark:text-white">Instagram
                                    </p>
                                    <p class="text-xs text-slate-500">Coming Soon</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection}