<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Hasil Perhitungan WASPAS</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #444;
            padding-bottom: 15px;
        }
        .header h1 {
            text-transform: uppercase;
            margin: 0;
            font-size: 16px;
            color: #000;
        }
        .header h2 {
            margin: 5px 0 0;
            font-size: 12px;
            font-weight: normal;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 2px 0;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .main-table th {
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            padding: 6px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        .main-table td {
            border: 1px solid #ccc;
            padding: 6px 4px;
            vertical-align: middle;
            font-size: 9px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .bg-gray { background-color: #f9fafb; }
        
        .footer {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signature {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-space {
            height: 50px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Hasil Perhitungan WASPAS</h1>
        <h2>Detail Nilai Kriteria dan Perankingan</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="120" class="font-bold">Jabatan Target</td>
                <td width="10">:</td>
                <td>{{ $jabatan->nama_jabatan }}</td>
                <td width="100" class="font-bold">Tanggal Cetak</td>
                <td width="10">:</td>
                <td width="100">{{ $date }}</td>
            </tr>
            <tr>
                <td class="font-bold">Eselon</td>
                <td>:</td>
                <td>{{ $jabatan->eselon->eselon ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th width="20">Rank</th>
                <th width="120">Nama / NIP</th>
                <th width="40">Gol.</th>
                @foreach($kriterias as $kriteria)
                <th title="{{ $kriteria->kriteria }}">K{{ $kriteria->id }}</th>
                @endforeach
                <th>Q1 (WSM)</th>
                <th>Q2 (WPM)</th>
                <th>Qi (Total)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $index => $res)
            <tr>
                <td class="text-center font-bold">{{ $index + 1 }}</td>
                <td>
                    <div class="font-bold">{{ $res['nama'] }}</div>
                    <div style="font-size: 8px; color: #666;">{{ $res['nip'] }}</div>
                </td>
                <td class="text-center">{{ $res['golongan'] }}</td>
                <td class="text-center">{{ $res['pangkat'] }}</td>
                <td class="text-center">{{ $res['masa_jabatan'] }}</td>
                <td class="text-center">{{ $res['tingkat_pendidikan'] }}</td>
                <td class="text-center">{{ $res['bidang_ilmu'] }}</td>
                <td class="text-center">{{ $res['skp'] }}</td>
                <td class="text-center">{{ $res['penghargaan'] }}</td>
                <td class="text-center">{{ $res['hukdis'] }}</td>
                <td class="text-center">{{ $res['diklat'] }}</td>
                <td class="text-center">{{ $res['potensi'] }}</td>
                <td class="text-center">{{ $res['kompetensi'] }}</td>
                <td class="text-center">{{ number_format($res['q1'], 4) }}</td>
                <td class="text-center">{{ number_format($res['q2'], 4) }}</td>
                <td class="text-center font-bold bg-gray">{{ number_format($res['qi'], 4) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="font-size: 9px; margin-bottom: 10px;">
        <strong>Keterangan Kriteria:</strong> <br>
        @foreach($kriterias as $k)
            K{{ $k->id }}: {{ $k->kriteria }}{{ !$loop->last ? ', ' : '' }}
        @endforeach
    </div>

    <div class="footer">
        <div class="signature">
            <p>{{ config('app.location', 'Wonosobo') }}, {{ $date }}</p>
            <p>Panitia Seleksi,</p>
            <div class="signature-space"></div>
            <p class="font-bold">__________________________</p>
            <p>NIP. ...........................</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
