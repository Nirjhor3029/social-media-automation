@extends('layouts.admin')

@section('styles')
    <style>
        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 0.5;
            }

            100% {
                transform: scale(1.3);
                opacity: 0;
            }
        }

        .pulse-ring::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            border-radius: 9999px;
            background-color: #4a8fd9;
            opacity: 0.6;
            z-index: -1;
            animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        .qr-gradient-border {
            background: linear-gradient(135deg, rgba(74, 143, 217, 0.2) 0%, rgba(37, 211, 102, 0.2) 100%);
        }

        .dark .qr-gradient-border {
            background: linear-gradient(135deg, rgba(74, 143, 217, 0.1) 0%, rgba(37, 211, 102, 0.1) 100%);
        }
    </style>
@endsection

@section('content')
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col items-center justify-start py-8 px-4 md:py-12 md:px-6 w-full max-w-[1200px] mx-auto">
        <!-- Stepper -->
        <div class="w-full max-w-3xl mb-16">
            <div class="flex items-center justify-between relative px-2">
                <!-- Line background -->
                <div class="absolute left-0 top-1/2 w-full h-[2px] bg-slate-200 dark:bg-slate-700 -z-10 -translate-y-1/2 rounded-full"></div>
                <div class="absolute left-0 top-1/2 w-1/3 h-[2px] bg-primary -z-0 -translate-y-1/2 rounded-full shadow-[0_0_8px_rgba(74,143,217,0.4)]"></div>
                
                <!-- Step 1: Completed -->
                <div class="flex flex-col items-center gap-3 relative">
                    <div class="size-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-primary/20 ring-4 ring-background-light dark:ring-background-dark transition-all duration-300">
                        <span class="material-symbols-outlined !text-xl">check</span>
                    </div>
                    <span class="text-[11px] uppercase tracking-wider font-bold text-primary absolute -bottom-8 whitespace-nowrap hidden sm:block">Select Platform</span>
                </div>
                
                <!-- Step 2: Active -->
                <div class="flex flex-col items-center gap-3 relative">
                    <div class="size-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-primary/30 ring-4 ring-background-light dark:ring-background-dark transition-all duration-300 {{ !in_array($subcriber->status, ['ready', 'authenticated', 'connected', 'qr_ready']) ? 'animate-pulse' : '' }}">
                        @if(in_array($subcriber->status, ['ready', 'authenticated', 'connected', 'qr_ready']))
                            <span class="material-symbols-outlined !text-xl">check</span>
                        @else
                            2
                        @endif
                    </div>
                    <span class="text-[11px] uppercase tracking-wider font-bold text-slate-800 dark:text-slate-100 absolute -bottom-8 whitespace-nowrap hidden sm:block">Scan QR</span>
                </div>
                
                <!-- Step 3: Inactive -->
                <div class="flex flex-col items-center gap-3 relative">
                    <div class="size-10 rounded-full {{ in_array($subcriber->status, ['ready', 'authenticated', 'connected']) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400' }} flex items-center justify-center font-bold text-sm ring-4 ring-background-light dark:ring-background-dark transition-all duration-300">
                        @if(in_array($subcriber->status, ['ready', 'authenticated', 'connected']))
                            <span class="material-symbols-outlined !text-xl">check</span>
                        @else
                            3
                        @endif
                    </div>
                    <span class="text-[11px] uppercase tracking-wider font-medium {{ in_array($subcriber->status, ['ready', 'authenticated', 'connected']) ? 'text-primary font-bold' : 'text-slate-400 dark:text-slate-500' }} absolute -bottom-8 whitespace-nowrap hidden sm:block">Configuration</span>
                </div>
                
                <!-- Step 4: Inactive -->
                <div class="flex flex-col items-center gap-3 relative">
                    <div class="size-10 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 flex items-center justify-center font-bold text-sm ring-4 ring-background-light dark:ring-background-dark transition-all duration-300">
                        4
                    </div>
                    <span class="text-[11px] uppercase tracking-wider font-medium text-slate-400 dark:text-slate-500 absolute -bottom-8 whitespace-nowrap hidden sm:block">Done</span>
                </div>
            </div>
            <!-- Mobile Text Indicator -->
            <div class="flex sm:hidden justify-center mt-10">
                <span class="px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-widest">
                    @if(in_array($subcriber->status, ['ready', 'authenticated', 'connected']))
                        Connected Successfully
                    @else
                        Step 2: Scan QR Code
                    @endif
                </span>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white dark:bg-slate-900/50 backdrop-blur-xl rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800/50 overflow-hidden w-full max-w-5xl flex flex-col md:flex-row min-h-[500px]">
            <!-- Left Side: QR Code Area -->
            <div class="w-full md:w-5/12 p-8 md:p-12 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-900/20">
                @if(in_array($subcriber->status, ['ready', 'authenticated', 'connected']))
                    <div class="flex flex-col items-center animate-in fade-in zoom-in duration-700">
                        <div class="size-42 rounded-full bg-emerald-500/10 flex items-center justify-center mb-6 ring-8 ring-emerald-500/5">
                            <span class="material-symbols-outlined !text-7xl text-emerald-500">check_circle</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-2">Authenticated!</h2>
                        <p class="text-slate-500 dark:text-slate-400 text-center text-sm font-medium">Your WhatsApp account is successfully linked and ready to use.</p>
                        
                        <div class="mt-8 p-4 rounded-xl bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 w-full text-center">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Session ID</p>
                            <code class="text-xs text-primary font-bold">{{ $subcriber->session }}</code>
                        </div>

                        <a href="{{ route('admin.home') }}" class="mt-8 px-8 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/30 hover:scale-105 active:scale-95 transition-all">
                            Go to Dashboard
                        </a>
                    </div>
                @else
                    <div class="relative group">
                        <!-- QR Frame with Gradient Glow -->
                        <div class="absolute -inset-4 qr-gradient-border opacity-50 blur-xl rounded-full group-hover:opacity-100 transition duration-700"></div>
                        
                        <div class="relative bg-white p-6 rounded-2xl shadow-2xl ring-1 ring-slate-200 dark:ring-slate-700 transition-transform duration-500 group-hover:scale-[1.02]">
                            <div class="relative flex items-center justify-center min-w-[200px] min-h-[200px]">
                                @if($subcriber->qr)
                                    <div id="qrcode" class="w-52 h-52 md:w-60 md:h-60 flex items-center justify-center"></div>
                                @else
                                    <div class="w-52 h-52 md:w-60 md:h-60 flex flex-col items-center justify-center text-slate-300">
                                        <span class="material-symbols-outlined !text-6xl animate-pulse">qr_code_2</span>
                                        <p class="text-xs font-bold mt-4 animate-pulse uppercase tracking-widest text-slate-400">Generating...</p>
                                    </div>
                                @endif
                                
                                <!-- Logo Overlay -->
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <div class="bg-white p-2 rounded-xl shadow-lg border border-slate-50">
                                        <svg class="w-8 h-8 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.432h.006c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pulsing Status -->
                        <div class="absolute -top-1 -right-1 flex items-center justify-center">
                            <div class="relative w-5 h-5">
                                <span class="pulse-ring absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-5 w-5 bg-primary border-4 border-white dark:border-slate-900 shadow-sm"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex flex-col items-center gap-6 w-full text-center">
                        <div class="flex items-center gap-2.5 {{ $subcriber->qr ? 'text-primary bg-primary/10 border-primary/20' : 'text-slate-400 bg-slate-100 dark:bg-slate-800 border-slate-200 dark:border-slate-700' }} px-5 py-2.5 rounded-full border backdrop-blur-sm">
                            <span class="material-symbols-outlined !text-xl {{ !in_array($subcriber->status, ['authenticated', 'connected', 'ready']) ? 'animate-spin' : '' }}">sync</span>
                            <span class="text-sm font-bold tracking-wide">
                                @if($subcriber->status == 'qr_ready')
                                    QR Code Ready
                                @elseif($subcriber->status == 'waiting_qr')
                                    Generating QR...
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $subcriber->status ?? 'Initializing')) }}
                                @endif
                            </span>
                        </div>
                        
                        <div class="text-center rounded-2xl bg-slate-100/50 dark:bg-slate-800/40 p-4 border border-slate-100 dark:border-slate-800 w-full max-w-[200px]">
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mb-1">Status</p>
                            <p class="text-xl font-black text-slate-800 dark:text-white truncate" title="{{ $subcriber->status }}">
                                {{ $subcriber->status == 'qr_ready' ? 'READY' : (strtoupper($subcriber->status) ?: 'WAITING') }}
                            </p>
                        </div>

                        <button onclick="window.location.href='{{ route('admin.whstapp-subscribers.connect', ['subscriber_id' => $subcriber->id, 'force_refresh' => 1]) }}'" class="flex items-center gap-2 text-sm font-semibold text-slate-400 dark:text-slate-500 hover:text-primary dark:hover:text-primary transition-all duration-300 group">
                            <span class="material-symbols-outlined !text-lg group-hover:rotate-180 transition-transform duration-500">refresh</span>
                            <span>Reload QR Code</span>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Right Side: Instructions Area -->
            <div class="w-full md:w-7/12 p-8 md:p-14 flex flex-col justify-center bg-white dark:bg-slate-900/40">
                <div class="mb-12">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em] mb-4 border border-emerald-500/20">
                        <span class="material-symbols-outlined !text-sm">verified_user</span>
                        Secure Connection
                    </div>
                    <h1
                        class="text-3xl md:text-4xl font-black text-slate-800 dark:text-white mb-4 tracking-tight leading-tight">
                        Link your <span class="text-[#25D366]">WhatsApp</span></h1>
                    <p class="text-slate-500 dark:text-slate-400 text-lg leading-relaxed max-w-md font-medium">
                        Sync your conversations and automate your workflow in seconds.
                    </p>
                </div>

                <div class="space-y-8 relative">
                    <!-- Vertical Line Connector for Steps -->
                    <div class="absolute left-5 top-10 bottom-10 w-[2px] bg-slate-100 dark:bg-slate-800/50"></div>

                    <!-- Step 1 -->
                    <div class="flex gap-6 items-start relative z-10">
                        <div class="flex-shrink-0 size-10 rounded-xl {{ !in_array($subcriber->status, ['ready', 'authenticated', 'connected', 'qr_ready']) ? 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-white' : 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' }} flex items-center justify-center font-black text-sm ring-1 ring-slate-200 dark:ring-slate-700">
                            @if(in_array($subcriber->status, ['authenticated', 'ready', 'connected', 'qr_ready']))
                                <span class="material-symbols-outlined !text-xl">check</span>
                            @else
                                1
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-white text-lg">Open WhatsApp</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium italic">Open WhatsApp on your primary phone.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex gap-6 items-start relative z-10">
                        <div class="flex-shrink-0 size-10 rounded-xl {{ !in_array($subcriber->status, ['authenticated', 'ready', 'connected']) ? 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-white' : 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' }} flex items-center justify-center font-black text-sm ring-1 ring-slate-200 dark:ring-slate-700">
                            @if(in_array($subcriber->status, ['authenticated', 'ready', 'connected']))
                                <span class="material-symbols-outlined !text-xl">check</span>
                            @else
                                2
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-white text-lg">Go to Linked Devices</h3>
                            <div class="text-sm text-slate-500 dark:text-slate-400 mt-2 space-y-2 font-medium">
                                <p>Tap <span class="text-slate-900 dark:text-slate-200 font-black">Menu</span> <span class="inline-flex align-middle bg-slate-100 dark:bg-slate-800 px-1 rounded"><span class="material-symbols-outlined !text-base text-slate-400">more_vert</span></span> or <span class="text-slate-900 dark:text-slate-200 font-black">Settings</span> <span class="inline-flex align-middle bg-slate-100 dark:bg-slate-800 px-1 rounded"><span class="material-symbols-outlined !text-base text-slate-400">settings</span></span></p>
                                <p>Select <span class="text-[#25D366] font-black">Linked Devices</span> and then <span class="text-slate-900 dark:text-slate-200 font-black underline decoration-primary/30 underline-offset-4">Link a Device</span>.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex gap-6 items-start relative z-10">
                        <div class="flex-shrink-0 size-10 rounded-xl {{ in_array($subcriber->status, ['authenticated', 'ready', 'connected']) ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'bg-slate-100 dark:bg-slate-800' }} flex items-center justify-center text-slate-800 dark:text-white font-black text-sm ring-1 ring-slate-200 dark:ring-slate-700">
                             @if(in_array($subcriber->status, ['authenticated', 'ready', 'connected']))
                                <span class="material-symbols-outlined !text-xl">check</span>
                            @else
                                3
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-white text-lg">Scan this Code</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Point your phone camera to this screen to authenticate.</p>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-14 pt-8 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row gap-6 justify-between items-center">
                    <div class="flex items-center gap-3 text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                        <span class="material-symbols-outlined !text-lg text-emerald-500">lock</span>
                        <span>End-to-end encrypted</span>
                    </div>
                    <div class="flex gap-3 w-full sm:w-auto">
                        <button
                            class="flex-1 sm:flex-none px-8 py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-300 active:scale-95">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Footer -->
        <div class="mt-12 text-center group cursor-pointer">
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">
                Having trouble linking?
                <a class="text-primary font-bold hover:text-primary/80 transition-colors ml-1 inline-flex items-center gap-1 border-b border-primary/20 hover:border-primary transition-all"
                    href="#">
                    Read the connection guide
                    <span class="material-symbols-outlined !text-base">arrow_forward</span>
                </a>
            </p>
        </div>
    </main>
@endsection

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($subcriber->qr && !in_array($subcriber->status, ['authenticated', 'ready', 'connected']))
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: `{!! $subcriber->qr !!}`,
                width: 256,
                height: 256,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
            @endif

            const subscriberId = "{{ $subcriber->id }}";
            const statusUrl = "{{ route('admin.whstapp-subscribers.status') }}";
            let pollInterval;

            function checkStatus() {
                fetch(`${statusUrl}?subscriber_id=${subscriberId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.ok) {
                            if (['authenticated', 'ready', 'connected'].includes(data.status)) {
                                clearInterval(pollInterval);
                                window.location.reload();
                            }
                        }
                    })
                    .catch(error => console.error('Status polling error:', error));
            }

            @if(!in_array($subcriber->status, ['authenticated', 'ready', 'connected']))
            pollInterval = setInterval(checkStatus, 3000);
            @endif
        });
    </script>
@endsection