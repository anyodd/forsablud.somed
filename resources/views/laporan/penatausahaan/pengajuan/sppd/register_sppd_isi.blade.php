<table class="table table-bordered table-striped" style="width: 100%">
    <thead>
        <tr>
            <th rowspan="2" class="text-center" style="vertical-align: middle;width: 3px">No.
            </th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Tanggal</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Nomor Surat - PPD</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Uraian</th>
            <th colspan="3" class="text-center" style="vertical-align: middle;">Jumlah</th>
            </th>
        </tr>
        <tr>
            <th class="text-center">UP</th>
            <th class="text-center">GU</th>
            <th class="text-center">LS</th>
        </tr>
    </thead>
    <tbody>
        @php 
            $no=1;
            $total_up=0;
            $total_gu=0;
            $total_ls=0;
        @endphp
            @if (count($regspp) > 0)
                @foreach ($regspp as $item)
                <tr>
                    <td style="text-align: center">{{ $no++ }}</td>
                    <td>{{ $item->Dt_SPi }}</td>
                    <td>{{ $item->No_SPi }}</td>
                    <td>{{ $item->Ur_SPi }}</td>
                    <td style="text-align: right">{{ number_format($item->UP) }}</td>
                    <td style="text-align: right">{{ number_format($item->GU) }}</td>
                    <td style="text-align: right">{{ number_format($item->LS) }}</td>
                </tr>
        @php
            $total_up += $item->UP;
            $total_gu += $item->GU;
            $total_ls += $item->LS;
        @endphp
            @endforeach
            @else
                <tr><td colspan="7" style="text-align: center">Data tidak ada</td></tr>  
            @endif
    </tbody>
    <tfoot style="background-color: #1db790">
        <tr>
            <th class="text-center" colspan=4>Total</th>
            <th class="text-right">{{number_format($total_up, 0, ',', '.')}}</th>
            <th class="text-right">{{number_format($total_gu, 0, ',', '.')}}</th>
            <th class="text-right">{{number_format($total_ls, 0, ',', '.')}}</th>
        </tr>
    </tfoot>
</table>