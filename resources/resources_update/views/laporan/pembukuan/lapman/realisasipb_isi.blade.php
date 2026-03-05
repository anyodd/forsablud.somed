<table class="table table-bordered" id="example1" style="width: 100%">
    <thead>
        <tr>
            <th rowspan="2" class="text-center" style="width: 3px; vertical-align: middle;">No</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Uraian</th>
            <th colspan="4" class="text-center" style="vertical-align: middle;">Jumlah(Rp)</th>
            <th colspan="2" class="text-center" style="vertical-align: middle;">Bertambah/(Berkurang)</th>
        </tr>
        <tr>
            <th class="text-center" style="vertical-align: middle;">Anggaran dalam DPA</th>
            <th class="text-center" style="vertical-align: middle;">Realisasi s/d...lalu</th>
            <th class="text-center" style="vertical-align: middle;">Realisasi...ini</th>
            <th class="text-center" style="vertical-align: middle;">Realisasi s/d...lalu</th>
            <th class="text-center" style="vertical-align: middle;">Rp</th>
            <th class="text-center" style="vertical-align: middle;">%</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $gr => $data)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td> {{ $gr }}</td>
                <td style="text-align: right">
                    {{ number_format($data['tot_dpa'], 2, ",", ".") }}
                </td>
                <td style="text-align: right">
                    {{ number_format($data['tot_lalu'], 2, ",", ".") }}
                </td>
                <td style="text-align: right">
                    {{ number_format($data['tot_real'], 2, ",", ".") }}
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>