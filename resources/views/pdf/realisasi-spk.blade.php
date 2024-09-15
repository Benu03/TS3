<!DOCTYPE html>
<html>
<head>
    <title>Realisasi SPK</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #16A085;
            color: white;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">REALISASI SPK</h2>
    <p style="text-align: center;">
        @if ($from_date && $to_date)
            PERIOD {{ $from_date }} SAMPAI {{ $to_date }}
        @endif
        @if ($spkno)
            <br>SPK No: {{ $spkno }}
        @endif
        @if ($regional)
            <br>Regional: {{ $regional }}
        @endif
    </p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Polisi</th>
                <th>No Rangka</th>
                <th>No Mesin</th>
                <th>Regional</th>
                <th>Area</th>
                <th>Cabang</th>
                <th>SPK No</th>
                <th>Tanggal Service</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($realisasi_spk as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nopol }}</td>
                    <td>{{ $item->norangka }}</td>
                    <td>{{ $item->nomesin }}</td>
                    <td>{{ $item->regional }}</td>
                    <td>{{ $item->area }}</td>
                    <td>{{ $item->cabang }}</td>
                    <td>{{ $item->spk_no }}</td>
                    <td>{{ $item->tanggal_service }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
