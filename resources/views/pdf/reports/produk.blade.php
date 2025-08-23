<!DOCTYPE html>
<html>
<head>
    <title>Laporan Produk</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
        .footer { text-align: center; font-size: 0.8em; margin-top: 20px;}
    </style>
</head>
<body>
    <h1>Laporan Daftar Produk</h1>
    <p><strong>Kategori:</strong> {{ $categoryName }}</p>
    <p><strong>Tanggal Cetak:</strong> {{ date('d F Y') }}</p>
    <hr>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Stok</th>
                <th>Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data produk ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">
        Dicetak oleh Sistem Kasir BUMDes Baturetno
    </div>
</body>
</html>