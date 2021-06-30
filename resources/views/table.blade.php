<!DOCTYPE html>
<html>
<head>
	<title>Daftar 15 Gempa Bumi M 5.0+ </title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/table.css') }}">
</head>
<body>
    <center>
        <h1>Daftar 15 Gempa Bumi M 5.0+</h1>
        <h4>BMKG (Badan Meteorologi, Klimatologi, dan Geofisika)</h4>
        <table class="table1">
            <tr>
                <th>No</th>
                <th>Tanggal/Waktu</th>
                <th>Koordinat</th>
                <th>Magnitude</th>
                <th>Kedalaman</th>
                <th>Wilayah</th>
            </tr>
            @foreach ($data as $no => $item)
            <tr>
                <td class="text-center">{{ ($no+1) }}</td>
                <td class="text-center">{{ $item['tanggal'] }}, {{ $item['jam'] }}</td>
                <td class="text-center">
                    <!-- $item['latitude'] -->
                    <!-- $item['longitude'] -->
                    <a href="http://maps.google.com/maps?q={{ $item['latitude'] }},{{ $item['longitude'] }}&zoom=4" target="_blank"><img src="{{ asset('img/maps.png') }}" style="height: 40px;"></a>
                </td>
                <td class="text-center">{{ $item['magnitude'] }} SR</td>
                <td class="text-center">{{ $item['kedalaman'] }}</td>
                <td class="text-left SR">{{ $item['wilayah'] }}</td>
            </tr>
            @endforeach

        </table>	
    </center>
</body>
</html>