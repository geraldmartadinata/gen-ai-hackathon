<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - NexStock</title>
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
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-indigo-100 to-violet-100 rounded-full opacity-50"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-blue-100 to-indigo-100 rounded-full opacity-50"></div>
    </div>

    <!-- Welcome Container -->
    <div class="relative z-10 w-full max-w-md">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-2xl shadow-lg mb-4">
                <i class="fas fa-box text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-slate-900">NexStock</h1>
            <p class="text-lg text-slate-600 mt-2">Sistem Inventaris Modern</p>
        </div>

        <!-- Welcome Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-semibold text-slate-900 mb-4">Selamat Datang di NexStock</h2>
                <p class="text-slate-600">Sistem manajemen inventaris yang modern dan efisien untuk kebutuhan bisnis Anda.</p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <a href="/login" class="block w-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-violet-700 transition-all duration-200 font-medium text-center shadow-sm hover:shadow-md">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
                
                <a href="/register" class="block w-full bg-white border-2 border-indigo-600 text-indigo-600 px-6 py-3 rounded-lg hover:bg-indigo-50 transition-all duration-200 font-medium text-center">
                    <i class="fas fa-user-plus mr-2"></i>Register
                </a>
            </div>

            <!-- Features -->
            <div class="mt-8 pt-6 border-t border-slate-200">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-box text-blue-600 text-sm"></i>
                        </div>
                        <p class="text-xs text-slate-600">Manajemen Barang</p>
                    </div>
                    <div>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-tags text-green-600 text-sm"></i>
                        </div>
                        <p class="text-xs text-slate-600">Kategori</p>
                    </div>
                    <div>
                        <div class="w-10 h-10 bg-violet-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-file-invoice text-violet-600 text-sm"></i>
                        </div>
                        <p class="text-xs text-slate-600">Faktur</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-xs text-slate-500">
                © {{ date('Y') }} NexStock. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
