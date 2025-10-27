@extends('layout')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                <h2 class="mb-3">Pesanan Berhasil Dibuat!</h2>
                <p class="lead">Terima kasih <strong>{{ $order->customer_name }}</strong> telah berbelanja di Toko Biru</p>
                
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle"></i> 
                    Nomor Pesanan: <strong>#{{ $order->id }}</strong>
                </div>

                <p class="mb-4">Silakan klik tombol di bawah untuk mengirim detail pesanan ke WhatsApp Anda</p>

                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $order->whatsapp) }}?text={{ $message }}" 
                   target="_blank" 
                   class="btn btn-success btn-lg mb-3">
                    <i class="fab fa-whatsapp"></i> Kirim ke WhatsApp
                </a>

                <br>

                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection