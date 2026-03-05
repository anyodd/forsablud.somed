<table class="table table-bordered table-striped table-responsive" style="width: 100%">
    <thead>
        <tr>
            <th class="text-center" style="width: 3px; vertical-align: middle; font-size: 10pt">No</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">No. Bukti</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">Tgl. Bukti</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">No. Bukti Setor</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">Tgl. Setor</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">No. Rincian</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">Kode Rekening</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">Uraian Rekening</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">Jumlah<br>Piutang (Rp)</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">Jumlah<br>Dibayar (Rp)</th>
            <th class="text-center" style="vertical-align: middle; font-size: 10pt">Sisa (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1;
        $total_piutang = 0;
        $total_setor = 0;
        $total_blm_setor = 0;
        @endphp
        @if (count($regPiutang) > 0)
        @foreach ($regPiutang as $item)
        <tr>
            <td class="text-center" style="font-size: 10pt">{{ $no++ }}</td>
            <td style="font-size: 10pt">{{ $item->No_Bukti }}</td>
            <td class="text-left" style="font-size: 10pt">{{ date('d M Y', strtotime($item->Tgl_Bukti)) }}</td>
            <td class="text-center" style="font-size: 10pt">{{ $item->No_Setor }}</td>
            <td class="text-left" style="font-size: 10pt">{{ date('d M Y', strtotime($item->Tgl_Setor)) }}</td>
            <td class="text-left">{{ $item->Ko_bprc }}</td>
            <td class="text-center" style="font-size: 10pt">{{ $item->Ko_Rkk }}</td>
            <td class="text-left" style="font-size: 10pt">{{ $item->Ur_Rk6 }}</td>
            <td class="text-right" style="font-size: 10pt">{{ number_format($item->Piutang, 2, ',', '.') }}</td>
            <td class="text-right" style="font-size: 10pt">{{ number_format($item->Setor, 2, ',', '.') }}</td>
            <td class="text-right" style="font-size: 10pt">{{ number_format($item->Blm_Setor, 2, ',', '.') }}</td>
        </tr>
        @php
        $total_piutang += $item->Piutang;
        $total_setor += $item->Setor;
        $total_blm_setor += $item->Blm_Setor;
        @endphp
        @endforeach
        @else
        <tr>
            <td colspan="11" style="text-align: center">Data tidak ada</td>
        </tr>
        @endif
    </tbody>
    <tfoot style="background-color: #1db790">
        <tr>
            <th class="text-center" colspan=8 style="font-size: 10pt">Total</th>
            <th class="text-right" style="font-size: 9pt">{{number_format($total_piutang, 2, ',', '.')}}</th>
            <th class="text-right" style="font-size: 9pt">{{number_format($total_setor, 2, ',', '.')}}</th>
            <th class="text-right" style="font-size: 9pt">{{number_format($total_blm_setor, 2, ',', '.')}}</th>
        </tr>
    </tfoot>
</table>