<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Berhasil Diverifikasi</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 30px;
        }
        .container {
            max-width: 560px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1d273b;
            font-size: 24px;
            margin-top: 10px;
        }
        .content {
            color: #4a5568;
            font-size: 15px;
            line-height: 1.6;
        }
        .badge-success {
            display: inline-block;
            background-color: #e6f7ec;
            color: #0d8a3d;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin: 15px 0;
        }
        .button {
            display: inline-block;
            background-color: #206bc4;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 13px;
            color: #a0aec0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="badge-success">✓ Terverifikasi</div>
            <h1>Email Anda Telah Berhasil Diverifikasi!</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            <p>Selamat! Alamat email Anda (<code>{{ $user->email }}</code>) telah berhasil diverifikasi secara resmi di sistem <strong>Himaprodi TI ITB STIKOM Bali</strong>.</p>
            <p>Sekarang akun Anda sudah aktif sepenuhnya. Anda dapat melengkapi profil peserta, mendaftar ke berbagai kegiatan dan event yang diselenggarakan, serta mengakses tiket kegiatan Anda.</p>
            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="button">Masuk ke Website</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Himaprodi TI ITB STIKOM Bali. Seluruh hak cipta dilindungi.</p>
        </div>
    </div>
</body>
</html>
