@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header text-center" style="background-color: #8e4c28; color: white;">
            <h2 class="h4 mb-0">{{ $kajian->title }}</h2>
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
                <h5 class="card-title">Deskripsi Video</h5>
                <p class="card-text">{{ $kajian->description }}</p>
                <h5 class="card-title">Waktu Pelaksanaan</h5>
                <p class="card-text">
                    @if ($kajian->start_time)
                        {{ \Carbon\Carbon::parse($kajian->start_time)->format('d-m-Y H:i') }}
                    @else
                        Tidak ada waktu mulai
                    @endif
                </p>

                <!-- Countdown Timer -->
                @if ($kajian->start_time)
                <div class="mt-3">
                    <h5 class="card-title">Waktu Kajian dimulai</h5>
                    <p id="countdown" class="card-text"></p>
                </div>
                @endif

                <a href="{{ $kajian->youtube_link }}" target="_blank" class="btn btn-danger mt-3">
                    <i class="bi bi-youtube"></i> Watch on YouTube
                </a>
            </div>
        </div>
        <div class="card-footer">
            <a class="btn btn-secondary" href="{{ route('kajians.index') }}" style="background-color: #6c757d; border-color: #6c757d;">Back</a>
        </div>
    </div>
</div>

<!-- Countdown Timer Script -->
@if ($kajian->start_time)
<script>
    // Set the date we're counting down to
    var countDownDate = new Date("{{ $kajian->start_time }}").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes, and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="countdown"
        document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "Kajian Dimulai!";
        }
    }, 1000);
</script>
@endif

@endsection
