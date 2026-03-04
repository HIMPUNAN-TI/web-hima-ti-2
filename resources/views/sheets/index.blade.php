<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Sheets - HIMA TI</title>
</head>
<body>
    <h1>Data dari Google Sheets</h1>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    {{-- Form tambah data --}}
    <form method="POST" action="{{ route('admin.sheets.store') }}">
        @csrf
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="text" name="nim" placeholder="NIM" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Simpan ke Sheets</button>
    </form>

    {{-- Tabel data --}}
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                @if(!empty($rows[0]))
                    @foreach($rows[0] as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach(array_slice($rows, 1) as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach

            @if(count($rows) <= 1)
                <tr><td colspan="10">Belum ada data.</td></tr>
            @endif
        </tbody>
    </table>
</body>
</html>
