<div class="table-responsive mt-3">
    <table class="table" id="table-rinci" width="100%">
        <thead class="bg-dark text-center">
            <tr>
                <th class="vertical-align: middle;">No</th>
				<th class="vertical-align: middle;">Provinsi</th>
				<th class="vertical-align: middle;">Kode Pemda</th>
				<th class="vertical-align: middle;">Pemerintah Daerah</th>
				<th class="vertical-align: middle;">Ibukota</th>
            </tr>
        </thead>
        @foreach ($data as $key => $item)
            <tr>
				<td class="text-center">{{ $item->kdurut }}</td>
                <td class="text-center">{{ $item->nama_prov_display }}</td>
				<td class="text-center">{{ $item->kode_pemda }}</td>
				<td class="text-center">{{ $item->nama_kab }}</td>
				<td class="text-center">{{ $item->ibukota }}</td>
            </tr>
        @endforeach
    </table>
</div>

<script type="text/javascript">
    $("#table-rinci").DataTable();
</script>

