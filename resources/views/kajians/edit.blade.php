@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="h4 mb-4">Edit Kajian</h2>
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
            <div class="d-flex flex-wrap align-items-start">
                <div class="image-container text-center mb-3 me-3">
                    @if($kajian->image)
                        <img src="/images/{{ $kajian->image }}" class="img-fluid rounded" style="width: 300px; height: 300px; object-fit: cover;" alt="{{ $kajian->title }}">
                    @else
                        <div class="no-image bg-light d-flex justify-content-center align-items-center rounded" style="width: 300px; height: 300px;">
                            <span class="text-muted">No Image Available</span>
                        </div>
                    @endif
                </div>
                <div class="content-container flex-grow-1">
                    <form action="{{ route('kajians.update', $kajian->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Kajian</label>
                            <input type="text" name="title" value="{{ old('title', $kajian->title) }}" class="form-control" placeholder="Title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Video</label>
                            <textarea class="form-control" name="description" placeholder="Description">{{ old('description', $kajian->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="youtube_link" class="form-label">Link YouTube</label>
                            <input type="url" name="youtube_link" value="{{ old('youtube_link', $kajian->youtube_link) }}" class="form-control" placeholder="YouTube Link">
                        </div>
                        <div class="mb-4">
                            <label for="image" class="form-label">Ubah Gambar</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="start_time" class="form-label">Waktu Mulai</label>
                            <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time', $kajian->start_time ? \Carbon\Carbon::parse($kajian->start_time)->format('Y-m-d\TH:i') : '') }}">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn" style="background-color: #622200; color: white;">Submit</button>
                            <a href="{{ route('kajians.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
