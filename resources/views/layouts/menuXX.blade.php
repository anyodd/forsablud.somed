<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('dashboard')}}" class="brand-link">
    {{-- <img src="{{asset('template')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
    class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">BLUD</span> --}}
    <center><img src="{{ asset('template') }}/dist/img/logo_rs/logo_rs.png" alt="AdminLTE Logo"
      style="width: 40%">
    </center>
    <h2 class="text-center brand-text"><b>FORSA BLUD</b></h2>
  </a>
  
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('template')}}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="/" class="d-block">Administrator</a>
      </div>
    </div> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2 nav-compact">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
      data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
                 @if (in_array(getUser('user_level'), ['1','4','10']))
                 {{-- anggaran --}}
                 <li
                 class="nav-item {{ in_array(Request::segment(1), ['rba', 'rba_akun', 'setkegiatan', 'setkegs1', 'setkegs2', 'kegiatan', 'penetapan', 'spd', 'rka1_pendapatan', 'rka2_belanja', 'rka3_terima_biaya', 'rka4_keluar_biaya']) ? 'menu-open' : '' }}">
                 <a href="#" class="nav-link">
                  <img src="{{ asset('template') }}/dist/img/icon_menu/anggaran/anggaran.png"
                  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                  <p> Anggaran<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('setkegiatan.index') }}"
                      class="nav-link {{ in_array(Request::segment(1), ['setkegiatan', 'setkegs1', 'setkegs2']) ? 'active' : '' }}">
                      <img src="{{ asset('template') }}/dist/img/icon_menu/setting/program.png"
                      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                      <p>Program/Kegiatan</p>
                    </a>
                  </li>
                  {{-- 
                  <li class="nav-item">
                    <a href="{{ route('kegiatan.index') }}"
                      class="nav-link {{ in_array(Request::segment(1),  ['kegiatan', 'rka1_pendapatan', 'rka2_belanja', 'rka3_terima_biaya', 'rka4_keluar_biaya']) ? 'active' : '' }}">
                      <img src="{{ asset('template') }}/dist/img/icon_menu/anggaran/rba.png"
                      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                      <p>RBA</p>
                    </a>
                  </li>
                  --}}
                  <li class="nav-item">
                    <a href="{{ route('rba.index') }}"
                      class="nav-link {{ in_array(Request::segment(1),  ['rba', 'kegiatan', 'rba_akun', 'rka1_pendapatan', 'rka2_belanja', 'rka3_terima_biaya', 'rka4_keluar_biaya']) ? 'active' : '' }}">
                      <img src="{{ asset('template') }}/dist/img/icon_menu/anggaran/rba.png"
                      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                      <p>RBA</p>
                    </a>
                  </li>
                <li
                class="nav-item {{ in_array(Request::segment(1), ['penetapan', 'spd']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                  <img src="{{ asset('template') }}/dist/img/icon_menu/anggaran/definitif.png"
                  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                  <p>
                    Definitif
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @if (getUser('user_level') == '1')
                  <li class="nav-item">
                    <a href="{{ route('penetapan.index') }}"
                      class="nav-link {{ Request::segment(1) == 'penetapan' ? 'active' : '' }}">
                      <img src="{{ asset('template') }}/dist/img/icon_menu/anggaran/penetapan.png"
                      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                      <p>Penetapan</p>
                   </a>
                  </li>
                  @endif
                <li class="nav-item">
                  <a href="{{ route('spd.index') }}"
                  class="nav-link {{ Request::segment(1) == 'spd' ? 'active' : '' }}">
                  <img src="{{ asset('template') }}/dist/img/icon_menu/anggaran/spd.png"
                  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                  <p>Penyediaan Dana (SPD)</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      @endif
      @if (in_array(getUser('user_level'), ['1', '4', '6', '7']))
      {{-- bukti transaksi --}}
      <li
      class="nav-item {{ in_array(Request::segment(1), ['penerimaan','subpenerimaan','realisasi','realisasipdd','sts','sts-detail','tagihan','kontrak','termin','apbd','panjar','kuitansi','pajak','pembiayaan','titipan','transaksi','sisaup','sisapanjar',
      'subtagihan','subtermin','subkuitansi','pembayaran']) || 
      (Request::segment(1) == 'subapbd' && (Request::segment(2) == 'rincian' || Request::segment(2) == 'tambah')) ? 'menu-open': '' }}">
      <a href="#" class="nav-link">
        <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/buktitransaksi.png"
        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
        <p>
          Bukti Transaksi
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li
        class="nav-item {{ in_array(Request::segment(1), ['penerimaan','subpenerimaan', 'realisasi', 'realisasipdd', 'sts','sts-detail']) ? 'menu-open' : '' }}">
        <a href="{{ route('penerimaan.index') }}" class="nav-link">
          <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/pendapatan.png"
          alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
          <p>Pendapatan</p>
          <i class="right fas fa-angle-left"></i>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            {{-- <a href="{{ route('penerimaan.index') }}" --}}
            <a href="{{ route('penerimaan.bulan',date('m')) }}"
            class="nav-link {{ in_array(Request::segment(1),['penerimaan','subpenerimaan']) ? 'active' : '' }}">
            <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
            alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
            <p>Bukti Terima/Klaim</p>
          </a>
        </li>
        <li class="nav-item">
          {{-- <a href="{{ route('realisasi.index') }}" --}}
          <a href="{{ route('realisasi.bulan',date('m')) }}"
          class="nav-link {{ in_array(Request::segment(1),['realisasi','realisasipdd']) ? 'active' : '' }}">
          <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/realisasi.png"
          alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
          <p>Realisasi</p>
        </a>
      </li>
      <li class="nav-item">
        {{-- <a href="{{ route('sts.index') }}" --}}
        <a href="{{ route('sts.bulan',date('m')) }}"
        class="nav-link {{ in_array(Request::segment(1),['sts','sts-detail']) ? 'active' : '' }}">
        <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/sts.png"
        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
        <p>STS</p>
      </a>
    </li>
  </ul>
</li>
<li
class="nav-item {{ in_array(Request::segment(1), ['tagihan', 'kontrak', 'termin', 'apbd', 'panjar', 'kuitansi', 'pajak','subtagihan','subtermin','subkuitansi','pembayaran']) ? 'menu-open': '' }}">
<a href="#" class="nav-link">
  <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Belanja</p>
  <i class="right fas fa-angle-left"></i>
</a>
<ul class="nav nav-treeview">
  <li class="nav-item">
    {{-- <a href="{{ route('tagihan.index') }}" --}}
    <a href="{{ route('tagihan.bulan',date('m')) }}"
    class="nav-link {{ in_array(Request::segment(1), ['tagihan','subtagihan']) ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja/tagihan.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Tagihan</p>
  </a>
</li>
</ul>
<ul class="nav nav-treeview">
  <li
  class="nav-item {{ in_array(Request::segment(1), ['kontrak', 'termin','subtermin']) ? 'menu-open' : '' }}">
  <a href="#" class="nav-link">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja/kontrak.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Kontrak</p>
    <i class="right fas fa-angle-left"></i>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('kontrak.bulan',date('m')) }}"
      class="nav-link {{ Request::segment(1) == 'kontrak' ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Daftar Kontrak</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{ route('termin.bulan',date('m')) }}"
    class="nav-link {{ in_array(Request::segment(1), ['termin','subtermin']) ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Termin</p>
  </a>
</li>
</ul>
</li>
</ul>
<ul class="nav nav-treeview">
  <li class="nav-item">
    <a href="{{ route('apbd.bulan',date('m')) }}"
    class="nav-link {{ Request::segment(1) == 'apbd' || 
    (Request::segment(1) == 'subapbd' && (Request::segment(2) == 'rincian' || Request::segment(2) == 'tambah')) ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja/apbd.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>APBD-SP2D</p>
  </a>
</li>
</ul>
<ul class="nav nav-treeview">
  {{-- <li class="nav-item">
    <a href="{{ route('panjar.index') }}"
    class="nav-link {{ Request::segment(1) == 'panjar' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/setoranpajak.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>SPJ TU</p>
  </a> --}}
</li>
</ul>
<ul class="nav nav-treeview">
  <li class="nav-item">
    {{-- <a href="{{ route('kuitansi.index') }}" --}}
    <a href="{{ route('kuitansi.bulan',date('m')) }}"
    class="nav-link {{ in_array(Request::segment(1), ['kuitansi','subkuitansi','pembayaran']) ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja/kuitansi.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Bukti GU</p>
  </a>
</li>
</ul>
<ul class="nav nav-treeview">
  <li class="nav-item">
    <a href="{{ route('pajak.index') }}"
    class="nav-link {{ Request::segment(1) == 'pajak' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja/pajak.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Pajak</p>
  </a>
</li>
</ul>
</li>
<li class="nav-item">
  <a href="{{ route('pembiayaan.index') }}"
  class="nav-link {{ Request::segment(1) == 'pembiayaan' ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pembiayaan.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Pembiayaan</p>
</a>
</li>
<li class="nav-item">
  <a href="{{ route('titipan.index') }}"
  class="nav-link {{ Request::segment(1) == 'titipan' ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/uangtitipan.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Uang Titipan</p>
</a>
</li>
</li>
<li
class="nav-item {{ in_array(Request::segment(1), ['sisaup', 'sisapanjar']) ? 'menu-open' : '' }}">
<a href="#" class="nav-link">
  <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja/kontrak.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Penyetoran Sisa Kas</p>
  <i class="right fas fa-angle-left"></i>
</a>
<ul class="nav nav-treeview">
  <li class="nav-item">
    <a href="{{ route('sisaup.index') }}"
    class="nav-link {{ Request::segment(1) == 'sisaup' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>UP/GU</p>
  </a>
</li>
{{-- <li class="nav-item">
  <a href="{{ route('sisapanjar.index') }}"
  class="nav-link {{ Request::segment(1) == 'sisapanjar' ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>TU</p>
</a>
</li> --}}
</ul>
</li>
@if (in_array(getUser('user_level'), ['1']))
<li class="nav-item">
  <a href="{{ route('transaksi.index') }}"
    class="nav-link {{ Request::segment(1) == 'transaksi' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja/tagihan.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Daftar Transaksi</p>
  </a>
</li>
@endif
</ul>
</li>
@endif
@if (in_array(getUser('user_level'), ['1', '4', '6','7']))
{{-- pengajuan --}}
<li
class="nav-item {{ in_array(Request::segment(1), ['kasawal','lsnonkontrak','lsnonkontrakutang','lskontrak','spjgu','spppanjar','spjnihil','sppnihilpanjar','spjpendapatan','verifikasi'])? 'menu-open': '' }}">
<a href="#" class="nav-link">
  <img src="{{ asset('template') }}/dist/img/icon_menu/pengajuan/pengajuan.png" alt="Product 1"
  class="nav-icon img-circle img-size-32 mr-1">
  <p>
    Pengajuan
    <i class="right fas fa-angle-left"></i>
  </p>
</a>
<ul class="nav nav-treeview">
  <li class="nav-item">
    <a href="{{ route('kasawal.index') }}"
    class="nav-link {{ Request::segment(1) == 'kasawal' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/pengajuan/kasawal.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Kas Awal/UP</p>
  </a>
</li>
<li
class="nav-item {{ in_array(Request::segment(1), ['lsnonkontrak','lsnonkontrakutang','lskontrak','spjgu','spppanjar','spjnihil','sppnihilpanjar'])? 'menu-open': '' }}">
<a href="#" class="nav-link">
  <img src="{{ asset('template') }}/dist/img/icon_menu/pengajuan/order.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>
    SPP Belanja
    <i class="right fas fa-angle-left"></i>
  </p>
</a>
<ul class="nav nav-treeview">
  <li class="nav-item">
    {{-- <a href="{{ route('lsnonkontrak.index') }}" --}}
    <a href="{{ route('lsnonkontrak.bulan',date('m')) }}"
    class="nav-link {{ in_array(Request::segment(1), ['lsnonkontrak','lsnonkontrakutang']) ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/pengajuan/lstagihan.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>LS Tagihan</p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ route('lskontrak.index') }}"
  class="nav-link {{ Request::segment(1) == 'lskontrak' ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/pengajuan/lskontrak.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>LS Kontrak/SPK</p>
</a>
</li>
<li class="nav-item">
  {{-- <a href="{{ route('spjgu.index') }}" --}}
  <a href="{{ route('spjgu.bulan',date('m')) }}"
  class="nav-link {{ Request::segment(1) == 'spjgu' ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/pengajuan/gu.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Ganti Uang (GU)</p>
</a>
</li>
{{-- <li class="nav-item">
  <a href="{{ route('spppanjar.index') }}"
  class="nav-link {{ Request::segment(1) == 'spppanjar' ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/setoranpajak.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>TU</p>
</a>
</li> --}}
<li
class="nav-item {{ in_array(Request::segment(1), ['spjnihil', 'sppnihilpanjar']) ? 'menu-open' : '' }}">
<a href="" class="nav-link">
  <img src="{{ asset('template') }}/dist/img/icon_menu/pengajuan/gunihil.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>SPP Nihil
    <i class="fas fa-angle-left right"></i>
  </p>
</a>
<ul class="nav nav-treeview">
  <li class="nav-item">
    <a href="{{ route('spjnihil.index') }}"
    class="nav-link {{ Request::segment(1) == 'spjnihil' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/pengajuan/gunihil.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Nihil GU</p>
  </a>
</li>
{{-- <li class="nav-item">
  <a href="{{ route('sppnihilpanjar.index') }}"
    class="nav-link {{ Request::segment(1) == 'sppnihilpanjar' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/setoranpajak.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Nihil Panjar/TU</p>
  </a>
</li> --}}
</ul>
</li>
</ul>
</li>
<li class="nav-item">
  <a href="{{ route('spjpendapatan.index') }}"
    class="nav-link {{ Request::segment(1) == 'spjpendapatan' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/pengajuan/pendapatan.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>SPJ Pendapatan</p>
</a>
</li>
@if (in_array(getUser('user_level'), ['1', '2','4']))
<li class="nav-item">
  {{-- <a href="{{ route('verifikasi.index') }}" --}}
  <a href="{{ route('verifikasi.bulan',date('m')) }}"
    class="nav-link {{ Request::segment(1) == 'verifikasi' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/pengajuan/verifikasi.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Verifikasi</p>
  </a>
</li>
@endif
</ul>
</li>
@endif

@if (in_array(getUser('user_level'), ['1', '2', '3']))
{{-- otorisasi --}}
<li
class="nav-item {{ in_array(Request::segment(1), ['otorisasi', 'penomoran']) ? 'menu-open' : '' }}">
<a href="#" class="nav-link">
  <img src="{{ asset('template') }}/dist/img/icon_menu/otorisasi/otorisasi.png" alt="Product 1"
  class="nav-icon img-circle img-size-32 mr-1">
  <p>
    Otorisasi
    <i class="fas fa-angle-left right"></i>
  </p>
</a>
<ul class="nav nav-treeview">
  @if (in_array(getUser('user_level'), ['1', '2']))
  <li class="nav-item">
    <a href="{{ route('otorisasi.index') }}"
      class="nav-link {{ Request::segment(1) == 'otorisasi' ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/otorisasi/otorisasi_.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Otorisasi</p>
    </a>
  </li>
  @endif
  <li class="nav-item">
    <a href="{{ route('penomoran') }}"
    class="nav-link {{ Request::segment(1) == 'penomoran' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/otorisasi/penomoran.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Penomoran</p>
    </a>
  </li>
</ul>
</li>
@endif

@if (in_array(getUser('user_level'), ['1', '7', '8']))
{{-- Realisasi --}}
<li
class="nav-item {{ in_array(Request::segment(1), ['spm','setorpajak']) ? 'menu-open' : '' }}">
<a href="#" class="nav-link">
  <img src="{{ asset('template') }}/dist/img/icon_menu/pembukuan/pembukuan.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>
    Realisasi
    <i class="fas fa-angle-left right"></i>
  </p>
</a>
<ul class="nav nav-treeview">
  <li class="nav-item">
    <a href="{{ route('spm.index') }}"
    class="nav-link {{ Request::segment(1) == 'spm' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pembiayaan.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Pencairan Dana (S-PD)</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{route('setorpajak.index')}}"
    class="nav-link {{ Request::segment(1) == 'setorpajak' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pembiayaan.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Setor Pajak</p>
    </a>
  </li>
</ul>
</li>
@endif

@if (in_array(getUser('user_level'), ['1', '5']))
{{-- pengesahan --}}
<li
class="nav-item {{ in_array(Request::segment(1), ['pengesahan', 'sp2b']) ? 'menu-open' : '' }}">
<a href="#" class="nav-link">
  <img src="{{ asset('template') }}/dist/img/icon_menu/pengesahan/pengesahan.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>
    Pengesahan
    <i class="fas fa-angle-left right"></i>
  </p>
</a>
<ul class="nav nav-treeview">
  <li class="nav-item">
    <a href="{{ route('pengesahan.index') }}"
    class="nav-link {{ Request::segment(1) == 'pengesahan' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/pengesahan/sp3b.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>SP3B</p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ route('sp2b.index') }}"
  class="nav-link {{ Request::segment(1) == 'sp2b' ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/pengesahan/sp2b.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>SP2B</p>
</a>
</li>
</ul>
</li>
@endif

@if (in_array(getUser('user_level'), ['1', '7', '8']))
{{-- pembukuan --}}
<li
class="nav-item {{ in_array(Request::segment(1), ['penyesuaian', 'koreksi', 'saldoawal', 'saldoawalpiutang', 'saldoawalutang', 'mutasikasbank','rebuild']) ? 'menu-open' : '' }}">
<a href="#" class="nav-link">
  <img src="{{ asset('template') }}/dist/img/icon_menu/pembukuan/pembukuan.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>
    Pembukuan
    <i class="fas fa-angle-left right"></i>
  </p>
</a>
<ul class="nav nav-treeview">
  <li class="nav-item">
    <a href="{{ route('penyesuaian.index') }}"
      class="nav-link {{ Request::segment(1) == 'penyesuaian' ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/pembukuan/penyesuaian.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Penyesuaian</p>
    </a>
  </li>
  {{-- <li class="nav-item">
    <a href="{{ route('koreksi.index') }}"
    class="nav-link {{ Request::segment(1) == 'koreksi' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/pembukuan/koreksi.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Koreksi</p>
  </a>
  </li> --}}
  <li class="nav-item">
      <a href="{{ route('saldoawal.index') }}"
      class="nav-link {{ in_array(Request::segment(1), ['saldoawal', 'saldoawalpiutang', 'saldoawalutang']) ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/pembukuan/saldoawal.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Saldo Awal</p>
      </a>
  </li>
  {{-- <li class="nav-item">
    <a href="{{ route('mutasikasbank.index') }}"
      class="nav-link {{ Request::segment(1) == 'mutasikasbank' ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/pembukuan/mutasi.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Mutasi Kas Bank</p>
    </a>
  </li> --}}
  <li class="nav-item">
    <a href="{{ Route('rebuild.index') }}"
      class="nav-link {{ Request::segment(1) == 'rebuild' ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/belanja/kontrak.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Rebuild Jurnal</p>
    </a>
  </li>
</ul>
</li>
@endif

@if (in_array(getUser('user_level'), ['1', '2', '3', '4', '5', '6', '7', '8','10']))
{{-- laporan --}}
<li class="nav-item {{ in_array(Request::segment(1), ['dba-pdf', 'dba2-pdf', 'dba3-pdf', 'dba4-pdf', 'dba5-pdf', 
'rka1_pendapatan', 'rka2_belanja', 'rka3_terima_biaya', 'rka4_keluar_biaya', 
'dpa1', 'dpa2', 'dpa3', 'dpa4', 
'penerimaan_sts', 'bku-show', 'lap_sppd', 'spj_pdf', 'lap_oto','lapregPiutang', 'lapkeu', 'lapman', 'lapjurnal','lapbb','lapbb_sub','lapbb_subrinci','lapbb_rekap','bkublud','realisasipb','lapsoaw']) ? 'menu-open' : '' }}">
  <a href="#" class="nav-link {{ in_array(Request::segment(1), ['lapkeu-pdf', 'lapkeu', 'lapman', 'jurnal-show', 'lapjurnal']) ? 'menu-open' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png" alt="Product 1"
    class="nav-icon img-circle img-size-32 mr-1">
    <p>
      Laporan
      <i class="fas fa-angle-left right"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item {{ in_array(Request::segment(1), ['dba-pdf', 'rka1_pendapatan', 'rka2_belanja', 'rka3_terima_biaya', 'rka4_keluar_biaya', 'dba2-pdf', 'dba3-pdf', 'dba4-pdf', 'dba5-pdf', 'dpa1', 'dpa2', 'dpa3', 'dpa4']) ? 'menu-open' : '' }}">
      <a href="{{ route('rencana_ba_pendapatan.index') }}" class="nav-link">
        <img src="{{ asset('template') }}/dist/img/icon_menu/anggaran/definitif.png"
        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
        <p>Perencanaan</p>
        <i class="right fas fa-angle-left"></i>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('dba.pdf') }}"
            class="nav-link {{ in_array(Request::segment(1), ['dba-pdf', 'dba2-pdf', 'dba3-pdf', 'dba4-pdf', 'dba5-pdf']) ? 'active' : '' }}">
            <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
            alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
            <p>DBA</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('rka1_pendapatan') }}"
            class="nav-link {{ in_array(Request::segment(1), ['rka1_pendapatan', 'rka2_belanja', 'rka3_terima_biaya', 'rka4_keluar_biaya']) ? 'active' : '' }}">
            <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/realisasi.png"
            alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
            <p>RKA</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('dpa1') }}"
            class="nav-link {{ in_array(Request::segment(1), ['dpa1', 'dpa2', 'dpa3', 'dpa4']) ? 'active' : '' }}">
            <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/sts.png"
            alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
            <p>DPA</p>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a href="" class="nav-link">
            <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/sts.png"
            alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
            <p>Perubahan</p>
          </a>
        </li> --}}
        <li class="nav-item">
          <a href="{{ route('lap_ang_kas.index') }}" class="nav-link">
            <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
            alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
            <p>Anggaran Kas</p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item {{ in_array(Request::segment(1), ['penerimaan_sts', 'bku-show', 'lap_sppd', 'spj_pdf', 'lap_oto']) ? 'menu-open' : '' }}">
      <a href="#" class="nav-link">
        <img src="{{ asset('template') }}/dist/img/icon_menu/anggaran/definitif.png"
        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
        <p>Penatausahaan</p>
        <i class="right fas fa-angle-left"></i>
      </a>
      <ul class="nav nav-treeview">
        <li
        class="nav-item {{ in_array(Request::segment(1), ['penerimaan_sts', 'bku-show']) ? 'menu-open' : '' }}">
        <a href="{{ route('lapman.pdf.pilih') }}" class="nav-link">
          <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/realisasi.png"
          alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
          <p>Transaksi</p>
          <i class="right fas fa-angle-left"></i>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('penerimaan_sts') }}"
            class="nav-link {{ Request::segment(1) == 'penerimaan_sts' ? 'active' : '' }}">
            <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
            alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
            <p>Pendapatan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('bku.show') }}"
          class="nav-link {{ Request::segment(1) == 'bku-show' ? 'active' : '' }}">
          <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
          alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
          <p>Belanja</p>
        </a>
      </li>
    </ul>
  </li>
  <li
  class="nav-item {{ in_array(Request::segment(1), ['lap_sppd', 'spj_pdf']) ? 'menu-open' : '' }}">
  <a href="{{ route('lapman.pdf.pilih') }}" class="nav-link">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/realisasi.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Pengajuan</p>
    <i class="right fas fa-angle-left"></i>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('lap_sppd.index') }}"
      class="nav-link {{ Request::segment(1) == 'lap_sppd' ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>S-PPD</p>
    </a>
  </li>
  {{-- <li class="nav-item">
    <a href=""
    class="nav-link {{ Request::segment(1) == 'spj_pdf' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>SPJ</p>
  </a>
</li> --}}
</ul>
</li>
<li class="nav-item">
  <a href="{{ route('lap_oto') }}" class="nav-link {{ Request::segment(1) == 'lap_oto' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/sts.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Otorisasi</p>
  </a>
</li>
</ul>
</li>
<li class="nav-item {{ in_array(Request::segment(1), ['lapkeu-pdf','lapkeu', 'lapman', 'lapregPiutang', 'lapjurnal','lapbb','lapbb_sub','lapbb_subrinci','lapbb_rekap','bkublud','realisasipb','lapsoaw']) ? 'menu-open' : '' }}">
  <a href="#" class="nav-link">
    <img src="{{ asset('template') }}/dist/img/icon_menu/anggaran/definitif.png"
        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Pembukuan</p>
    <i class="right fas fa-angle-left"></i>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('lapkeu.index') }}"
      class="nav-link {{ Request::segment(1) == 'lapkeu' ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Laporan Keuangan</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('lapjurnal.index') }}"
      class="nav-link {{ Request::segment(1) == 'lapjurnal' ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Daftar Jurnal</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('lapbb_rekap') }}"
      class="nav-link {{ in_array(Request::segment(1),['lapbb_rekap','lapbb_sub','lapbb_subrinci','lapbb']) ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Buku Besar</p>
      </a>
    </li>
    {{--
    <li class="nav-item">
      <a href="{{ route('lapman.index') }}"
      class="nav-link {{ Request::segment(1) == 'lapman' ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Laporan Lainnya</p>
      </a>
    </li>
    --}}

    {{-- 
    <li class="nav-item">
      <a href="{{ route('lapkeu.pdf.pilih') }}"
      class="nav-link {{ Request::segment(1) == 'lapkeu-pdf' ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Lapkeu</p>
      </a>
    </li>
    --}}
    
    <li class="nav-item">
      <a href="{{ route('lapregPiutang') }}"
      class="nav-link {{ in_array(Request::segment(1),['lapregPiutang','bkublud','lapsoaw','realisasipb']) ? 'active' : '' }}">
      <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/buktipenerimaan.png"
      alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
      <p>Manajemen</p>
      </a>
    </li>

  </ul>
  </li>
<li class="nav-item">
  <a href="{{ route('laporan.perencanaan.cetak-rka.index') }}"
	class="nav-link {{ in_array(Request::segment(1), ['rka1_pendapatan', 'rka2_belanja', 'rka3_terima_biaya', 'rka4_keluar_biaya']) ? 'active' : '' }}">
	<img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/realisasi.png"
	alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
	<p>Cetak RKA</p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ route('laporan.perencanaan.cetak-dpa.index') }}"
	class="nav-link {{ in_array(Request::segment(1), ['rka1_pendapatan', 'rka2_belanja', 'rka3_terima_biaya', 'rka4_keluar_biaya']) ? 'active' : '' }}">
	<img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/sts.png"
	alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
	<p>Cetak DPA</p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ route('laporan.pembukuan.cetak-lapkeu.index') }}"
	class="nav-link {{ in_array(Request::segment(1), ['rka1_pendapatan', 'rka2_belanja', 'rka3_terima_biaya', 'rka4_keluar_biaya']) ? 'active' : '' }}">
	<img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/sts.png"
	alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
	<p>Cetak Pembukuan</p>
  </a>
</li>
</ul>

</li>
@endif
@if (in_array(getUser('user_level'), ['1']))
{{-- setting --}}
<li
class="nav-item {{ in_array(Request::segment(1), ['rekanan','pemda','unit', 'unitsub', 'unitsub1', 'rekening', 'rek', 'jnslayanan','bank','pegawai','user'])? 'menu-open': '' }}">
<a href="#" class="nav-link">
  <img src="{{ asset('template') }}/dist/img/icon_menu/setting/settings.png" alt="Product 1"
  class="nav-icon img-circle img-size-32 mr-1">
  <p>
    Setting
    <i class="fas fa-angle-left right"></i>
  </p>
</a>
<ul class="nav nav-treeview">
  <li class="nav-item">
    <a href="{{ route('pemda.index') }}"
    class="nav-link {{ Request::segment(1) == 'pemda' ? 'active' : '' }}">
    <img src="{{ asset('template') }}/dist/img/icon_menu/setting/pemda.png"
    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
    <p>Pemda</p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ route('unit.index') }}"
  class="nav-link {{ in_array(Request::segment(1), ['unit', 'unitsub', 'unitsub1']) ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/setting/unit.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Unit/BLUD/Bidang</p>
</a>
</li>
{{-- 
<li class="nav-item">
  <a href="{{ route('setkegiatan.index') }}"
  class="nav-link {{ in_array(Request::segment(1), ['setkegiatan', 'setkegs1', 'setkegs2']) ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/setting/program.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Program/Kegiatan BLU</p>
</a>
</li>
--}}
<li class="nav-item">
  <a href="{{ route('rekening.index') }}"
  class="nav-link {{ in_array(Request::segment(1), ['rekening', 'rek']) ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/setting/rekening.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Rekening</p>
</a>
</li>
{{-- hide jenis layanan 
<li class="nav-item">
  <a href="{{ route('jnslayanan.index') }}"
  class="nav-link {{ Request::segment(1) == 'jnslayanan' ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/setting/jenislayanan.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Jenis Layanan</p>
</a>
</li>
hide jenis layanan --}}
<li class="nav-item">
  <a href="{{ route('rekanan.index') }}"
  class="nav-link {{ Request::segment(1) == 'rekanan' ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/setting/pemda.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Rekanan</p>
</a>
</li>
<li class="nav-item">
  <a href="{{ route('bank.index') }}"
  class="nav-link {{ Request::segment(1) == 'bank' ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/setting/bank.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Bank</p>
</a>
</li>
<li class="nav-item">
  <a href="{{ route('pegawai.index') }}"
  class="nav-link {{ Request::segment(1) == 'pegawai' ? 'active' : '' }}">
  <img src="{{ asset('template') }}/dist/img/icon_menu/setting/pegawai.png"
  alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
  <p>Pegawai</p>
</a>
</li>
<li class="nav-item">
  <a href="{{ route('user.index') }}"
  class="nav-link {{ Request::segment(1) == 'user' ? 'active' : '' }}">
  <i class="far fa-user nav-icon"></i>
  <p>User</p>
</a>
</li>
</ul>
@endif
<li class="nav-header devider"></li>

<li class="nav-item">
  <a href="{{ route('tutorial') }}" class="nav-link {{ Request::segment(1) == 'tutorial' ? 'active' : '' }}">
    <i class="nav-icon fas fa-file-alt"></i>
  <p>Tutorial</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('about') }}" class="nav-link {{ Request::segment(1) == 'about' ? 'active' : '' }}">
    <i class="nav-icon fas fa-users"></i>
  <p>Tentang Kami</p>
  </a>
</li>

<!-- end -->
</li>
</ul>
</nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
