<div class="row">
    <div class="col-2 my-auto">
        Pilih Jenis Laporan
    </div>
    <div class="col-10">
        <select class="select2" name="pilihLaporan" id="pilihLaporan" style="width: 100%" onchange="pilihLaporan()">
            <option value="" disabled selected>-- Pilih Laporan --</option>
            <option value="bku.show">Buku Kas Umum</option>
            <option value="bpgu.show">Buku Bantu Gu</option>
            <option value="bplsnon.show">Buku Bantu LS Non Kontrak</option>
            <option value="bplscontr.show">Buku Bantu LS Kontrak</option>
            {{-- <option value="bppj.show">Buku Bantu Panjar</option> --}}
            <option value="bppajak.show">Buku Bantu Pajak</option>
            <option value="tagihan.pdf">Daftar Tagihan</option>
            <option value="npd_pdf">Nota Pencairan Dana</option>
            {{-- <option value="pump_pdf">Permintaan Uang Panjar</option> --}}
            {{-- <option value="kump_pdf">Kuitansi Panjar</option> --}}
            <option value="reg_kontrak">Register Kontrak</option>
            <option value="subobjek">Buku Pembantu Per Sub Rincian Objek</option>
            <option value="fungsional">SPJ Fungsional</option>
        </select>
    </div>
</div>

<script>
    function pilihan() {
        var selectedVal = (window.location.pathname).substring(1,100);
        
        if (selectedVal == 'bku-show') {
            $('#pilihLaporan').val('bku.show')
        } else if (selectedVal == 'bpgu-show') {
            $('#pilihLaporan').val('bpgu.show')
        } else if (selectedVal == 'bplsnon-show') {
            $('#pilihLaporan').val('bplsnon.show')
        } else if (selectedVal == 'bplscontr-show') {
            $('#pilihLaporan').val('bplscontr.show')
        } else if (selectedVal == 'bppj') {
            $('#pilihLaporan').val('bppj.show')
        } else if (selectedVal == 'bppajak') {
            $('#pilihLaporan').val('bppajak.show')
        } else if (selectedVal == 'tagihan-pdf') {
            $('#pilihLaporan').val('tagihan.pdf')
        } else if (selectedVal == 'npd_pdf') {
            $('#pilihLaporan').val('npd_pdf')
        } else if (selectedVal == 'pump_pdf') {
            $('#pilihLaporan').val('pump_pdf')
        } else if (selectedVal == 'kump_pdf') {
            $('#pilihLaporan').val('kump_pdf')
        } else if (selectedVal == 'reg_kontrak') {
            $('#pilihLaporan').val('reg_kontrak')
        } else if (selectedVal == 'subobjek') {
            $('#pilihLaporan').val('subobjek')
        } else if (selectedVal == 'fungsional') {
            $('#pilihLaporan').val('fungsional')
        }
    }

    function pilihLaporan() {
        var selectedVal = $('#pilihLaporan option:selected').val();

        if (selectedVal == 'bku.show') {
            window.location = "{{ route('bku.show') }}"
        } else if (selectedVal == 'bpgu.show') {
            window.location = "{{ route('bpgu.show') }}"
        } else if (selectedVal == 'bplsnon.show') {
            window.location = "{{ route('bplsnon.show') }}"
        } else if (selectedVal == 'bplscontr.show') {
            window.location = "{{ route('bplscontr.show') }}"
        } else if (selectedVal == 'bppj.show') {
            window.location = "{{ route('bppj.show') }}"
        } else if (selectedVal == 'bppajak.show') {
            window.location = "{{ route('bppajak.show') }}"
        } else if (selectedVal == 'tagihan.pdf') {
            window.location = "{{ route('tagihan.pdf') }}"
        } else if (selectedVal == 'npd_pdf') {
            window.location = "{{ route('npd_pdf') }}"
        } else if (selectedVal == 'pump_pdf') {
            window.location = "{{ route('pump_pdf') }}"
        } else if (selectedVal == 'kump_pdf') {
            window.location = "{{ route('kump_pdf') }}"
        } else if (selectedVal == 'reg_kontrak'){
            window.location = "{{ route('reg.kontrak') }}"
        } else if (selectedVal == 'subobjek'){
            window.location = "{{ route('bpobjek') }}"
        } else if (selectedVal == 'fungsional'){
            window.location = "{{ route('fungsionalpengeluaran') }}"
        }
    }
</script>