<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Psikotes {{ $candidate->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        h2, h4 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .passed { background-color: #d4edda; color: #155724; font-weight: bold; }
        .failed { background-color: #f8d7da; color: #721c24; font-weight: bold; }
        .header-info { margin-bottom: 20px; }
        .header-info td { border: none; padding: 4px; text-align: left; }
    </style>
</head>
<body>

    <h2>Laporan Psikotes Kandidat</h2>
    <table class="header-info">
        <tr>
            <td><strong>Nama Kandidat:</strong> {{ $candidate->name }}</td>
            <td><strong>Email:</strong> {{ $candidate->email }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Cetak:</strong> {{ date('d-m-Y H:i') }}</td>
            <td><strong>Status Test:</strong> {{ $candidate->is_finished ? 'Selesai' : 'Belum Selesai' }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Skor PG</th>
                <th>Jumlah Soal</th>
                <th>Persentase (%)</th>
                <th>Bobot</th>
                <th>Skor Bobot</th>
                <th>Passing Score</th>
                <th>Lulus / Tidak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r['category_name'] }}</td>
                    <td>{{ ucfirst($r['status']) }}</td>
                    <td>{{ $r['score'] }}</td>
                    <td>{{ $r['question_count'] }}</td>
                    <td>{{ $r['percent'] }}%</td>
                    <td>{{ $r['weight'] }}</td>
                    <td>{{ $r['weighted_score'] }}</td>
                    <td>{{ $r['passing_score'] }}</td>
                    <td class="{{ $r['passed'] ? 'passed' : 'failed' }}">
                        {{ $r['passed'] ? 'Lulus' : 'Tidak Lulus' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7">Total Skor Bobot Akhir</th>
                <th colspan="3">{{ $finalScore }}</th>
            </tr>
            <tr>
                <th colspan="7">Rekomendasi</th>
                <th colspan="3">{{ $recommendation }}</th>
            </tr>
        </tfoot>
    </table>

</body>
</html>
