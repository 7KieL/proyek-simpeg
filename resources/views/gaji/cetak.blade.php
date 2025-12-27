<!DOCTYPE html>
<html>
<head>
    <title>Slip Gaji Karyawan</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .container { width: 100%; margin: 0 auto; }
        
        /* Header */
        .header { text-align: center; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #4CAF50; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 12px; color: #666; }

        /* Info Karyawan */
        .info-table { width: 100%; margin-bottom: 20px; font-size: 14px; }
        .info-table td { padding: 5px; }
        .label { font-weight: bold; width: 150px; }

        /* Tabel Rincian */
        .rincian-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px; }
        .rincian-table th { background-color: #f2f2f2; padding: 10px; text-align: left; border: 1px solid #ddd; }
        .rincian-table td { padding: 8px; border: 1px solid #ddd; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        /* Total Gaji */
        .total-row td { background-color: #e8f5e9; font-weight: bold; font-size: 16px; border-top: 2px solid #4CAF50; }
        .total-label { text-align: right; padding: 10px; }
        .total-value { text-align: right; padding: 10px; color: #2e7d32; }

        /* Footer */
        .footer { margin-top: 50px; width: 100%; }
        .ttd-box { width: 40%; float: right; text-align: center; }
        .ttd-line { border-bottom: 1px solid #333; margin-top: 60px; width: 80%; margin-left: auto; margin-right: auto; }
        .note { font-size: 10px; color: #888; font-style: italic; margin-top: 20px; }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h2>SLIP GAJI KARYAWAN</h2>
            <p>PT. SIMPEG </p>
        </div>

        <table class="info-table">
            <tr>
                <td class="label">Periode</td>
                <td>: {{ strtoupper($gaji->bulan_tahun) }}</td>
                <td class="label">ID Slip</td>
                <td>: #{{ $gaji->id }}</td>
            </tr>
            <tr>
                <td class="label">Nama</td>
                <td>: {{ $gaji->user->name }}</td>
                <td class="label">Email</td>
                <td>: {{ $gaji->user->email }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td>: {{ date('d F Y') }}</td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <table class="rincian-table">
            <thead>
                <tr>
                    <th>KETERANGAN</th>
                    <th class="text-right">JUMLAH (IDR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>PENGHASILAN</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px;">Gaji Pokok</td>
                    <td class="text-right">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                </tr>
                
                <tr>
                    <td style="padding-left: 20px;">Tunjangan Lainnya</td>
                    <td class="text-right">
                        @if($gaji->tunjangan_lain > 0)
                            Rp {{ number_format($gaji->tunjangan_lain, 0, ',', '.') }}
                        @else
                            Rp 0
                        @endif
                    </td>
                </tr>
                    <td><strong>POTONGAN</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px; color: red;">Potongan</td>
                    <td class="text-right" style="color: red;">- Rp {{ number_format($gaji->potongan_lain, 0, ',', '.') }}</td>
                </tr>

                <tr class="total-row">
                    <td class="total-label">GAJI BERSIH (TAKE HOME PAY)</td>
                    <td class="total-value">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <div class="ttd-box">
                <p>Bandung, {{ date('d F Y') }}</p>
                <p>Manager Keuangan,</p>
                <div class="ttd-line"></div>
            </div>
        </div>

        <div style="clear: both;"></div>

        <p class="note">
            * Dokumen ini dibuat otomatis oleh sistem dan sah tanpa tanda tangan basah.
        </p>
    </div>

</body>
</html>