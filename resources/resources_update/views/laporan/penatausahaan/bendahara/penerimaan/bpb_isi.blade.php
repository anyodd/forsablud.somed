<table class="table table-bordered table-striped" style="width: 100%">
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
        $total = 0;
        $total_penerimaan = 0;
        $total_pengeluaran = 0;
    @endphp
    @if (count($data) > 0)
        @foreach ($data as $item)
        <tr>
            <td>{{$loop->iteration}}.</td>
            <td class="text-center">{{ date('d M Y', strtotime($item->Tgl_Bukti)) }}</td>
            <td>{{$item->No_Bukti}}</td>
            <td>{{$item->Ur_bp}}</td>
            <td class="text-right">{{number_format($item->Terima, 2, ',', '.')}}</td>
            <td class="text-right">{{number_format($item->Keluar, 2, ',', '.')}}</td>
            <td class="text-right">{{number_format($total += $item->Terima - $item->Keluar, 2, ',', '.')}}</td>
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