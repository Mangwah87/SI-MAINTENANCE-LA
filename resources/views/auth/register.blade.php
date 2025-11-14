<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/logo.jpg') }}">
    <title>Register - Formulir Maintenance Lintasarta</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .glass-card {
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }

        .glass-input {
            background-color: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .glass-input:focus {
            border-color: rgba(255, 255, 255, 0.6);
            ring-color: rgba(255, 255, 255, 0.5);
            background-color: rgba(0, 0, 0, 0.5);
        }

        .glass-button {
            background-color: #60A5FA;
            color: white;
        }

        .glass-button:hover {
            background-color: #3B82F6;
        }

        .glass-button-dark {
            background-color: rgba(30, 30, 226, 0.6);
            color: white;
        }

        .glass-button-dark:hover {
            background-color: rgba(15, 15, 158, 0.6);
        }

        .glass-text {
            color: white;
        }

        .glass-link {
            color: #1b81fe;
        }

        .glass-link:hover {
            color: #0b4197;
        }

        .glass-icon {
            color: rgba(255, 255, 255, 0.7);
        }

        .glass-card .lucide {
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>

<body class="bg-gray-900 min-h-screen flex items-start justify-center p-4 py-8">

    <div class="fixed inset-0 z-0 bg-cover bg-center"
        style="background-image: url('{{ asset('assets/images/login.jpg') }}');"></div>

    <div class="relative z-10 glass-card rounded-xl shadow-2xl max-w-md w-full p-6 text-white">

        <div class="text-center mb-4">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo"
                class="mx-auto h-12 w-auto filter brightness-150">
        </div>
        <div class="text-center mb-4">
            <span class="text-2xl font-bold glass-text">Buat Akun Baru</span>
            <p class="glass-text mt-2">Silakan isi data untuk mendaftar</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium glass-text mb-1">Nama Lengkap</label>
                <div class="relative">
                    <i data-lucide="user"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 glass-icon w-5 h-5"></i>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}" autofocus
                        class="w-full pl-12 pr-4 py-2 rounded-lg glass-input focus:outline-none focus:ring-2"
                        placeholder="Nama Anda" />
                </div>
                @error('name')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium glass-text mb-1">Email Address</label>
                <div class="relative">
                    <i data-lucide="mail"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 glass-icon w-5 h-5"></i>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}"
                        class="w-full pl-12 pr-4 py-2 rounded-lg glass-input focus:outline-none focus:ring-2"
                        placeholder="your@email.com" />
                </div>
                @error('email')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium glass-text mb-1">Password</label>
                <div class="relative">
                    <i data-lucide="lock"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 glass-icon w-5 h-5"></i>
                    <input type="password" id="password" name="password" required
                        class="w-full pl-12 pr-10 py-2 rounded-lg glass-input focus:outline-none focus:ring-2"
                        placeholder="••••••••" />
                    <button type="button" id="togglePassword"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                        <i data-lucide="eye" class="w-5 h-5 glass-icon" id="eyeIconPassword"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium glass-text mb-1">Konfirmasi
                    Password</label>
                <div class="relative">
                    <i data-lucide="lock"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 glass-icon w-5 h-5"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full pl-12 pr-10 py-2 rounded-lg glass-input focus:outline-none focus:ring-2"
                        placeholder="••••••••" />
                    <button type="button" id="togglePasswordConfirmation"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                        <i data-lucide="eye" class="w-5 h-5 glass-icon" id="eyeIconConfirmation"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full glass-button-dark font-semibold py-2 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                <i data-lucide="user-plus" class="w-5 h-5"></i> Register
            </button>

            <div class="text-center mt-3 text-sm">
                <p class="glass-text">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium glass-link hover:underline">
                        Login di sini
                    </a>
                </p>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Toggle Password Visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIconPassword = document.getElementById('eyeIconPassword');

            if (togglePassword && passwordInput && eyeIconPassword) {
                togglePassword.addEventListener('click', function() {
                    // Toggle the type attribute
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the icon
                    const iconName = type === 'password' ? 'eye' : 'eye-off';
                    eyeIconPassword.setAttribute('data-lucide', iconName);

                    // Recreate icons to update the changed icon
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            }

            // Toggle Password Confirmation Visibility
            const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const eyeIconConfirmation = document.getElementById('eyeIconConfirmation');

            if (togglePasswordConfirmation && passwordConfirmationInput && eyeIconConfirmation) {
                togglePasswordConfirmation.addEventListener('click', function() {
                    // Toggle the type attribute
                    const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' :
                        'password';
                    passwordConfirmationInput.setAttribute('type', type);

                    // Toggle the icon
                    const iconName = type === 'password' ? 'eye' : 'eye-off';
                    eyeIconConfirmation.setAttribute('data-lucide', iconName);

                    // Recreate icons to update the changed icon
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            }
        });
    </script>
</body>

</html>
