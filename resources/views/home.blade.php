@extends('layout')

@section('title', 'Beranda')

@section('content')
<div class="text-center mb-5">
    <h1 class="display-4 fw-bold" style="color: var(--dark-blue);">Selamat Datang di Toko Biru</h1>
    <p class="lead text-muted">Temukan produk berkualitas dengan harga terbaik</p>
</div>

<div class="row g-4">
    @forelse($products as $product)
        <div class="col-md-4">
            <div class="card h-100">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <i class="fas fa-image fa-4x text-muted"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-primary mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                        <span class="badge bg-info">Stok: {{ $product->stock }}</span>
                    </div>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Belum ada produk tersedia.
            </div>
        </div>
    @endforelse
</div>
@endsection