@extends('layouts.app')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg border-0" style="width: 100%; max-width: 600px;">
        <div class="card-header bg-dark text-white">
            <h2 class="fw-bold mb-0">Detail Infaq Jamaah</h2>
        </div>
        <div class="card-body">
            <h5 class="card-title">Nama: {{ $jamaahs->nama }}</h5>
            <p class="card-text">Nomor Telepon: {{ $jamaahs->nomor }}</p>
            <p class="card-text">Tujuan Infaq: {{ $jamaahs->infaq->name }}</p>
            <p class="card-text">Nama Pengguna: {{ $jamaahs->user->name }}</p>


            <div class="mt-4">
                <h6 class="card-subtitle mb-2 text-muted">Bukti Transfer:</h6>
                @if ($jamaahs->file_path)
                    <a href="{{ asset('storage/' . $jamaahs->file_path) }}" class="btn btn-link" target="_blank">Lihat Bukti Transfer</a>
                @else
                    <p class="text-danger">Tidak ada bukti transfer.</p>
                @endif
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('home') }}" class="btn btn-outline-light" style="background-color: #622200; color: white;">Kembali</a>
        </div>
    </div>
</div>
@endsection
