@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="h4 mb-4">Tambah Kajian</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('kajians.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Kajian</label>
                    <input type="text" name="title" class="form-control" placeholder="Masukkan Judul Kajian" value="{{ old('title') }}">
                </div>
                <div class="mb-4">
                    <label for="jeniskajian_id" class="form-label">Jenis Kajian</label>
                    <select name="jeniskajian_id" id="jeniskajian_id" class="form-select @error('jeniskajian_id') is-invalid @enderror">
                        @foreach ($jeniskajianList as $id => $name)
                            <option value="{{ $id }}" {{ old('jeniskajian_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('jeniskajian_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="ustadz_id" class="form-label">Ustadz</label>
                    <select name="ustadz_id" id="ustadz_id" class="form-select @error('ustadz_id') is-invalid @enderror">
                        @foreach ($ustadzList as $id => $name)
                            <option value="{{ $id }}" {{ old('ustadz_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('ustadz_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Video</label>
                    <textarea class="form-control" name="description" placeholder="Masukkan Deskripsi Kajian">{{ old('description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="youtube_link" class="form-label">Link YouTube</label>
                    <input type="url" name="youtube_link" class="form-control" placeholder="YouTube Link" value="{{ old('youtube_link') }}">
                </div>
                <div class="mb-4">
                    <label for="image" class="form-label">Gambar</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="mb-4">
                    <label for="start_time" class="form-label">Waktu Mulai Kajian</label>
                    <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time') }}">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-block" style="background-color: #622200; border-color: #622200;">Submit</button>
                    <a href="{{ route('kajians.index') }}" class="btn btn-secondary" style="background-color: #6c757d; border-color: #6c757d;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
