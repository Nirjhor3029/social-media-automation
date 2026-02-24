@extends('layouts.app')

@section('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .login-page .c-app {
            background: transparent !important;
        }

        .container {
            max-width: 100% !important;
        }

        .input-focus-effect:focus {
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            border-color: #6366f1;
        }

        [cloke] {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="w-full max-w-md mx-auto">
        <div class="glass-card rounded-3xl p-8 md:p-10 transition-all duration-300 hover:shadow-2xl">
            <!-- Logo/Title Section -->
            <div class="text-center mb-10">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-tr from-indigo-500 to-purple-600 rounded-2xl shadow-lg mb-4">
                    <span class="material-icons-round text-white text-3xl">rocket_launch</span>
                </div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                    {{ trans('panel.site_title') }}
                </h1>
                <p class="text-slate-500 mt-2 font-medium">Welcome back! Please login to your account.</p>
            </div>

            @if(session('message'))
                <div
                    class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 text-sm flex items-center gap-3">
                    <span class="material-icons-round text-blue-500">info</span>
                    {{ session('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email/Username Input -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-slate-700 ml-1">Email or Username</label>
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <span class="material-icons-round text-[20px]">alternate_email</span>
                        </div>
                        <input id="email" name="email" type="text"
                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-800 placeholder-slate-400 input-focus-effect transition-all outline-none {{ $errors->has('email') ? 'border-red-400 bg-red-50' : '' }}"
                            required autocomplete="email" autofocus placeholder="Enter your email or username"
                            value="{{ old('email', null) }}">
                    </div>
                    @if($errors->has('email'))
                        <p class="text-red-500 text-xs mt-1 ml-1 flex items-center gap-1">
                            <span class="material-icons-round text-[14px]">error</span>
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between ml-1">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors">
                                Forgot Password?
                            </a>
                        @endif
                    </div>
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <span class="material-icons-round text-[20px]">lock</span>
                        </div>
                        <input id="password" name="password" type="password"
                            class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-800 placeholder-slate-400 input-focus-effect transition-all outline-none {{ $errors->has('password') ? 'border-red-400 bg-red-50' : '' }}"
                            required placeholder="••••••••">

                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                            <span class="material-icons-round" id="passwordIcon">visibility</span>
                        </button>
                    </div>
                    @if($errors->has('password'))
                        <p class="text-red-500 text-xs mt-1 ml-1 flex items-center gap-1">
                            <span class="material-icons-round text-[14px]">error</span>
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="flex items-center ml-1">
                    <input class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer"
                        name="remember" type="checkbox" id="remember">
                    <label class="ml-2 block text-sm font-medium text-slate-600 cursor-pointer select-none" for="remember">
                        {{ trans('global.remember_me') }}
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-200 transition-all duration-300 transform hover:-translate-y-1 active:scale-[0.98]">
                    {{ trans('global.login') }}
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-10 text-center">
                <p class="text-sm text-slate-500">
                    Don't have an account?
                    <a href="#" class="font-bold text-indigo-600 hover:text-indigo-700 transition-colors">Contact
                        Administrator</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const passwordIcon = document.querySelector('#passwordIcon');

            togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // toggle the eye slash icon
                passwordIcon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
            });
        });
    </script>
@endsection