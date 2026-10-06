<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Draf Surat Rekomendasi</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.15;
            margin: 20px 40px;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h1 {
            font-size: 16pt;
            margin: 0;
            font-weight: bold;
        }
        .kop-surat h2 {
            font-size: 18pt;
            margin: 0;
            font-weight: bold;
        }
        .kop-surat p {
            font-size: 11pt;
            margin: 2px 0;
        }
        .judul-surat {
            text-align: center;
            margin-bottom: 15px;
        }
        .judul-surat h3 {
            font-size: 14pt;
            margin: 0;
            text-decoration: underline;
        }
        .judul-surat p {
            margin: 2px 0 0 0;
        }
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .tabel-data td {
            vertical-align: top;
            padding: 2px 0;
        }
        .col-no { width: 4%; }
        .col-label { width: 30%; }
        .col-titik { width: 3%; }
        .col-value { width: 63%; font-weight: bold; }
        
        .catatan {
            margin-top: 15px;
        }
        .catatan ol {
            padding-left: 20px;
            margin-top: 5px;
        }
        .ttd-box {
            float: right;
            width: 300px;
            margin-top: 30px;
        }
        .ttd-box p {
            margin: 2px 0;
        }
        .nama-camat {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 70px !important;
        }
    </style>
</head>
<body>

    <!-- Bagian Kop Surat PDF -->
<div style="position: relative; text-align: center; border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 25px;">
    
    <!-- Pengecekan: Logo HANYA MUNCUL jika status sudah di-ACC Camat -->
    @if(isset($is_acc) && $is_acc == true)
        <!-- Catatan: Untuk DomPDF, pemanggilan gambar lokal wajib menggunakan public_path() -->
        <img src="{{ public_path('images/Ngebel Ponorogo.png') }}" style="position: absolute; left: 10px; top: 0; width: 80px; height: auto;">
    @endif

    <h3 style="margin: 0; font-size: 16px; text-transform: uppercase;">PEMERINTAH KABUPATEN PONOROGO</h3>
    <h2 style="margin: 0; font-size: 20px; font-weight: bold; text-transform: uppercase;">KECAMATAN NGEBEL</h2>
    <p style="margin: 5px 0 0 0; font-size: 12px;">Jl. Raya Ngebel No. 1, Kabupaten Ponorogo, Jawa Timur, 63493</p>
    <p>Telepon 0352-591045, Faksimile 0352-591045,</p>
    <p>Laman ngebel.ponorogo.go.id, Pos-el ngebel@ponorogo.go.id</p>
</div>

<!-- Di bawah sini adalah isi konten surat Anda... -->

    <!-- Judul & Nomor Surat -->
    <div class="judul-surat">
        <h3>REKOMENDASI</h3>
        <p>Nomor: {{ $nomor_surat }}</p>
    </div>

    <!-- Paragraf Pembuka -->
    <p style="text-align: justify;">
        Berdasarkan {{ $dasar_surat }}.
    </p>
    <p>
        Dengan ini Camat Ngebel Kabupaten Ponorogo memberikan Rekomendasi kepada :
    </p>

    <!-- Tabel Data 10 Poin -->
    <table class="tabel-data">
        <tr>
            <td class="col-no">1</td>
            <td class="col-label">Nama Pelapor</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $nama_pelapor }}</td>
        </tr>
        <tr>
            <td class="col-no">2</td>
            <td class="col-label">NIK</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $nik }}</td>
        </tr>
        <tr>
            <td class="col-no">3</td>
            <td class="col-label">Jenis Kelamin</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $jenis_kelamin }}</td>
        </tr>
        <tr>
            <td class="col-no">4</td>
            <td class="col-label">Tempat/Tgl/Lhr</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $ttl }}</td>
        </tr>
        <tr>
            <td class="col-no">5</td>
            <td class="col-label">Alamat</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $alamat }}</td>
        </tr>
        <tr>
            <td class="col-no">6</td>
            <td class="col-label">Pekerjaan</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $pekerjaan }}</td>
        </tr>
        <tr>
            <td class="col-no">7</td>
            <td class="col-label">Tujuan Kegiatan</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $tujuan_kegiatan }}</td>
        </tr>
        <tr>
            <td class="col-no">8</td>
            <td class="col-label">Jenis Kegiatan</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $jenis_kegiatan }}</td>
        </tr>
        <tr>
            <td class="col-no">9</td>
            <td class="col-label">Tempat Kegiatan</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $tempat_kegiatan }}</td>
        </tr>
        <tr>
            <td class="col-no">10</td>
            <td class="col-label">Waktu Kegiatan</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $waktu_kegiatan }}</td>
        </tr>
    </table>

    <!-- Klausul / Ketentuan -->
    <div class="catatan">
        <p>DENGAN CATATAN DAN KETENTUAN SEBAGAI BERIKUT :</p>
        <ol>
            <li style="text-align: justify; margin-bottom: 5px;">Saat kegiatan wajib menjaga Ketentraman, Ketertiban dan Keamanan</li>
            <li style="text-align: justify; margin-bottom: 5px;">Pada saat masyarakat melakukan kegiatan ibadah, pengeras suara untuk dimatikan sementara</li>
            <li style="text-align: justify; margin-bottom: 5px;">Surat Rekomendasi ini diberikan kepada yang berkepentingan untuk dapat dipergunakan sebagaimana mestinya</li>
            <li style="text-align: justify; margin-bottom: 5px;">Jika melanggar / menyimpang dengan catatan dan ketentuan tersebut diatas, kami akan berkoordinasi dengan sektor terkait untuk membubarkan dan menghentikan serta mengambil sikap tegas sesuai dengan hukum yang berlaku.</li>
        </ol>
    </div>

    <!-- Tanda Tangan Pengesahan -->
    <div class="ttd-box">
        <table style="width: 100%; margin-bottom: 15px;">
            <tr>
                <td style="width: 40%;">Dikeluarkan</td>
                <td style="width: 5%;">:</td>
                <td style="width: 55%;">Ngebel</td>
            </tr>
            <tr>
                <td>Pada Tanggal</td>
                <td>:</td>
                <td>{{ $tanggal_dikeluarkan }}</td>
            </tr>
        </table>
        
        <p style="font-weight: bold; text-align: center;">CAMAT NGEBEL</p>
        
        <!-- Ruang untuk Stempel & Tanda Tangan Basah/TTE -->
        <p class="nama-camat" style="text-align: center;">{{ $nama_camat }}</p>
        <p style="text-align: center;">Pembina Tingkat I</p>
        <p style="text-align: center;">NIP. {{ $nip_camat }}</p>
    </div>

</body>
</html>