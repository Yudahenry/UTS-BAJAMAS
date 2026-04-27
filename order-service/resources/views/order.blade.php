<!DOCTYPE html>
<html>
<head>
    <title>BAJAMAS Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            padding: 40px 0;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }
        .search-box {
            margin-bottom: 10px;
        }
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0px 10px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <h3 class="text-center mb-4">🌿 BAJAMAS Order</h3>

                @if(empty($users))
                    <div class="alert alert-danger">User Service (8001) Offline</div>
                @endif
                @if(empty($products))
                    <div class="alert alert-danger">Product Service (8005) Offline</div>
                @endif

                <form method="POST" action="/order">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih User</label>
                        <input type="text" id="searchUser" class="form-control search-box" placeholder="Cari nama user...">
                        <select name="userId" id="userSelect" class="form-select" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($users as $user)
                                <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Produk</label>
                        <input type="text" id="searchProduct" class="form-control search-box" placeholder="Cari kemasan...">
                        <select name="productId" id="productSelect" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product['id'] }}">
                                    {{ $product['name'] }} - Rp{{ number_format($product['price']) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold">
                        BUAT PESANAN
                    </button>
                </form>

                <div class="mt-3 text-center">
                    <a href="/reset-orders" class="btn btn-sm btn-outline-danger">Reset Riwayat</a>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="table-container">
                <h4 class="mb-3 text-dark fw-bold">📋 Riwayat Pesanan Terintegrasi</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Order</th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $o)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $o['order_id'] }}</span></td>
                                    <td>{{ $o['customer_name'] }}</td>
                                    <td>{{ $o['product_name'] }}</td>
                                    <td>Rp{{ number_format($o['price']) }}</td>
                                    <td><small class="text-muted">{{ $o['date'] }}</small></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted italic">Belum ada data pesanan terintegrasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// FILTER USER SCRIPT
document.getElementById('searchUser').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let options = document.getElementById('userSelect').options;
    for (let i = 0; i < options.length; i++) {
        let text = options[i].text.toLowerCase();
        options[i].style.display = text.includes(filter) || options[i].value=="" ? '' : 'none';
    }
});

// FILTER PRODUCT SCRIPT
document.getElementById('searchProduct').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let options = document.getElementById('productSelect').options;
    for (let i = 0; i < options.length; i++) {
        let text = options[i].text.toLowerCase();
        options[i].style.display = text.includes(filter) || options[i].value=="" ? '' : 'none';
    }
});
</script>

</body>
</html>