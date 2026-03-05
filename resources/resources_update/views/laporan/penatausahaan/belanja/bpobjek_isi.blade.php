<table class="table table-bordered table-striped" style="width: 100">
    <thead>
        <tr>
            <th class="text-center" style="width: 3px">No.</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">No.Bukti</th>
            <th class="text-center">Uraian</th>
            <th class="text-center">Belanja LS</th>
            <th class="text-center">Belanja UP/GU</th>
            <th class="text-center">Saldo</th>
        </tr>
    </thead>
    <tbody>
    @php
        $total_ls = 0;
        $total_gu = 0;
        $total_sisa = 0;
    @endphp
    @if (count($data) > 0)
        @foreach ($data as $item)
        <tr>
            <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
            <td>{{ $item->dt_rftrbprc }}</td>
            <td>{{ $item->No_bp }}</td>
            <td>{{ $item->Ur_bprc }}</td>
            <td style="text-align: right">{{ number_format($item->real_LS, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($item->real_GU, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($item->sisa, 2, ',', '.') }}
            </td>
        </tr>
    @php
        $total_ls += $item->real_LS;
        $total_gu += $item->real_GU;
        $total_sisa += $item->sisa;
    @endphp
        @endforeach
    @else
        <tr><td colspan="7" style="text-align: center">Data tidak ada</td></tr>    
    @endif
    </tbody>
    <tfoot style="background-color: #1db790">
        <tr>
            <th class="text-center" colspan=4>Total</th>
            <th class="text-right">{{number_format($total_ls, 2, ',', '.')}}</th>
            <th class="text-right">{{number_format($total_gu, 2, ',', '.')}}</th>
            <th class="text-right">{{number_format($total_sisa, 2, ',', '.')}}</th>
        </tr>
    </tfoot>
</table>