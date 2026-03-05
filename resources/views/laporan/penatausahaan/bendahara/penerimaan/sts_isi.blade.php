<table class="table table-bordered table-striped" style="width: 100%">
    <thead>
        <tr>
            <th class="text-center" style="width: 3px">No</th>
            <th class="text-center">No.STS</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Kode Rekening</th>
            <th class="text-center">Uraian</th>
            <th class="text-center">Nilai</th>
            <th class="text-center">Ket</th>
        </tr>
    </thead>
    <tbody>
        @php 
            $no = 1;
            $total_nilai = 0;
        @endphp
    @if (count($data) > 0)
        @foreach ($data as $item)
        <tr>
            <td class="text-center">{{ $no++ }}</td>
            <td style="width: 15%">{{ $item->No_sts }}</td>
            <td class="text-center" style="width: 10%">{{ date('d M Y', strtotime($item->dt_sts)) }}</td>
            <td class="text-center" style="width: 10%">{{ $item->Ko_rkk }}</td>
            <td>{{ $item->Ur_Pdp }}</td>
            <td class="text-right" style="width: 10%">{{ number_format($item->to_rp, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        @php
            $total_nilai += $item->to_rp;
            @endphp
        @endforeach
    @else
        <tr><td colspan="7" style="text-align: center">Data tidak ada</td></tr>  
    @endif
    </tbody>
    <tfoot style="background-color: #1db790">
        <tr>
            <th class="text-center" colspan=5>Total</th>
            <th class="text-right">{{number_format($total_nilai, 0, ',', '.')}}</th>
            <th class="text-center"></th>
        </tr>
    </tfoot>
</table>