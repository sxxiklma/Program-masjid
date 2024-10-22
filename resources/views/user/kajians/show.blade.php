@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header text-center" style="background-color: #8e4c28; color: white;">
            <h2 class="h4 mb-0">{{ $kajian->jeniskajian->name}} {{$kajian->title}}</h2>
        </div>
        <div class="card-body d-flex flex-wrap align-items-start">
            <div class="image-container text-center mb-3 me-3">
                @if($kajian->image)
                    <img src="/images/{{ $kajian->image }}" class="img-fluid rounded" alt="{{ $kajian->title }}" style="width: 300px; height: 300px; object-fit: cover;">
                @else
                    <div class="no-image bg-light d-flex justify-content-center align-items-center rounded" style="width: 300px; height: 300px;">
                        <span class="text-muted">No Image Available</span>
                    </div>
                @endif
            </div>
            <div class="content-container flex-grow-1">
                <h5 class="card-title">Pemateri</h5>
                <p class="card-text">oleh {{ $kajian->ustadz->name }}</p>
                <h5 class="card-title">Deskripsi Video</h5>
                <p class="card-text">{{ $kajian->description }}</p>
                <a href="{{ $kajian->youtube_link }}" target="_blank" class="btn btn-danger mt-3">
                    <i class="bi bi-youtube"></i> Watch on YouTube
                </a>
            </div>
        </div>
        <div class="card-footer">
            <a class="btn btn-secondary" href="{{ route('user.kajians.index') }}" style="background-color: #6c757d; border-color: #6c757d;">Back</a>
        </div>
    </div>
</div>
@endsection
