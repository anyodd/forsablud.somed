<table class="table table-bordered table-striped" style="width: 100" id="example1">
    <thead>
        <tr>
            <th class="text-center" style="width: 3px">No.</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">No.Bukti</th>
            <th class="text-center">Uraian</th>
            <th class="text-center">Penerimaan</th>
            <th class="text-center">Pengeluaran</th>
            <th class="text-center">Saldo</th>
        </tr>
    </thead>
    <tbody>
    @php
        $no = 1;
        $total = 0;
        $total_penerimaan = 0;
        $total_pengeluaran = 0;
    @endphp
        @if (count($bku) > 0)
            @foreach ($bku as $item)
            <tr>
                <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                <td>{{ $item->Tgl_Bukti }}</td>
                <td>{{ $item->No_Bukti }}</td>
                <td>{{ $item->Uraian }}</td>
                <td style="text-align: right">{{ number_format($item->Terima,2,',','.') }}</td>
                <td style="text-align: right">{{ number_format($item->Keluar,2,',','.') }}</td>
                <td style="text-align: right">
                    {{ number_format($total += $item->Terima - $item->Keluar,2,',','.') }}
                </td>
            </tr>
    @php
        $total_penerimaan += $item->Terima;
        $total_pengeluaran += $item->Keluar;
    @endphp
            @endforeach
            @else
                <tr><td colspan="7" style="text-align: center">Data tidak ada</td></tr>    
            @endif
    </tbody>
    <tfoot style="background-color: #1db790">
        <tr>
            <th class="text-center" colspan=4>Total</th>
            <th class="text-right">{{number_format($total_penerimaan, 2, ',', '.')}}</th> 
            <th class="text-right">{{number_format($total_pengeluaran, 2, ',', '.')}}</th>
            <th class="text-right">{{number_format($total, 2, ',', '.')}}</th>
        </tr>
    </tfoot>
</table>

<table style="width: 100%">
    <tbody>
        <tr>
            <td colspan="8">Saldo Kas di Bendahara Pengeluaran/Bendahara Pengeluaran
                Pembantu
                <br>
            </td>
        </tr>
        <tr>
            <td style="width: 3%"></td>
            <td colspan="7">
                Rp {{number_format($total, 0, ',', '.')}}<br>
                (Terbilang: {{ ucwords(terbilang($total)) }} Rupiah)<br>
                terdiri dari : <br>
                a. Tunai : Rp. ...........<br>
                b. Bank : Rp. ...........<br>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center">
                <strong>Disetujui oleh,<br>
                    Pengguna Anggaran/<br>
                    Kuasa Pengguna Anggaran
                    <br><br><br>
                    {{ tb_sub('Nm_Pimp') }}<br>
                    NIP {{ tb_sub('NIP_Pimp') }}
                    <br><br><br>
                </strong>
            </td>
            <td colspan="4" style="text-align: center">
                <strong>Disiapkan oleh,<br>
                    Bendahara Pengeluaran/<br>
                    Bendahara Pengeluaran Pembantu
                    <br><br><br>
                    {{ tb_sub('Nm_Bend') }}<br>
                    NIP {{ tb_sub('NIP_Bend') }}
                    <br><br><br>
                </strong>
            </td>
        </tr>
    </tbody>
</table>