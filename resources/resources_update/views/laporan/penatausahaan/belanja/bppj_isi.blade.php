<table class="table table-bordered table-striped" style="width: 100%">
    <thead>
        <tr>
            <th class="text-center" style="width: 3px">No.</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">No.Bukti</th>
            <th class="text-center">Uraian</th>
            <th class="text-center">Penerimaan Panjar</th>
            <th class="text-center">Pengeluaran Panjar</th>
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
        @if (count($bppanjar) > 0)
            @foreach ($bppanjar as $item)
            <tr>
                <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                <td>{{ $item->dt_oto }}</td>
                <td>{{ $item->No_oto }}</td>
                <td>{{ $item->ur_oto }}</td>
                <td style="text-align: right">{{ number_format($item->Terima) }}</td>
                <td style="text-align: right">{{ number_format($item->Keluar) }}</td>
                <td style="text-align: right">
                    {{ number_format($total += $item->Terima - $item->Keluar) }}
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
            <th class="text-right">{{number_format($total_penerimaan, 0, ',', '.')}}</th>
            <th class="text-right">{{number_format($total_pengeluaran, 0, ',', '.')}}</th>
            <th class="text-right">{{number_format($total, 0, ',', '.')}}</th>
        </tr>
    </tfoot>
</table>