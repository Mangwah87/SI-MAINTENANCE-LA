<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/logo.jpg') }}">
    <title>Formulir Maintenance Lintasarta</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        .fade-out { transition: opacity 0.5s ease-out; }

        /* Kustom CSS untuk Glassmorphism Effect */
        .glass-card {
            background-color: rgba(255, 255, 255, 0.15); 
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }
        
        /* Input fields hitam transparan */
        .glass-input {
            background-color: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white; 
        }
        .glass-input::placeholder { color: rgba(255, 255, 255, 0.6); }
        .glass-input:focus {
            border-color: rgba(255, 255, 255, 0.6);
            ring-color: rgba(255, 255, 255, 0.5);
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Checkbox */
        .glass-checkbox {
            background-color: rgba(0, 0, 0, 0.4);
            border-color: rgba(255, 255, 255, 0.5);
        }
        .glass-checkbox:checked { background-color: #60A5FA; border-color: #60A5FA; }

        /* Tombol */
        .glass-button { background-color: #60A5FA; color: white; }
        .glass-button:hover { background-color: #3B82F6; }

        /* Teks */
        .glass-text { color: white; }
        .glass-link { color: #1f84ff; }
        .glass-link:hover { color: #1253bc; }
        .glass-icon { color: rgba(255, 255, 255, 0.7); }
        
        .glass-card .lucide { color: rgba(255, 255, 255, 0.7); }
        .glass-card button[data-toggle="password"] .lucide { color: rgba(255, 255, 255, 0.7); }
    </style>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center p-4">

    <div class="fixed inset-0 z-0 bg-cover bg-center" style="background-image: url('{{ asset('assets/images/login.jpg') }}');"></div>

    <div class="relative z-10 glass-card rounded-xl shadow-2xl max-w-md w-full p-6 text-white">
        
        @if(session('success'))
            <div id="flash-success" class="fade-out bg-green-500 bg-opacity-30 border border-green-400 text-white px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div id="flash-error" class="fade-out bg-red-500 bg-opacity-30 border border-red-400 text-white px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <div>
            <div class="text-center mb-6">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="mx-auto h-12 w-auto filter brightness-150">
            </div>
            <div class="text-center mb-6">
                <span class="text-2xl font-bold glass-text">Formulir Maintenance Lintasarta</span>
                <p class="glass-text mt-2">Silakan login untuk melanjutkan</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium glass-text mb-1">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3 top-1/2 transform -translate-y-1/2 glass-icon w-5 h-5"></i>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}"
                               class="w-full pl-12 pr-4 py-2 rounded-lg glass-input focus:outline-none focus:ring-2"
                               placeholder="your@email.com"/>
                    </div>
                    @error('email') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium glass-text mb-1">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3 top-1/2 transform -translate-y-1/2 glass-icon w-5 h-5"></i>
                        <input type="password" id="password" name="password" required
                               class="w-full pl-12 pr-10 py-2 rounded-lg glass-input focus:outline-none focus:ring-2"
                               placeholder="••••••••"/>
                        <button type="button" data-toggle="password" data-target="password"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i data-lucide="eye" class="w-5 h-5 glass-icon"></i>
                        </button>
                    </div>
                    @error('password') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div class="flex items-center justify-between text-sm">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded glass-checkbox shadow-sm focus:ring-2" name="remember">
                        <span class="ml-2 glass-text">{{ __('Remember me') }}</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="font-medium glass-link hover:underline" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full glass-button font-semibold py-2 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <i data-lucide="log-in" class="w-5 h-5 glass-icon"></i> Login
                </button>
            </form>
            
            <div class="text-center mt-4 text-sm">
                <p class="glass-text">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium glass-link hover:underline">
                        Register di sini
                    </a>
                </p>
            </div>
        </div>
        
    </div>

    <script src="{{ asset('js/toggle-password.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // [DIHAPUS] Logika Modal telah dihapus

            setTimeout(() => {
                const success = document.getElementById('flash-success');
                const error = document.getElementById('flash-error');

                if (success) {
                    success.classList.add('opacity-0');
                    setTimeout(() => success.remove(), 500);
                }
                if (error) {
                    error.classList.add('opacity-0');
                    setTimeout(() => error.remove(), 500);
                }
            }, 3000);
        });
    </script>
</body>
</html>