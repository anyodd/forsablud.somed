<table class="table table-bordered table-striped" style="width: 100%;font-size: 10pt">
    <thead>
        <tr>
            <th rowspan="2" class="text-center" style="width: 3px">No.</th>
            <th colspan="2" class="text-center">PENDAPATAN</th>
            <th colspan="3" class="text-center">PENERIMAAN</th>
            <th colspan="3" class="text-center">PENYETORAN</th>

        </tr>
        <tr>
            <th class="text-center">Kode Rekening</th>
            <th class="text-center">Nama Rekening</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">No.Bukti</th>
            <th class="text-center">Jumlah</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">No.Bukti</th>
            <th class="text-center">Jumlah</th>

        </tr>
    </thead>
    <tbody>
    @php
        $total_penerimaan = 0;
        $total_penyetoran = 0;
    @endphp
    @if (count($data) > 0)
        @foreach ($data as $item)
        <tr>
            <td class="text-center">{{$loop->iteration}}.</td>
            <td>{{$item->Ko_Rkk}}</td>
            <td>{{$item->Ur_Rk6}}</td>
            <td class="text-center">{{ date('d M Y', strtotime($item->Tgl_Bukti)) }}</td>
            <td>{{$item->BK_Terima}}</td>
            <td class="text-right">{{number_format($item->Terima, 2, ',', '.')}}</td>
            <td class="text-center">{{ date('d M Y', strtotime($item->Tgl_Bukti)) }}</td>
            <td>{{$item->BK_Setor}}</td>
            <td class="text-right">{{number_format($item->Keluar, 2, ',', '.')}}</td>
        </tr>
    @php
        $total_penerimaan += $item->Terima;
        $total_penyetoran += $item->Keluar;
    @endphp
        @endforeach
    @else
        <tr><td colspan="9" style="text-align: center">Data tidak ada</td></tr>  
    @endif
    </tbody>
    <tfoot style="background-color: #1db790">
        <tr>
            <th class="text-center" colspan=5>Total</th>
            <th class="text-right">{{number_format($total_penerimaan, 2, ',', '.')}}</th>
            <th class="text-center" colspan=2></th>
            <th class="text-right">{{number_format($total_penyetoran, 2, ',', '.')}}</th>
        </tr>
    </tfoot>
</table>