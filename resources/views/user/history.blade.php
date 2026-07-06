<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - NexStock</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <!-- Modern Sticky Navbar -->
    <nav class="sticky top-0 z-50 bg-white border-b border-slate-200 backdrop-blur-lg bg-opacity-95">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-white text-sm"></i>
                    </div>
                    <span class="font-bold text-xl text-slate-900">NexStock</span>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">USER</span>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/user" class="text-slate-600 hover:text-slate-900 transition-colors">Katalog</a>
                    <a href="/user/cart" class="text-slate-600 hover:text-slate-900 transition-colors">Keranjang</a>
                    <a href="/user/history" class="text-indigo-600 font-medium hover:text-indigo-700 transition-colors">Riwayat</a>
                </div>

                <!-- User Profile -->
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-2 cursor-pointer group hover:bg-slate-50 rounded-lg px-3 py-2 transition-colors">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <i class="fas fa-chevron-down text-slate-400 text-xs group-hover:text-slate-600 transition-colors"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 py-1 z-50">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <i class="fas fa-user-circle mr-2"></i>Profil
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <i class="fas fa-cog mr-2"></i>Pengaturan
                        </a>
                        <form action="/logout" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success') || session('error'))
        <div class="fixed top-20 right-4 z-50 max-w-sm">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow-lg mb-2 flex items-center justify-between">
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
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-lg mb-2 flex items-center justify-between">
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

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Riwayat Pesanan</h1>
                <p class="text-slate-600 mt-1">Lihat semua pesanan Anda</p>
            </div>
            <a href="/user" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Katalog
            </a>
        </div>

        <!-- History Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-slate-900">Daftar Pesanan</h2>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-slate-500">Menampilkan riwayat pesanan</span>
                </div>
            </div>
            
            <!-- Real Data from Database -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Nomor Faktur</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Tanggal</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Total Harga</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Status</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @if($invoices->count() > 0)
                            @foreach($invoices as $invoice)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-receipt text-blue-600 text-xs"></i>
                                            </div>
                                            <span class="text-sm font-medium text-slate-900">{{ $invoice->invoice_number }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-slate-600">{{ $invoice->created_at->format('d M Y') }}</td>
                                    <td class="py-3 px-4 text-sm font-medium text-slate-900">Rp {{ number_format($invoice->total_price, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <button onclick="viewInvoice('{{ $invoice->invoice_number }}', {{ $invoice->total_price }}, '{{ $invoice->shipping_address }}', '{{ $invoice->postal_code }}')" class="text-indigo-600 hover:text-indigo-700 transition-colors font-medium text-sm">
                                            <i class="fas fa-eye mr-1"></i>Lihat Faktur
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-history text-slate-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-slate-900 mb-1">Belum ada riwayat pesanan</h3>
                                    <p class="text-sm text-slate-500">Mulai berbelanja untuk melihat riwayat pesanan Anda.</p>
                                    <a href="/user" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors mt-4">
                                        <i class="fas fa-shopping-cart mr-2"></i>Mulai Belanja
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modern Footer -->
    <footer class="bg-white border-t border-slate-200 mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <div class="w-6 h-6 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-md flex items-center justify-center">
                        <i class="fas fa-box text-white text-xs"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-900">NexStock</span>
                    <span class="text-sm text-slate-500">© {{ date('Y') }} All rights reserved.</span>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">Privacy</a>
                    <a href="#" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">Terms</a>
                    <a href="#" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">Support</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Toggle dropdown menu
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button[onclick="toggleDropdown()"]');
            
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Auto-hide flash messages after 3 seconds
        setTimeout(function() {
            const flashMessages = document.querySelectorAll('.fixed.top-20.right-4 > div');
            flashMessages.forEach(function(message) {
                message.style.display = 'none';
            });
        }, 3000);

        function viewInvoice(invoiceNumber) {
            window.location.href = '/user/invoice/show/' + invoiceNumber;
        }
    </script>
</body>
</html>
