<header class="c-header c-header-fixed px-3 d-flex justify-content-between align-items-center">
            <div class="c-header c-header-fixed px-3">
                <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button"
                    data-target="#sidebar" data-class="c-sidebar-show">
                    <i class="fas fa-fw fa-bars"></i>
                </button>

                <a class="c-header-brand d-lg-none" href="#">{{ trans('panel.site_title') }}</a>

                <button class="c-header-toggler mfs-3 d-md-down-none" type="button" responsive="true">
                    <i class="fas fa-fw fa-bars"></i>
                </button>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative hidden sm:block">
                    <span
                        class="material-symbols-outlined absolute left-2.5 top-2.5 text-[20px] text-slate-400">search</span>
                    <input
                        class="h-10 w-64 rounded-lg border-0 bg-slate-100 pl-10 pr-4 text-sm text-slate-900 placeholder:text-slate-500 focus:ring-2 focus:ring-primary dark:bg-slate-800 dark:text-white"
                        placeholder="Search..." type="text" />
                </div>
                <button id="theme-toggle" type="button"
                    class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full p-2.5 transition-colors">
                    <span id="theme-toggle-dark-icon"
                        class="hidden material-symbols-outlined text-[24px]">dark_mode</span>
                    <span id="theme-toggle-light-icon"
                        class="hidden material-symbols-outlined text-[24px]">light_mode</span>
                </button>
                <button
                    class="relative rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800">
                    <span class="material-symbols-outlined text-[24px]">notifications</span>
                    <span
                        class="absolute right-2 top-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-slate-900"></span>
                </button>
            </div>

            {{-- <ul class="c-header-nav ml-auto">
                @if (count(config('panel.available_languages', [])) > 1)
                    <li class="c-header-nav-item dropdown d-md-down-none">
                        <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            {{ strtoupper(app()->getLocale()) }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @foreach (config('panel.available_languages') as $langLocale => $langName)
                                <a class="dropdown-item"
                                    href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }}
                                    ({{ $langName }})
                                </a>
                            @endforeach
                        </div>
                    </li>
                @endif
            </ul> --}}
        </header>