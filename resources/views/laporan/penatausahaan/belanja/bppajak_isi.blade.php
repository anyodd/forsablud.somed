<table class="table table-bordered table-striped" style="width: 100" id="example1">
    <thead>
        <tr>
            <th class="text-center" style="width: 3px">No.</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center" style="width: 5%">No.Bukti</th>
            <th class="text-center">Uraian</th>
            <th class="text-center">Penerimaan</th>
            <th class="text-center">Pengeluaran</th>
            <th class="text-center">Saldo</th>
        </tr>
    </thead>
    <tbody>
    @php
        $total_saldo = 0;
        $total_penerimaan = 0;
        $total_pengeluaran = 0;
    @endphp
        @if (count($pajak) > 0)
            @foreach ($pajak as $item)
                <tr>
                    <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                    <td>{{ date('d-m-Y',strtotime($item->dt_bp)) }}</td>
                    <td>{{ $item->No_bp }}</td>
                    <td>{{ $item->Uraian }}</td>
                    @if (!empty($item->Pajak))
                    <td class="text-right">{{ number_format($item->Pajak,2,',','.') }}</td>
                    @else
                    <td class="text-right">-</td>
                    @endif
                    @if (!empty($item->Setor))
                    <td class="text-right">{{ number_format($item->Setor,2,',','.') }}</td>
                    @else
                    <td class="text-right">-</td>
                    @endif
                    @if (!empty($item->Saldo))
                        @if ($item->Saldo < 0)
                            <td class="text-right">({{ number_format(abs($item->Saldo),2,',','.') }})</td>
                        @else
                            <td class="text-right">{{ number_format($item->Saldo,2,',','.') }}</td>
                        @endif
                    @else
                    <td class="text-right">-</td>
                    @endif
                </tr>
                @php
                    $total_penerimaan  += $item->Pajak;
                    $total_pengeluaran += $item->Setor;
                    $total_saldo       += $item->Saldo;
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
            @if ($total_penerimaan-$total_pengeluaran < 0)
            <th class="text-right">({{number_format(abs($total_penerimaan-$total_pengeluaran), 2, ',', '.')}})</th>
            @else
            <th class="text-right">{{number_format(abs($total_penerimaan-$total_pengeluaran), 2, ',', '.')}}</th>
            @endif
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
                Rp {{number_format($total_penerimaan-$total_pengeluaran, 0, ',', '.')}}<br>
                (Terbilang: {{ ucwords(terbilang($total_penerimaan-$total_pengeluaran)) }} Rupiah)<br>
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