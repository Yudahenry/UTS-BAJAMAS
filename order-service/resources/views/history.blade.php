@extends('layout')

@section('content')

<div class="card p-4 shadow">
    <h3 class="mb-4">📦 Riwayat Pesanan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $o)
                <tr>
                    <td>{{ $o['order_id'] }}</td>
                    <td>{{ $o['customer_name'] }}</td>
                    <td>{{ $o['product_name'] }}</td>
                    <td>Rp{{ number_format($o['price']) }}</td>
                    <td>{{ $o['date'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada pesanan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection