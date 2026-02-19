@extends('layouts.admin')
@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <nav class="flex items-center space-x-2 text-sm text-slate-500 dark:text-slate-400 mb-6">
            <a class="hover:text-primary transition-colors" href="#">Customer Groups</a>
            <span class="material-icons-round text-base">chevron_right</span>
            <span class="font-medium text-slate-900 dark:text-slate-100">Create New Group</span>
        </nav>
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                    <span class="material-icons-round text-primary text-4xl">group_add</span>
                    Create Customer Group
                </h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400">Organize your WhatsApp campaigns by grouping
                    customers efficiently.</p>
            </div>
            <button class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors"
                onclick="document.documentElement.classList.toggle('dark')">
                <span class="material-icons-round text-slate-600 dark:text-slate-400">dark_mode</span>
            </button>
        </div>
        <div
            class="bg-white dark:bg-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden">
            <div class="p-8">
                <form class="space-y-8">
                    <div class="group">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2" for="group-name">
                            Group Name <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                class="block w-full px-4 py-3 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:ring-primary focus:border-primary transition-all duration-200"
                                id="group-name" name="group-name" placeholder="e.g. VIP Summer Sale 2024" required=""
                                type="text" />
                        </div>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 flex items-center">
                            <span class="material-icons-round text-base mr-1">info</span>
                            Give your group a descriptive name for easy identification.
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2"
                            for="description">
                            Description
                        </label>
                        <textarea
                            class="block w-full px-4 py-3 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:ring-primary focus:border-primary transition-all duration-200"
                            id="description" name="description" placeholder="Describe the purpose of this group..." rows="4"></textarea>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                            Optional internal notes about the members or the campaign goals.
                        </p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2"
                                for="status">
                                Status
                            </label>
                            <div class="relative">
                                <select
                                    class="block w-full px-4 py-3 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:ring-primary focus:border-primary transition-all duration-200 appearance-none"
                                    id="status" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="archived">Archived</option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                                    <span class="material-icons-round">expand_more</span>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                                Inactive groups won't appear in campaign selection.
                            </p>
                        </div>
                    </div>
                    <div class="pt-6 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between">
                        <button
                            class="px-6 py-3 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors"
                            type="button">
                            Discard Changes
                        </button>
                        <div class="flex space-x-4">
                            <button
                                class="px-6 py-3 text-sm font-semibold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors"
                                type="button">
                                Save as Draft
                            </button>
                            <button
                                class="px-8 py-3 text-sm font-semibold bg-primary text-white rounded-lg hover:bg-indigo-600 shadow-lg shadow-primary/25 transition-all duration-200 flex items-center"
                                type="submit">
                                <span class="material-icons-round mr-2 text-lg">save</span>
                                Save Group
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="p-6 bg-white/50 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700 rounded-xl flex items-center space-x-4">
                <div class="bg-indigo-100 dark:bg-indigo-900/40 p-3 rounded-full">
                    <span class="material-icons-round text-indigo-600 dark:text-indigo-400">person_add</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Seamless Import</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Add contacts via CSV or manually after saving.
                    </p>
                </div>
            </div>
            <div
                class="p-6 bg-white/50 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700 rounded-xl flex items-center space-x-4">
                <div class="bg-emerald-100 dark:bg-emerald-900/40 p-3 rounded-full">
                    <span class="material-icons-round text-emerald-600 dark:text-emerald-400">verified</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Verified Lists</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Numbers are validated before sending
                        broadcasts.</p>
                </div>
            </div>
            <div
                class="p-6 bg-white/50 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700 rounded-xl flex items-center space-x-4">
                <div class="bg-amber-100 dark:bg-amber-900/40 p-3 rounded-full">
                    <span class="material-icons-round text-amber-600 dark:text-amber-400">bolt</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Fast Execution</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Launch campaigns instantly to any group size.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

