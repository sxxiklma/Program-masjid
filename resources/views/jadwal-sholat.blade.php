<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Sholat</title>
</head>
<body>
    <a href="{{ route('sholat.form') }}">Kembali ke Pencarian</a>

    @if($error)
        <h1>{{ $error }}</h1>
    @else
        @if(isset($data['lokasi']) && isset($data['daerah']))
            <h1>Jadwal Sholat untuk {{ $data['lokasi'] }} - {{ $data['daerah'] }}</h1>
        @else
            <h1>Jadwal Sholat</h1>
        @endif

        @if(isset($data['jadwal']) && is_array($data['jadwal']))
            <table border="1">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Imsak</th>
                        <th>Subuh</th>
                        <th>Terbit</th>
                        <th>Dhuha</th>
                        <th>Dzuhur</th>
                        <th>Ashar</th>
                        <th>Maghrib</th>
                        <th>Isya</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['jadwal'] as $jadwal)
                        <tr>
                            <td>{{ $jadwal['tanggal'] }}</td>
                            <td>{{ $jadwal['imsak'] }}</td>
                            <td>{{ $jadwal['subuh'] }}</td>
                            <td>{{ $jadwal['terbit'] }}</td>
                            <td>{{ $jadwal['dhuha'] }}</td>
                            <td>{{ $jadwal['dzuhur'] }}</td>
                            <td>{{ $jadwal['ashar'] }}</td>
                            <td>{{ $jadwal['maghrib'] }}</td>
                            <td>{{ $jadwal['isya'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada data tersedia.</p>
        @endif
    @endif
</body>
</html>
