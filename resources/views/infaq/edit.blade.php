@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-center mb-4">Edit Infaq Jamaah</h2>
    <form action="{{ route('infaq.update', $jamaah->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama:</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $jamaah->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="nomor" class="form-label">Nomor Telepon:</label>
            <input type="text" class="form-control" id="nomor" name="nomor" value="{{ old('nomor', $jamaah->nomor) }}" required>
        </div>

        <div class="mb-3">
            <label for="infaq_id" class="form-label">Tujuan Infaq:</label>
            <select name="infaq" id="infaq" class="form-select mb-3">
                @foreach ($infaqs as $Infaq)
                <option value="{{ $Infaq->id }}" {{ old('infaq') == $Infaq->id ? 'selected' : '' }}>{{ $Infaq->code.' - '.$Infaq->name }}</option>
                @endforeach
            </select>
            @error('infaq')
            <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="file_path" class="form-label">Bukti Transfer:</label>
            <input type="file" class="form-control" id="file_path" name="file_path">
            @if ($jamaah->file_path)
                <p class="mt-2">File saat ini: <a href="{{ asset('storage/' . $jamaah->file_path) }}">Lihat Bukti</a></p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Home</a>
    </form>
</div>
@endsection
