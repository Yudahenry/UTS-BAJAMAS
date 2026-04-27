@extends('layout')

@section('content')

<div class="card p-4 shadow">
    <h3 class="mb-4">🛒 Buat Pesanan</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(empty($users))
        <div class="alert alert-warning">User Service Offline</div>
    @endif

    @if(empty($products))
        <div class="alert alert-warning">Product Service Offline</div>
    @endif

    <form method="POST" action="/order">
        @csrf

        <div class="mb-3">
            <label>User</label>
            <select name="userId" class="form-control" {{ empty($users) ? 'disabled' : '' }}>
                @foreach($users as $user)
                    <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Product</label>
            <select name="productId" class="form-control" {{ empty($products) ? 'disabled' : '' }}>
                @foreach($products as $product)
                    <option value="{{ $product['id'] }}">
                        {{ $product['name'] }} - Rp{{ number_format($product['price']) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success w-100"
            {{ empty($users) || empty($products) ? 'disabled' : '' }}>
            Buat Pesanan
        </button>
    </form>

</div>

@endsection