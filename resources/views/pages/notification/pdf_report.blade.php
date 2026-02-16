<!DOCTYPE html>
<html>
<head>
    <title>Laporan Notifikasi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN RIWAYAT NOTIFIKASI</h2>
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Target</th>
                <th>Kategori</th>
                <th>Judul & Isi</th>
                <th>Terkirim</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    {{ ucfirst($log->target_type) }}<br>
                    <small>{{ $log->data_payload['target_name'] ?? '-' }}</small>
                </td>
                <td>{{ $log->category }}</td>
                <td>
                    <strong>{{ $log->title }}</strong><br>
                    {{ Str::limit($log->body, 50) }}
                </td>
                <td>{{ $log->total_sent }}</td>
                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>