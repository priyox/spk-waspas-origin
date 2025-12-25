<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Hasil Akhir Seleksi</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #444;
            padding-bottom: 15px;
        }
        .header h1 {
            text-transform: uppercase;
            margin: 0;
            font-size: 18px;
            color: #000;
        }
        .header h2 {
            margin: 5px 0 0;
            font-size: 14px;
            font-weight: normal;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 3px 0;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .main-table th {
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .main-table td {
            border: 1px solid #ccc;
            padding: 8px;
            vertical-align: top;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .status-ms { color: #166534; font-weight: bold; }
        .status-masih-ms { color: #3730a3; font-weight: bold; }
        .status-tms { color: #991b1b; font-weight: bold; }
        
        .tag-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .tag-item {
            display: inline-block;
            background: #f3f4f6;
            padding: 2px 5px;
            border-radius: 3px;
            margin-bottom: 2px;
            font-size: 9px;
            border: 1px solid #e5e7eb;
        }
        .kelebihan { background-color: #f0fdf4; border-color: #bbf7d0; color: #166534; }
        .kekurangan { background-color: #fffbeb; border-color: #fef3c7; color: #92400e; }
        
        .footer {
            margin-top: 50px;
        }
        .signature {
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature-space {
            height: 60px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Hasil Akhir Seleksi Jabatan</h1>
        <h2>Sistem Pendukung Keputusan Metode WASPAS</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="150" class="font-bold">Jabatan Target</td>
                <td width="10">:</td>
                <td>{{ $jabatan->nama_jabatan }}</td>
            </tr>
            <tr>
                <td class="font-bold">Eselon</td>
                <td>:</td>
                <td>{{ $jabatan->eselon->eselon ?? '-' }}</td>
            </tr>
            <tr>
                <td class="font-bold">Tanggal Cetak</td>
                <td>:</td>
                <td>{{ $date }}</td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th width="30">Rank</th>
                <th width="150">Nama / NIP</th>
                <th width="60">Golongan</th>
                <th width="80">Pendidikan</th>
                <th width="60">Status Syarat</th>
                <th width="50">Skor Qi</th>
                <th>Analisis Kelebihan & Kekurangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $index => $res)
            <tr>
                <td class="text-center font-bold">{{ $index + 1 }}</td>
                <td>
                    <div class="font-bold">{{ $res['nama'] }}</div>
                    <div>{{ $res['nip'] }}</div>
                </td>
                <td class="text-center">{{ $res['golongan'] }}</td>
                <td class="text-center">{{ $res['pendidikan'] }}</td>
                <td class="text-center">
                    <span class="{{ $res['status_label'] == 'MS' ? 'status-ms' : ($res['status_label'] == 'Masih MS' ? 'status-masih-ms' : 'status-tms') }}">
                        {{ $res['status_label'] }}
                    </span>
                    @if(!$res['status_ms'])
                        <div style="font-size: 8px; color: #666; margin-top: 2px;">
                            {{ implode(', ', $res['alasan_tms']) }}
                        </div>
                    @endif
                </td>
                <td class="text-center font-bold">{{ $res['qi'] }}</td>
                <td>
                    <div style="margin-bottom: 5px;">
                        <span style="font-size: 8px; font-weight: bold; color: #166534;">KELEBIHAN:</span><br>
                        @forelse($res['kelebihan'] as $plus)
                            <span class="tag-item kelebihan">{{ $plus }}</span>
                        @empty
                            <span style="color: #999; font-style: italic;">-</span>
                        @endforelse
                    </div>
                    <div>
                        <span style="font-size: 8px; font-weight: bold; color: #92400e;">KEKURANGAN:</span><br>
                        @forelse($res['kekurangan'] as $minus)
                            <span class="tag-item kekurangan">{{ $minus }}</span>
                        @empty
                            <span style="color: #999; font-style: italic;">-</span>
                        @endforelse
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>{{ config('app.location', 'Wonosobo) }}, {{ $date }}</p>
            <p>Panitia Seleksi,</p>
            <div class="signature-space"></div>
            <p class="font-bold">__________________________</p>
            <p>NIP. ...........................</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
