<!DOCTYPE html>
<html>
<head>
    <title>Cari Jadwal Sholat</title>
</head>
<body>
    <h1>Cari Jadwal Sholat</h1>
    <form action="{{ route('sholat.result') }}" method="POST">
        @csrf
        <label for="city_id">Pilih Kota:</label>
        <select id="city_id" name="city_id" required>
            @foreach($cities as $city)
                <option value="{{ $city['id'] }}" {{ $city['id'] == $defaultCityId ? 'selected' : '' }}>
                    {{ $city['lokasi'] }}
                </option>
            @endforeach
        </select>
        <button type="submit">Cari</button>
    </form>

    <h2>Jadwal Sholat untuk Surabaya (Default)</h2>
    @if(isset($jadwalDefault['data']['jadwal']))
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
                @foreach($jadwalDefault['data']['jadwal'] as $jadwal)
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
        <p>Tidak ada data tersedia untuk Surabaya.</p>
    @endif
</body>
</html>
