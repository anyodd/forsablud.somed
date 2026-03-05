<table class="table table-bordered table-striped table-responsive" style="width: 100%">
    <thead>
        <tr>
            <th class="text-center" style="width: 3px; vertical-align: middle;">No</th>
            <th class="text-center" style="vertical-align: middle;">No. Bukti</th>
            <th class="text-center" style="vertical-align: middle;">Tgl. Bukti</th>
            <th class="text-center" style="vertical-align: middle;">No. Bukti Setor</th>
            <th class="text-center" style="vertical-align: middle;">Tgl. Setor</th>
            <th class="text-center" style="vertical-align: middle;">No. Rincian</th>
            <th class="text-center" style="vertical-align: middle;">Kode Rekening</th>
            <th class="text-center" style="vertical-align: middle;">Uraian Rekening</th>
            <th class="text-center" style="vertical-align: middle;">Jumlah<br>Piutang (Rp)</th>
            <th class="text-center" style="vertical-align: middle;">Jumlah<br>Dibayar (Rp)</th>
            <th class="text-center" style="vertical-align: middle;">Sisa (Rp)</th>
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
            <td class="text-center">{{ $no++ }}</td>
            <td>{{ $item->No_Bukti }}</td>
            <td class="text-left">{{ date('d M Y', strtotime($item->Tgl_Bukti)) }}</td>
            <td class="text-center">{{ $item->No_Setor }}</td>
            <td class="text-left">{{ date('d M Y', strtotime($item->Tgl_Setor)) }}</td>
            <td class="text-left">{{ $item->Ko_bprc }}</td>
            <td class="text-center">{{ $item->Ko_Rkk }}</td>
            <td class="text-left">{{ $item->Ur_Rk6 }}</td>
            <td class="text-right">{{ number_format($item->Piutang, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->Setor, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->Blm_Setor, 0, ',', '.') }}</td>
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
            <th class="text-center" colspan=8>Total</th>
            <th class="text-right" style="font-size: 9pt">{{number_format($total_piutang, 0, ',', '.')}}</th>
            <th class="text-right" style="font-size: 9pt">{{number_format($total_setor, 0, ',', '.')}}</th>
            <th class="text-right" style="font-size: 9pt">{{number_format($total_blm_setor, 0, ',', '.')}}</th>
        </tr>
    </tfoot>
</table>