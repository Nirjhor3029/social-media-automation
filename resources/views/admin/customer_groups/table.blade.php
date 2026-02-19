<table class="w-full text-left border-collapse">
    <thead>
        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">

            <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                <div class="flex items-center gap-1 cursor-pointer hover:text-primary transition-colors">
                    ID <span class="material-icons-outlined text-xs">unfold_more</span>
                </div>
            </th>
            <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                <div class="flex items-center gap-1 cursor-pointer hover:text-primary transition-colors">
                    Group Name <span class="material-icons-outlined text-xs">unfold_more</span>
                </div>
            </th>
            <th
                class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">
                Total Customers
            </th>
            <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                Status
            </th>
            <th
                class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">
                Actions
            </th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
        @forelse($groups as $group)
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">

                <td class="px-6 py-4 text-sm font-medium text-slate-500 dark:text-slate-400">
                    #{{ $group->id }}
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $group->name }}</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">Created
                        {{ $group->created_at->format('M d, Y') }}
                    </div>
                </td>
                <td class="px-6 py-4 text-center">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200">
                        {{ $group->customers_count }}
                    </span>
                </td>
                <td class="px-6 py-4">

                    

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer status-toggle" data-id="{{ $group->id }}"
                            {{ $group->status ? 'checked' : '' }}>
                        <div
                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-success">
                        </div>
                        <span
                            class="ml-3 text-sm font-medium status-label {{ $group->status ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500' }}">
                            {{ $group->status ? 'Active' : 'Inactive' }}
                        </span>
                    </label>
                </td>
                <td class="px-6 py-4 text-right whitespace-nowrap">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.customer-groups.show', $group->id) }}"
                            class="p-1.5 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg transition-colors"
                            title="View Details">
                            <span class="material-icons-outlined text-xl">visibility</span>
                        </a>
                        <a href="{{ route('admin.customer-groups.edit', $group->id) }}"
                            class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                            title="Edit">
                            <span class="material-icons-outlined text-xl">edit</span>
                        </a>
                        <form action="{{ route('admin.customer-groups.destroy', $group->id) }}" method="POST"
                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                title="Delete">
                                <span class="material-icons-outlined text-xl">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-slate-500 dark:text-slate-400">
                    No groups found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
    {{ $groups->links() }}
</div>
