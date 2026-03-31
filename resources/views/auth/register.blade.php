<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NexStock</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center px-4">
    <!-- Background Pattern -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-violet-100 to-indigo-100 rounded-full opacity-50"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-indigo-100 to-blue-100 rounded-full opacity-50"></div>
    </div>

    <!-- Register Container -->
    <div class="relative z-10 w-full max-w-md">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-2xl shadow-lg mb-4">
                <i class="fas fa-box text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">NexStock</h1>
            <p class="text-sm text-slate-600 mt-1">Sistem Inventaris Modern</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
            <div class="text-center mb-6">
                <h2 class="text-xl font-semibold text-slate-900">Buat Akun Baru</h2>
                <p class="text-sm text-slate-600 mt-1">Bergabung dengan NexStock sekarang</p>
            </div>

            <!-- Flash Messages -->
            @if(session('success') || session('error'))
                <div class="mb-6">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-check-circle text-green-600"></i>
                                <span class="text-sm font-medium">{{ session('success') }}</span>
                            </div>
                            <button onclick="this.parentElement.style.display='none'" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-exclamation-circle text-red-600"></i>
                                <span class="text-sm font-medium">{{ session('error') }}</span>
                            </div>
                            <button onclick="this.parentElement.style.display='none'" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Register Form -->
            <form action="/register" method="POST" class="space-y-4">
                @csrf

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded-lg text-sm">
                        <div class="flex items-center space-x-2 mb-1">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span class="font-medium">Perhatian:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                        <i class="fas fa-user text-slate-400 mr-2"></i>Nama Lengkap
                    </label>
                    <input type="text" id="name" name="name" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900 placeholder-slate-400"
                           value="{{ old('name') }}" placeholder="John Doe">
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                        <i class="fas fa-envelope text-slate-400 mr-2"></i>Email Gmail
                    </label>
                    <input type="email" id="email" name="email" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900 placeholder-slate-400"
                           value="{{ old('email') }}" placeholder="nama@gmail.com">
                    <p class="text-xs text-slate-500 mt-1">Harus menggunakan domain @gmail.com</p>
                </div>

                <!-- Phone Number Field -->
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-slate-700 mb-2">
                        <i class="fas fa-phone text-slate-400 mr-2"></i>Nomor Handphone
                    </label>
                    <input type="text" id="phone_number" name="phone_number" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900 placeholder-slate-400"
                           value="{{ old('phone_number') }}" placeholder="08xxxxxxxxxx">
                    <p class="text-xs text-slate-500 mt-1">Nomor HP harus diawali dengan 08</p>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                        <i class="fas fa-lock text-slate-400 mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900 placeholder-slate-400 pr-12"
                               placeholder="Minimal 6 karakter">
                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i id="passwordToggle" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Password minimal 6 karakter, maksimal 12 karakter</p>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">
                        <i class="fas fa-lock text-slate-400 mr-2"></i>Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900 placeholder-slate-400 pr-12"
                               placeholder="Ulangi password">
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i id="passwordConfirmToggle" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 mt-0.5">
                    <label for="terms" class="ml-2 text-sm text-slate-600">
                        Saya setuju dengan <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Syarat & Ketentuan</a> dan <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Kebijakan Privasi</a>
                    </label>
                </div>

                <!-- Register Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-4 py-3 rounded-lg hover:from-indigo-700 hover:to-violet-700 transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-slate-500">atau</span>
                </div>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-sm text-slate-600">
                    Sudah punya akun? 
                    <a href="/login" class="text-indigo-600 hover:text-indigo-700 font-medium">Masuk di sini</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-xs text-slate-500">
                © {{ date('Y') }} NexStock. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleId = fieldId === 'password' ? 'passwordToggle' : 'passwordConfirmToggle';
            const passwordToggle = document.getElementById(toggleId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
