<table class="table table-bordered table-striped" style="font-size: 9pt">
    <thead>
        <tr>
            <th class="text-center" style="width: 3px; vertical-align: middle; font-size: 10pt" rowspan="2">Kode Rekening</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt" rowspan="2">Uraian</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt" rowspan="2">Jumlah Anggaran</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt" colspan ="3">Realisasi</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt" rowspan="2">Sisa Anggaran Yang Belum Terealisasi/Pelampauan Anggaran</th>
        </tr>
        <tr>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">S/D Bulan Lalu</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">Bulan Ini</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">S/D Bulan Ini</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total1 = 0;
            $total2 = 0;
            $total3 = 0;
            $total4 = 0;
            $total5 = 0;
        @endphp
        @foreach ($data as $item => $list)
            <tr class="text-bold">
                <td colspan="2">{{$item}}</td>
                <td class="text-right">{{number_format($list['sub_anggaran'],2,',','.')}}</td>
                <td class="text-right">{{number_format($list['sub_lalu'],2,',','.')}}</td>
                <td class="text-right">{{number_format($list['sub_ini'],2,',','.')}}</td>
                <td class="text-right">{{number_format($list['sub_now'],2,',','.')}}</td>
                <td class="text-right">{{number_format($list['sub_sisa'],2,',','.')}}</td>
            </tr>
            @foreach ($list['rincian'] as $rinci => $ls)
                <tr>
                    <td>{{$ls['uraian']->Ko_Rkk}}</td>
                    <td>{{$rinci}}</td>
                    <td class="text-right">{{number_format($ls['uraian']->Anggaran,2,',','.')}}</td>
                    <td class="text-right">{{number_format($ls['uraian']->real_lalu,2,',','.')}}</td>
                    <td class="text-right">{{number_format($ls['uraian']->real_ini,2,',','.')}}</td>
                    <td class="text-right">{{number_format($ls['uraian']->real_now,2,',','.')}}</td>
                    <td class="text-right">{{number_format($ls['uraian']->sisa,2,',','.')}}</td>
                </tr>
            @endforeach
            @php
                $total1 += $list['sub_anggaran'];
                $total2 += $list['sub_lalu'];
                $total3 += $list['sub_ini'];
                $total4 += $list['sub_now'];
                $total5 += $list['sub_sisa'];
            @endphp
        @endforeach
    </tbody>
    <tfoot style="background-color: #1db790">
        <tr>
            <th class="text-center" colspan="2">Jumlah</th>
            <th class="text-right">{{number_format($total1, 2, ',', '.')}}</th>
            <th class="text-right">{{number_format($total2, 2, ',', '.')}}</th>
            <th class="text-right">{{number_format($total3, 2, ',', '.')}}</th>
            <th class="text-right">{{number_format($total4, 2, ',', '.')}}</th>
            <th class="text-right">{{number_format($total5, 2, ',', '.')}}</th>
        </tr>
    </tfoot>
</table>