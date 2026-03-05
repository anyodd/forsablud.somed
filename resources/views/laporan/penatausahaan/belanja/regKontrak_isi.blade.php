<table class="table table-bordered table-striped" style="font-size: 9pt">
    <thead>
        <tr>
            <th class="text-center" style="width: 3px; vertical-align: middle">No.</th>
            <th class="text-center" style="vertical-align: middle">No.<br>Kontrak</th>
            <th class="text-center" style="vertical-align: middle">Tgl.<br>Kontrak</th>
            <th class="text-center" style="vertical-align: middle">Uraian</th>
            <th class="text-center" style="vertical-align: middle">Nama<br>Rekanan</th>
            <th class="text-center" style="vertical-align: middle">Kode<br>Kegiatan</th>
            <th class="text-center" style="vertical-align: middle">Uraian<br>Kegiatan</th>
            <th class="text-center" style="vertical-align: middle">Nilai<br>Kontrak (Rp)</th>
            <th class="text-center" style="vertical-align: middle">Nilai<br>Termin (Rp)</th>
            <th class="text-center" style="vertical-align: middle">Nilai<br>OPD (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total_kontrak = 0;
        $total_termin = 0;
        $total_spm = 0;
        @endphp
        @if (count($regKontrak) > 0)
        @foreach ($regKontrak as $item)
        <tr>
            <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}</td>
            <td>{{ $item->No_contr }}</td>
            <td class="text-center">{{ $item->dt_contr }}</td>
            <td>{{ $item->Ur_contr }}</td>
            <td>{{ $item->rekan_nm }}</td>
            <td class="text-center">{{ $item->Ko_Rkk }}</td>
            <td>{{ $item->Ur_Rk6 }}</td>
            <td style="text-align: right">{{ number_format($item->Nilai_Kontrak) }}</td>
            <td style="text-align: right">{{ number_format($item->Nilai_Termin) }}</td>
            <td style="text-align: right">{{ number_format($item->Nilai_SPM) }}</td>
        </tr>
        @php
        $total_kontrak += $item->Nilai_Kontrak;
        $total_termin += $item->Nilai_Termin;
        $total_spm += $item->Nilai_SPM;
        @endphp
        @endforeach
        @else
        <tr>
            <td colspan="10" style="text-align: center">Data tidak ada</td>
        </tr>
        @endif
    </tbody>
    <tfoot style="background-color: #1db790">
        <tr>
            <th class="text-center" colspan=7>Total</th>
            <th class="text-right">{{number_format($total_kontrak, 0, ',', '.')}}</th>
            <th class="text-right">{{number_format($total_termin, 0, ',', '.')}}</th>
            <th class="text-right">{{number_format($total_spm, 0, ',', '.')}}</th>
        </tr>
    </tfoot>
</table>