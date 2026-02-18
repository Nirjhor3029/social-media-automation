<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>WhatsApp QR Connection Interface</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#4a8fd9",
                        "background-light": "#f6f7f8",
                        "background-dark": "#121920",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
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
    </style>
</head>

<body
    class="font-display bg-background-light dark:bg-background-dark text-[#121417] dark:text-white min-h-screen flex flex-col overflow-x-hidden">
    <!-- Top Navigation -->
    <header
        class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#e5e7eb] dark:border-b-gray-700 bg-white dark:bg-[#1a222c] px-6 py-4 md:px-10">
        <div class="flex items-center gap-4 text-[#121417] dark:text-white">
            <div class="size-8 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined !text-[32px]">hub</span>
            </div>
            <h2 class="text-lg font-bold leading-tight tracking-[-0.015em]">SocialConnect</h2>
        </div>
        <!-- Desktop Menu -->
        <div class="hidden md:flex flex-1 justify-end gap-8 items-center">
            <nav class="flex items-center gap-6">
                <a class="text-[#64748b] dark:text-gray-400 hover:text-primary dark:hover:text-primary text-sm font-medium transition-colors"
                    href="#">Dashboard</a>
                <a class="text-primary text-sm font-medium" href="#">Accounts</a>
                <a class="text-[#64748b] dark:text-gray-400 hover:text-primary dark:hover:text-primary text-sm font-medium transition-colors"
                    href="#">Broadcasts</a>
                <a class="text-[#64748b] dark:text-gray-400 hover:text-primary dark:hover:text-primary text-sm font-medium transition-colors"
                    href="#">Settings</a>
            </nav>
            <div class="flex items-center gap-4">
                <button
                    class="size-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 border-2 border-white dark:border-gray-700 shadow-sm"
                    data-alt="User profile picture placeholder"
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAI1T7J29-xfDnLCz1rABoIF3oC54-GZo7wERD7--l0EE4JDmGGas5KyxUwTr9mROg_PhGPKZWtmm2CtVtACc4hsOEQtIJjmUMaCpV2M3gHkX9a6eQUySoxe6Y0WKkJOrggJGNmMiPATXRHqjsXYJN453xpLWsv6S7cBBdqnwtV83xHVebygkudC_BD4kq3zUMeRY95c-a3RN3DnbfspiU82Crk57-3u0uko0Z2dTSNXQXPHinOsmbNrUHlszmzegxvNP1Fx4mYAGKU");'>
                </div>
            </div>
        </div>
        <!-- Mobile Menu Icon -->
        <div class="md:hidden flex items-center">
            <button class="text-gray-700 dark:text-white">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </header>
    <!-- Main Content Area -->
    <main
        class="flex-1 flex flex-col items-center justify-start py-8 px-4 md:py-12 md:px-6 w-full max-w-[1200px] mx-auto">
        <!-- Stepper -->
        <div class="w-full max-w-3xl mb-12">
            <div class="flex items-center justify-between relative">
                <!-- Line background -->
                <div
                    class="absolute left-0 top-1/2 w-full h-1 bg-gray-200 dark:bg-gray-700 -z-10 -translate-y-1/2 rounded-full">
                </div>
                <div class="absolute left-0 top-1/2 w-1/3 h-1 bg-primary -z-0 -translate-y-1/2 rounded-full"></div>
                <!-- Step 1: Completed -->
                <div class="flex flex-col items-center gap-2">
                    <div
                        class="size-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white dark:ring-[#121920]">
                        <span class="material-symbols-outlined !text-lg">check</span>
                    </div>
                    <span class="text-xs font-medium text-primary hidden sm:block absolute -bottom-6">Select
                        Platform</span>
                </div>
                <!-- Step 2: Active -->
                <div class="flex flex-col items-center gap-2">
                    <div
                        class="size-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white dark:ring-[#121920]">
                        2
                    </div>
                    <span
                        class="text-xs font-bold text-[#121417] dark:text-white hidden sm:block absolute -bottom-6">Scan
                        QR</span>
                </div>
                <!-- Step 3: Inactive -->
                <div class="flex flex-col items-center gap-2">
                    <div
                        class="size-8 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 flex items-center justify-center font-bold text-sm ring-4 ring-white dark:ring-[#121920]">
                        3
                    </div>
                    <span
                        class="text-xs font-medium text-gray-400 hidden sm:block absolute -bottom-6">Configuration</span>
                </div>
                <!-- Step 4: Inactive -->
                <div class="flex flex-col items-center gap-2">
                    <div
                        class="size-8 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 flex items-center justify-center font-bold text-sm ring-4 ring-white dark:ring-[#121920]">
                        4
                    </div>
                    <span class="text-xs font-medium text-gray-400 hidden sm:block absolute -bottom-6">Done</span>
                </div>
            </div>
            <!-- Mobile Text Indicator -->
            <div class="flex sm:hidden justify-center mt-6">
                <span class="text-sm font-semibold text-gray-900 dark:text-white">Step 2: Scan QR Code</span>
            </div>
        </div>
        <!-- Main Card -->
        <div
            class="bg-white dark:bg-[#1a222c] rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden w-full max-w-5xl flex flex-col md:flex-row">
            <!-- Left Side: QR Code -->
            <div
                class="w-full md:w-5/12 p-8 md:p-12 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-[#1a222c]">
                <div class="relative group">
                    <!-- QR Frame -->
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <img alt="QR Code for WhatsApp connection"
                            class="w-56 h-56 md:w-64 md:h-64 object-contain opacity-90 group-hover:opacity-100 transition-opacity"
                            data-alt="A QR code pattern"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAxw1f1lKMXEWut_G-4S-VziG57T5l2-v0ABNKrDMXJjMLViUk5wz29AN-jYskRN4-PyUIswJfRewrS7RBN8eIwhvrdSYgpkvv6qUPTuUna-WkSRvBzYM0PjZ45GuCqK7rKev6_VMZZRDIZN9jeNkWxYV8t7kRKyt96bkB40cm0KSoeaxZcVfQr4oGvLyoUOl1_Z2yySuRuDHslM77bsa85tiLMQaXkcmh1I3dNMjp5KqD6hfRi4EXmJzlWeDgk9u56PQWmj8AlDy58" />
                        <!-- Logo Overlay in QR center (simulated) -->
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="bg-white p-1 rounded-full shadow-sm">
                                <span class="material-symbols-outlined text-[#25D366] !text-4xl">chat</span>
                            </div>
                        </div>
                    </div>
                    <!-- Pulsing Status -->
                    <div class="absolute -top-3 -right-3 flex items-center justify-center">
                        <div class="relative w-4 h-4">
                            <span
                                class="pulse-ring absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-primary"></span>
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex flex-col items-center gap-3 w-full">
                    <div class="flex items-center gap-2 text-primary bg-primary/10 px-4 py-2 rounded-full">
                        <span class="material-symbols-outlined !text-xl animate-spin">sync</span>
                        <span class="text-sm font-semibold">Waiting for scan...</span>
                    </div>
                    <div class="text-center mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Code expires in</p>
                        <p class="text-2xl font-bold text-[#121417] dark:text-white tabular-nums tracking-tight">2:45
                        </p>
                    </div>
                    <button
                        class="mt-4 text-sm font-medium text-gray-400 hover:text-primary transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined !text-base">refresh</span>
                        Reload QR Code
                    </button>
                </div>
            </div>
            <!-- Right Side: Instructions -->
            <div class="w-full md:w-7/12 p-8 md:p-12 flex flex-col justify-center">
                <div class="mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-[#121417] dark:text-white mb-3">Connect WhatsApp</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-base leading-relaxed">
                        To sync your conversations and contacts, link your WhatsApp account using the QR code.
                    </p>
                </div>
                <div class="space-y-6">
                    <!-- Step 1 -->
                    <div class="flex gap-4 items-start">
                        <div
                            class="flex-shrink-0 size-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-[#121417] dark:text-white font-bold text-sm">
                            1</div>
                        <div>
                            <h3 class="font-semibold text-[#121417] dark:text-white text-lg">Open WhatsApp</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Open WhatsApp on your primary
                                phone.</p>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex gap-4 items-start">
                        <div
                            class="flex-shrink-0 size-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-[#121417] dark:text-white font-bold text-sm">
                            2</div>
                        <div>
                            <h3 class="font-semibold text-[#121417] dark:text-white text-lg">Go to Linked Devices</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Tap <span class="font-medium text-[#121417] dark:text-gray-300">Menu</span>
                                <span class="inline-flex align-middle"><span
                                        class="material-symbols-outlined !text-base mx-1 text-gray-400">more_vert</span></span>
                                on Android or <span
                                    class="font-medium text-[#121417] dark:text-gray-300">Settings</span>
                                <span class="inline-flex align-middle"><span
                                        class="material-symbols-outlined !text-base mx-1 text-gray-400">settings</span></span>
                                on iPhone.
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Select <span
                                    class="text-[#25D366] font-medium">Linked Devices</span> and tap on <span
                                    class="font-medium text-[#121417] dark:text-gray-300">Link a Device</span>.</p>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex gap-4 items-start">
                        <div
                            class="flex-shrink-0 size-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-[#121417] dark:text-white font-bold text-sm">
                            3</div>
                        <div>
                            <h3 class="font-semibold text-[#121417] dark:text-white text-lg">Point your phone to this
                                screen</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Capture the code to log in.</p>
                        </div>
                    </div>
                </div>
                <div
                    class="mt-10 pt-6 border-t border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <span class="material-symbols-outlined !text-base">lock</span>
                        <span>End-to-end encrypted connection</span>
                    </div>
                    <div class="flex gap-4 w-full sm:w-auto">
                        <button
                            class="flex-1 sm:flex-none px-6 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Help Footer -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Having trouble linking?
                <a class="text-primary font-medium hover:underline" href="#">Read the connection guide</a>
            </p>
        </div>
    </main>
</body>

</html>
