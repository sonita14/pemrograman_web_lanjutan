@extends('layout')

@section('title', 'Keranjang Belanja')

@section('content')
<h2 class="mb-4" style="color: var(--dark-blue);">
    <i class="fas fa-shopping-cart"></i> Keranjang Belanja
</h2>

@if(empty($cart))
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h4>Keranjang Anda Kosong</h4>
            <p class="text-muted">Silakan tambahkan produk ke keranjang</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali Berbelanja
            </a>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    @php $total = 0 @endphp
                    @foreach($cart as $id => $item)
                        @php $total += $item['price'] * $item['quantity'] @endphp
                        <div class="row mb-3 pb-3 border-bottom align-items-center">
                            <div class="col-md-2">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="img-fluid rounded" alt="{{ $item['name'] }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <h6>{{ $item['name'] }}</h6>
                                <p class="text-muted mb-0">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <div class="col-md-3">
                                <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control">
                                        <button type="submit" class="btn btn-outline-secondary">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <strong>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</strong>
                            </div>
                            <div class="col-md-1">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header" style="background: var(--primary-blue);">
                    <h5 class="mb-0 text-white">Checkout</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control" placeholder="08xxxxxxxxxx" required>
                            <small class="text-muted">Contoh: 081234567890</small>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Total:</h5>
                            <h5 class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane"></i> Kirim Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection