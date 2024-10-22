@extends('layouts.app')

@section('content')
{{-- <div class="container mt-5">
    <h2 class="fw-bold text-center mb-4">Daftar Infaq Jamaah</h2>
    <table class="table table-bordered table-hover table-striped mb-0 bg-white">
        <thead>
            <tr>
                <th>Nama</th>
                <th>No.Tlp</th>
                <th>Tujuan</th>
                <th>Bukti Transfer</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jamaahs as $jamaah)
            <tr>
                <td>{{ $jamaah->nama }}</td>
                <td>{{ $jamaah->nomor }}</td>
                <td>{{ $jamaah->infaq_name }}</td>
                <td>
                    @if ($jamaah->file_path)
                        <a href="{{ asset('storage/' . $jamaah->file_path) }}" target="_blank">Lihat Bukti</a>
                    @else
                        Tidak ada bukti
                    @endif
                </td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('infaq.show', ['id' => $jamaah->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i class="bi-person-lines-fill"></i></a>
                        <a href="{{ route('infaq.edit', ['id' => $jamaah->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i class="bi-pencil-square"></i></a>
                        <div>
                            <form action="{{ route('infaq.destroy', ['id' => $jamaah->id]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-dark btn-sm me-2"><i class="bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}
@endsection
