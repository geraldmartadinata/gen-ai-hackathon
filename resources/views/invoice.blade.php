<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventaris - NexStock</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { 
            font-family: 'Inter', sans-serif;
            background: white;
        }
        
        @media print {
            body { 
                margin: 0;
                padding: 20px;
                background: white;
            }
            .no-print {
                display: none !important;
            }
            @page {
                margin: 20mm;
                size: A4;
            }
        }
        
        .print-header {
            border-bottom: 2px solid #1e293b;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        
        .print-table {
            border-collapse: collapse;
            width: 100%;
        }
        
        .print-table th {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            color: #374151;
        }
        
        .print-table td {
            border: 1px solid #e2e8f0;
            padding: 10px 8px;
            font-size: 11px;
            color: #1f2937;
        }
        
        .print-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .summary-box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            background-color: #f9fafb;
        }
    </style>
</head>
<body class="bg-white text-gray-900">
    <!-- Print Controls (Hidden when printing) -->
    <div class="no-print mb-6 text-center">
        <button onclick="window.print()" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
            <i class="fas fa-print mr-2"></i>Cetak Laporan
        </button>
        <button onclick="window.close()" class="ml-3 bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
            <i class="fas fa-times mr-2"></i>Tutup
        </button>
    </div>

    <!-- Invoice Container -->
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="print-header">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">NexStock</h1>
                            <p class="text-sm text-gray-600">Sistem Inventaris Modern</p>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-600">
                        <p><strong>Alamat:</strong> Jl. Contoh No. 123, Jakarta, Indonesia</p>
                        <p><strong>Email:</strong> info@nexstock.com</p>
                        <p><strong>Telepon:</strong> +62 21 1234 5678</p>
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-bold text-gray-900 mb-1">LAPORAN INVENTARIS</h2>
                    <p class="text-sm text-gray-600 mb-3">No. INV/{{ date('Ymd') }}/001</p>
                    <div class="text-sm text-gray-600">
                        <p><strong>Tanggal Cetak:</strong> {{ date('d F Y') }}</p>
                        <p><strong>Pukul:</strong> {{ date('H:i:s') }}</p>
                        <p><strong>Dicetak oleh:</strong> {{ auth()->user()->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="summary-box">
                <div class="text-xs text-gray-600 mb-1">Total Kategori</div>
                <div class="text-xl font-bold text-gray-900">{{ $totalCategories }}</div>
            </div>
            <div class="summary-box">
                <div class="text-xs text-gray-600 mb-1">Total Jenis Barang</div>
                <div class="text-xl font-bold text-gray-900">{{ $totalItems }}</div>
            </div>
            <div class="summary-box">
                <div class="text-xs text-gray-600 mb-1">Total Quantity</div>
                <div class="text-xl font-bold text-gray-900">{{ $totalQuantity }}</div>
            </div>
            <div class="summary-box">
                <div class="text-xs text-gray-600 mb-1">Total Nilai Aset</div>
                <div class="text-xl font-bold text-gray-900">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Barang Inventaris</h3>
            
            @if($items->count() > 0)
                <table class="print-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Barang</th>
                            <th width="15%">Kategori</th>
                            <th width="12%">Harga Satuan</th>
                            <th width="10%">Quantity</th>
                            <th width="15%">Total Nilai</th>
                            <th width="15%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="font-medium">{{ $item->name }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-right font-medium">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($item->quantity > 10)
                                        <span class="text-green-600 font-medium">Stok Aman</span>
                                    @elseif($item->quantity > 5)
                                        <span class="text-yellow-600 font-medium">Stok Sedang</span>
                                    @else
                                        <span class="text-red-600 font-medium">Stok Rendah</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-100 font-semibold">
                            <td colspan="4" class="text-right">TOTAL:</td>
                            <td class="text-center">{{ $totalQuantity }}</td>
                            <td class="text-right">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <p class="text-gray-600">Tidak ada data barang yang tersedia</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="border-t-2 border-gray-800 pt-6 mt-8">
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-8">Dibuat oleh,</p>
                    <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-8">Diperiksa oleh,</p>
                    <p class="font-semibold text-gray-900">_________________</p>
                    <p class="text-xs text-gray-600">Manajer Inventaris</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-8">Disetujui oleh,</p>
                    <p class="font-semibold text-gray-900">_________________</p>
                    <p class="text-xs text-gray-600">Direktur</p>
                </div>
            </div>
            
            <div class="text-center mt-8 pt-4 border-t border-gray-300">
                <p class="text-xs text-gray-500">
                    Laporan ini dicetak secara otomatis dari sistem NexStock pada {{ date('d F Y H:i:s') }}<br>
                    Dokumen ini sah dan dapat digunakan sebagai bukti inventaris perusahaan.
                </p>
            </div>
        </div>
    </div>

    <!-- Auto Print Script -->
    <script>
        // Auto print when page loads
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 1000);
        });
        
        // Close window after printing
        window.addEventListener('afterprint', function() {
            window.close();
        });
    </script>
</body>
</html>
