<div class="row">
    <div class="col-2 my-auto">
        Pilih Jenis Laporan
    </div>
    <div class="col-10">
        <select class="select2" name="pilihLaporan" id="pilihLaporan" style="width: 100%" onchange="pilihLaporan()">
            <option value="" disabled selected>-- Pilih Laporan --</option>
            <option value="penerimaan_sts">Register STS</option>
            <option value="sts">STS</option>
            <option value="penerimaan_bku">Buku Kas Umum</option>
            <option value="penerimaan_bpkt">Buku Pembantu Kas Tunai</option>
            <option value="penerimaan_bpb">Buku Pembantu Bank</option>
            <option value="penerimaan_lpj">Laporan Pertanggungjawaban</option>
            <option value="penerimaan_lpp">Laporan Penerimaan dan Penyetoran</option>
            <option value="regPiutang">Register Penerimaan</option>
            <option value="fungsional">SPJ Fungsional</option>
        </select>
    </div>
</div>

<script>
    function pilihan() {
        var selectedVal = (window.location.pathname).substring(1,100);

        if (selectedVal == 'penerimaan_sts') {
            $('#pilihLaporan').val('penerimaan_sts')
        } else if (selectedVal == 'sts') {
            $('#pilihLaporan').val('sts')
        } else if (selectedVal == 'penerimaan_bku') {
            $('#pilihLaporan').val('penerimaan_bku')
        } else if (selectedVal == 'penerimaan_bpkt') {
            $('#pilihLaporan').val('penerimaan_bpkt')
        } else if (selectedVal == 'penerimaan_bpb') {
            $('#pilihLaporan').val('penerimaan_bpb')
        } else if (selectedVal == 'penerimaan_lpj') {
            $('#pilihLaporan').val('penerimaan_lpj')
        } else if (selectedVal == 'penerimaan_lpp') {
            $('#pilihLaporan').val('penerimaan_lpp')
        } else if (selectedVal == 'regPiutang') {
            $('#pilihLaporan').val('regPiutang')
        } else if (selectedVal == 'fungsional') {
            $('#pilihLaporan').val('fungsional')
        }
    }

    function pilihLaporan() {
        var selectedVal = $('#pilihLaporan option:selected').val();

        if (selectedVal == 'penerimaan_sts') {
            window.location = "{{ route('penerimaan_sts') }}"
        } else if (selectedVal == 'sts') {
            window.location = "{{ route('qr_sts') }}"
        } else if (selectedVal == 'penerimaan_bku') {
            window.location = "{{ route('penerimaan_bku') }}"
        } else if (selectedVal == 'penerimaan_bpkt') {
            window.location = "{{ route('penerimaan_bpkt') }}"
        } else if (selectedVal == 'penerimaan_bpb') {
            window.location = "{{ route('penerimaan_bpb') }}"
        } else if (selectedVal == 'penerimaan_lpj') {
            window.location = "{{ route('penerimaan_lpj') }}"
        } else if (selectedVal == 'penerimaan_lpp') {
            window.location = "{{ route('penerimaan_lpp') }}"
        } else if (selectedVal == 'regPiutang'){
            window.location = "{{ route('regPiutang') }}"
        } else if (selectedVal == 'fungsional') {
            window.location = "{{ route('fungsionalpenerimaan') }}"
        }
    }
</script>