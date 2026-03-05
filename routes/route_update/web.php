<?php

use App\Http\Controllers\About\AboutController;
use App\Http\Controllers\About\SaranController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Setting\ManajemenUser\MasterUserController;
use App\Http\Controllers\Setting\ManajemenPemda\MasterPemdaController;
use App\Http\Controllers\Setting\ManajemenRekening\MasterRekeningController;
use App\Http\Controllers\Setting\ManajemenUnit\UnitOrganisasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardManajemenController;
use App\Http\Controllers\Perencanaan\KegiatanController;
use App\Http\Controllers\Perencanaan\AkunController;
use App\Http\Controllers\Perencanaan\RincianAkunController;
use App\Http\Controllers\Perencanaan\RbaController;
use App\Http\Controllers\Definitif\Penetapan\PenetapanController;
use App\Http\Controllers\Definitif\Spd\SpdController;
use App\Http\Controllers\Definitif\Spd\SpdrinciController;

use App\Http\Controllers\Transaksi\Penerimaan\Blu\PenerimaanBluController;
use App\Http\Controllers\Transaksi\Penerimaan\Blu\SubPenerimaanBluController;
use App\Http\Controllers\Transaksi\Penerimaan\Realisasi\RealisasiController;
use App\Http\Controllers\Transaksi\Penerimaan\Realisasi\SubRealisasiController;
use App\Http\Controllers\Transaksi\Penerimaan\Realisasi\RealisasipddController;
use App\Http\Controllers\Transaksi\Penerimaan\Realisasi\RealisasitlController;
use App\Http\Controllers\Transaksi\Penerimaan\STS\StsnewController;
use App\Http\Controllers\Transaksi\Penerimaan\STS\StsrcController;
// use App\Http\Controllers\Transaksi\Penerimaan\Sts\StsController;
// use App\Http\Controllers\Transaksi\Penerimaan\Sts\SubStsController;
use App\Http\Controllers\Transaksi\Belanja\Apbd\ApbdController;
use App\Http\Controllers\Transaksi\Belanja\Apbd\SubApbdController;
use App\Http\Controllers\Transaksi\Belanja\Kontrak\KontrakController;
use App\Http\Controllers\Transaksi\Belanja\Kontrak\SubKontrakController;
use App\Http\Controllers\Transaksi\Belanja\Tagihan\TagihanController;
use App\Http\Controllers\Transaksi\Belanja\Tagihan\SubTagihanController;
use App\Http\Controllers\Transaksi\Belanja\Tagihan\TagihanLaluController;
use App\Http\Controllers\Transaksi\Belanja\Pembayaran\PembayaranController;
use App\Http\Controllers\Transaksi\Belanja\Pembayaran\SubPembayaranController;
use App\Http\Controllers\Transaksi\Belanja\Kuitansi\KuitansiController;
use App\Http\Controllers\Transaksi\Belanja\Kuitansi\SubKuitansiController;
use App\Http\Controllers\Transaksi\Belanja\Pajak\PajakController;
use App\Http\Controllers\Transaksi\Belanja\Pajak\SubPajakController;
use App\Http\Controllers\Transaksi\Belanja\Termin\TerminController;
use App\Http\Controllers\Transaksi\Belanja\Termin\SubTerminController;
use App\Http\Controllers\Transaksi\Belanja\Panjar\PanjarController;
use App\Http\Controllers\Transaksi\Belanja\Panjar\PanjarRinciController;
use App\Http\Controllers\Transaksi\Pembiayaan\PembiayaanController;
use App\Http\Controllers\Transaksi\Pembiayaan\PembiayaanrinciController;
use App\Http\Controllers\Transaksi\Penyetoran\SisaUpController;
use App\Http\Controllers\Transaksi\Penyetoran\SisaPanjarController;
use App\Http\Controllers\Transaksi\Titipan\TitipanController;
use App\Http\Controllers\Transaksi\Titipan\TitipanrinciController;
use App\Http\Controllers\Transaksi\TransaksiController;
use App\Http\Controllers\Pengajuan\Kasawal\KasawalController;
use App\Http\Controllers\Pengajuan\Lsnonkontrak\LsnonkontrakController;
use App\Http\Controllers\Pengajuan\Lsnonkontrak\LsnonkontrakutangController;
use App\Http\Controllers\Pengajuan\Lskontrak\LskontrakController;
use App\Http\Controllers\Pengajuan\SpjGu\SpjGuController;
use App\Http\Controllers\Pengajuan\SpjGu\SpjguUtangController;
use App\Http\Controllers\Pengajuan\SpjNihil\SpjNihilController;
use App\Http\Controllers\Pengajuan\SppPanjar\SppPanjarController;
use App\Http\Controllers\Pengajuan\SppPanjar\SppPanjarRinciController;
use App\Http\Controllers\Pengajuan\SppNihilPanjar\SppNihilPanjarController;
use App\Http\Controllers\Pengajuan\SppNihilPanjar\SppNihilPanjarRinciController;
use App\Http\Controllers\Pengajuan\SpjPendapatan\SpjPendapatanController;
use App\Http\Controllers\Pengajuan\Verifikasi\VerifikasiController;
use App\Http\Controllers\Otorisasi\OtorisasiController;
use App\Http\Controllers\Pengesahan\PengesahanController;
use App\Http\Controllers\Pengesahan\Sp2bController;

use App\Http\Controllers\Pembukuan\SpmController;
use App\Http\Controllers\Pembukuan\KoreksiController;
use App\Http\Controllers\Pembukuan\MutasikasbankController;
use App\Http\Controllers\Pembukuan\PenyesuaianController;
use App\Http\Controllers\Pembukuan\PenyesuaianrinciController;
use App\Http\Controllers\Pembukuan\Saldoawal\SoawController;
use App\Http\Controllers\Pembukuan\Saldoawal\SopiutController;
use App\Http\Controllers\Pembukuan\Saldoawal\SoutaController;
use App\Http\Controllers\Pembukuan\RebuildController;
use App\Http\Controllers\Pembukuan\SetorPajakController;

use App\Http\Controllers\Setting\Pemda\PemdaController;
use App\Http\Controllers\Setting\Unit\UnitController;
use App\Http\Controllers\Setting\Unit\UnitSubController;
use App\Http\Controllers\Setting\Unit\UnitSub1Controller;
use App\Http\Controllers\Setting\Jnslayanan\JnslayananController;
use App\Http\Controllers\Setting\Bank\BankController;
use App\Http\Controllers\Setting\Rekening\RekeningController;
use App\Http\Controllers\Setting\Kegiatan\SetKegiatanController;
use App\Http\Controllers\Setting\Kegiatan\SetKegBlu1Controller;
use App\Http\Controllers\Setting\Kegiatan\SetKegBlu2Controller;
use App\Http\Controllers\Setting\Pegawai\PegawaiController;
use App\Http\Controllers\Setting\Rekanan\RekananController;

use App\Http\Controllers\Laporan\Perencanaan\RencanaBApendapatanController;
use App\Http\Controllers\Laporan\Perencanaan\RkaController;
use App\Http\Controllers\Laporan\Perencanaan\DPAController;
use App\Http\Controllers\Laporan\Perencanaan\LapAngKasController;
use App\Http\Controllers\Laporan\Perencanaan\CetakLaporanRKAController;
use App\Http\Controllers\Laporan\Perencanaan\CetakLaporanDPAController;
use App\Http\Controllers\Laporan\Perencanaan\PDFRbaController;
use App\Http\Controllers\Laporan\Perencanaan\PDFDbaController;
use App\Http\Controllers\Laporan\Penatausahaan\PDFBelanjaController;
use App\Http\Controllers\Laporan\Penatausahaan\PDFSpmController;
use App\Http\Controllers\Laporan\Penatausahaan\PDFSppController;
use App\Http\Controllers\Laporan\Penatausahaan\SppdController;
use App\Http\Controllers\Laporan\Penatausahaan\PendapatanController;
use App\Http\Controllers\Laporan\Penatausahaan\PenerimaanController;
use App\Http\Controllers\Laporan\Penatausahaan\PengeluaranController;
use App\Http\Controllers\Laporan\Penatausahaan\CetakLaporanPenerimaanController;
use App\Http\Controllers\Laporan\Penatausahaan\CetakLaporanPengeluaranController;
use App\Http\Controllers\Laporan\Pembukuan\LapbbController;
use App\Http\Controllers\Laporan\Pembukuan\PDFLapkeuController;
use App\Http\Controllers\Laporan\Pembukuan\PDFLapManajemenController;
use App\Http\Controllers\Laporan\Pembukuan\LapjurnalController;
use App\Http\Controllers\Laporan\Pembukuan\CetakLaporanPembukuanController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     session([ 'Ko_Period' => '2022' ]);
//     session([ 'ko_unit1' => '32.03.01.02.01.001.001' ]);
//     session([ 'Ko_unitstr' => '32.03.01.02.01.001' ]);
//     return view('home');
// });
Route::get('/', [AuthController::class, 'show'])->name('auth');
Route::any('authlogin', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('tutorial', [AboutController::class, 'tutorial'])->name('tutorial');
Route::get('about', [AboutController::class, 'about'])->name('about');
Route::get('saran', [AboutController::class, 'saran'])->name('saran');

Route::group(['middleware' => ['auth', 'akses: 1,2,3,4,5,6,7,8,9,10,98,99']], function () {
	
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboardmanajemen', [DashboardManajemenController::class, 'index'])->name('dashboardmanajemen');


    // saran/kegiatan
    Route::resource('saran', SaranController::class);

    //home
    Route::get('home', [AuthController::class, 'home'])->name('home');

    //rba
    Route::resource('rba', RbaController::class);

    Route::resource('kegiatan', KegiatanController::class);
    Route::get('kegiatan/program/{id}', [KegiatanController::class, 'program'])->name('program');
    Route::get('kegiatan/program/subkegiatan/{id1}-{id2}', [KegiatanController::class, 'subkegiatan'])->name('subkgit egiatan');
    Route::get('kegiatan/program/subkegiatan/akun/{id1}-{id2}-{id3}', [AkunController::class, 'akun'])->name('akun');
    // Route::get('akun/{id1}-{id2}-{id3}', [AkunController::class, 'akun'])->name('akun');
    // Route::get('kegiatan/program/subkegiatan/akun/{id1}/{id2}/{id3}', [AkunController::class, 'akun'])->name('akun');
    Route::resource('akun', AkunController::class);
    Route::get('kegiatan/program/subkegiatan/akun/rincian/{id1}-{id2}-{id3}', [RincianAkunController::class, 'r_akun'])->name('r_akun');
    Route::resource('r_akun', RincianAkunController::class);

    // definitif
    Route::resource('penetapan', PenetapanController::class);
    Route::resource('spd', SpdController::class);
    Route::get('spd-rinci/{id}/pilih', [SpdrinciController::class, 'pilih'])->name('spd-rinci.pilih');
    Route::get('spd-rinci/{id}/tambah', [SpdrinciController::class, 'tambah'])->name('spd-rinci.tambah');
    Route::resource('spd-rinci', SpdrinciController::class);
    Route::post('get-tap', [SpdrinciController::class, 'getTap'])->name('spd-rinci.getTap');

    // Route::resource('perencanaan', PerencanaanController::class);

    // Bukti Transaksi
    Route::resource('penerimaan', PenerimaanBluController::class);
    Route::resource('subpenerimaan', SubPenerimaanBluController::class);
    Route::resource('realisasi', RealisasiController::class);
    Route::resource('subrealisasi', SubRealisasiController::class);
    Route::resource('realisasipdd', RealisasipddController::class);
    Route::resource('realisasitl', RealisasitlController::class);

    // Bukti Transaksi Pendapatan Bulan
    Route::get('penerimaan/bulan/{id}', [PenerimaanBluController::class, 'v_bulan'])->name('penerimaan.bulan');
    Route::get('realisasi/bulan/{id}', [RealisasiController::class, 'v_bulan'])->name('realisasi.bulan');
    Route::get('realisasipdd/bulan/{id}', [RealisasipddController::class, 'v_bulan'])->name('realisasipdd.bulan');
    Route::get('realisasitl/bulan/{id}', [RealisasitlController::class, 'v_bulan'])->name('realisasitl.bulan');
    Route::get('sts/bulan/{id}', [StsnewController::class, 'v_bulan'])->name('sts.bulan');

    // Route::resource('sts', StsController::class);
    // Route::resource('sts', SubStsController::class);
    Route::resource('apbd', ApbdController::class);
    Route::resource('subapbd', SubApbdController::class);
    Route::resource('tagihan', TagihanController::class);
    Route::resource('tagihanlalu', TagihanLaluController::class);
    Route::resource('subtagihan', SubTagihanController::class);
    Route::resource('kontrak', KontrakController::class);
    Route::resource('subkontrak', SubKontrakController::class);
    Route::resource('kuitansi', KuitansiController::class);
    Route::resource('subkuitansi', SubKuitansiController::class);
    Route::resource('pajak', PajakController::class);
    Route::get('pajakrinci/{id}', [PajakController::class, 'show'])->name('pajakrinci');
    // Route::resource('subpajak', SubPajakController::class);
    Route::resource('termin', TerminController::class);
    Route::resource('subtermin', SubTerminController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('subpembayaran', SubPembayaranController::class);
    Route::resource('pembiayaan', PenerimaanController::class);
    // Route::resource('subpembiayaan', SubPenerimaanController::class);
    Route::resource('pengeluaran', PengeluaranController::class);
    // Route::resource('subpengeluaran', SubPengeluaranController::class);
    Route::resource('sisaup', SisaUpController::class);
    Route::resource('sisapanjar', SisaPanjarController::class);
    Route::resource('transaksi', TransaksiController::class);

    // Bukti Transaksi Belanja Bulan
    Route::get('tagihan/bulan/{id}', [TagihanController::class, 'v_bulan'])->name('tagihan.bulan');
    Route::get('tagihanlalu/bulan/{id}', [TagihanLaluController::class, 'v_bulan'])->name('tagihanlalu.bulan');
    Route::get('kontrak/bulan/{id}', [KontrakController::class, 'v_bulan'])->name('kontrak.bulan');
    Route::get('termin/bulan/{id}', [TerminController::class, 'v_bulan'])->name('termin.bulan');
    Route::get('apbd/bulan/{id}', [ApbdController::class, 'v_bulan'])->name('apbd.bulan');
    Route::get('kuitansi/bulan/{id}', [KuitansiController::class, 'v_bulan'])->name('kuitansi.bulan');
    Route::get('pembayaran/bulan/{id}', [PembayaranController::class, 'v_bulan'])->name('pembayaran.bulan');

    //tagihan tahun lalu
    Route::get('tagihanlalu/rincian/{id}', [TagihanLaluController::class, 'rincian'])->name('tagihanlalu.rincian');
    Route::delete('tagihanlalu/hapus/{id}', [TagihanLaluController::class, 'hapus'])->name('tagihanlaluhapus.rincian');

    //Potong Pajak Tagihan Tahun Lalu
    Route::get('tagihanlalu/pajak/{id}', [TagihanLaluController::class, 'pajak'])->name('tagihanlalu.pajak');
    Route::post('tagihanlalu/potongpajak', [TagihanLaluController::class, 'potongpajak'])->name('tagihanlalu.potongpajak');
    Route::put('tagihanlalu/editpotongpajak/{id}', [TagihanLaluController::class, 'editpotongpajak'])->name('tagihanlalu.editpotongpajak');
    Route::delete('tagihanlalu/destroyPajak/{id}', [TagihanLaluController::class, 'destroyPajak'])->name('tagihanlalu.destroyPajak');

    //Potong Pajak Tagihan
    Route::get('tagihan/pajak/{id}', [TagihanController::class, 'pajak'])->name('tagihan.pajak');
    Route::post('tagihan/potongpajak', [TagihanController::class, 'potongpajak'])->name('tagihan.potongpajak');
    Route::put('tagihan/editpotongpajak/{id}', [TagihanController::class, 'editpotongpajak'])->name('tagihan.editpotongpajak');
    Route::delete('tagihan/destroyPajak/{id}', [TagihanController::class, 'destroyPajak'])->name('tagihan.destroyPajak');

    //Potong Pajak Termin
    Route::get('termin/pajak/{id}', [TerminController::class, 'pajak'])->name('termin.pajak');
    Route::post('termin/potongpajak', [TerminController::class, 'potongpajak'])->name('termin.potongpajak');
    Route::put('termin/editpotongpajak/{id}', [TerminController::class, 'editpotongpajak'])->name('termin.editpotongpajak');
    Route::delete('termin/destroyPajak/{id}', [TerminController::class, 'destroyPajak'])->name('termin.destroyPajak');

    //Potong Pajak Kuitansi
    Route::get('kuitansi/pajak/{id}', [KuitansiController::class, 'pajak'])->name('kuitansi.pajak');
    Route::post('kuitansi/potongpajak', [KuitansiController::class, 'potongpajak'])->name('kuitansi.potongpajak');
    Route::put('kuitansi/editpotongpajak/{id}', [KuitansiController::class, 'editpotongpajak'])->name('kuitansi.editpotongpajak');
    Route::delete('kuitansi/destroyPajak/{id}', [KuitansiController::class, 'destroyPajak'])->name('kuitansi.destroyPajak');

    //Potong Pajak Panjar
    Route::get('panjar/pajak/{id}', [PanjarController::class, 'pajak'])->name('panjar.pajak');
    Route::post('panjar/potongpajak', [PanjarController::class, 'potongpajak'])->name('panjar.potongpajak');
    Route::put('panjar/editpotongpajak/{id}', [PanjarController::class, 'editpotongpajak'])->name('panjar.editpotongpajak');
    Route::delete('panjar/destroyPajak/{id}', [PanjarController::class, 'destroyPajak'])->name('panjar.destroyPajak');

    //Realisasi-Setor Pajak
    Route::resource('setorpajak', SetorPajakController::class);
    Route::get('setorpajak/tambah/{id}-{id2}', [SetorPajakController::class, 'create_detail'])->name('setorpajak.tambah');
    Route::post('setorpajak/store_detail', [SetorPajakController::class, 'store_detail'])->name('setorpajak.store_detail');
    Route::delete('setorpajak/destroy_detail/{id}', [SetorPajakController::class, 'destroy_detail'])->name('setorpajak.destroy_detail');
    Route::get('setorpajak/listdetail/{id}', [SetorPajakController::class, 'listdetail'])->name('setorpajak.listdetail');
    Route::get('setorpajak/create_setor/{id}', [SetorPajakController::class, 'create_setor'])->name('setorpajak.create_setor');

    //Transaksi-Penerimaan
    Route::get('subpenerimaan/rincian/{id}', [SubPenerimaanBluController::class, 'rincian'])->name('subpenerimaan.rincian');
    Route::get('subpenerimaan/tambah/{id}', [SubPenerimaanBluController::class, 'tambah'])->name('subpenerimaan.tambah');
    Route::get('subpenerimaan/tambahtl/{id}', [SubPenerimaanBluController::class, 'tambahtl'])->name('subpenerimaan.tambahtl');

    //Transaksi-Belanja-Tagihan
    Route::get('subtagihan/rincian/{id}', [SubTagihanController::class, 'rincian'])->name('subtagihan.rincian');
    Route::get('subtagihan/tambah/{id}', [SubTagihanController::class, 'tambah'])->name('subtagihan.tambah');

    //Transaksi-Belanja-Kontrak
    Route::get('subkontrak/rincian/{id}', [SubKontrakController::class, 'rincian'])->name('subkontrak.rincian');
    Route::get('subkontrak/tambah/{id}', [SubKontrakController::class, 'tambah'])->name('subkontrak.tambah');

    //Transaksi-Belanja-Termin
    Route::get('subtermin/rincian/{id}', [SubTerminController::class, 'rincian'])->name('subtermin.rincian');
    Route::get('subtermin/tambah/{id}', [SubTerminController::class, 'tambah'])->name('subtermin.tambah');

    //Transaksi-Belanja-APBD
    Route::get('subapbd/rincian/{id}', [SubApbdController::class, 'rincian'])->name('subapbd.rincian');
    Route::get('subapbd/tambah/{id}', [SubApbdController::class, 'tambah'])->name('subapbd.tambah');

    //Transaksi-Kwitansi
    Route::get('subkuitansi/rincian/{id}', [SubKuitansiController::class, 'rincian'])->name('subkuitansi.rincian');
    Route::get('subkuitansi/tambah/{id}', [SubKuitansiController::class, 'tambah'])->name('subkuitansi.tambah');

    //Transaksi-Realisasi
    Route::get('realisasi/rincian/{id}', [RealisasiController::class, 'rincian'])->name('realisasi.rincian');
    Route::get('realisasi/tambah/{id}', [RealisasiController::class, 'tambah'])->name('realisasi.tambah');
    // Route::put('realisasi/update/{id}', [RealisasiController::class, 'update'])->name('realisasi.update');
	Route::get('tbp_pdf/{id}', [RealisasiController::class, 'tbp_pdf'])->name('tbp_pdf');
    Route::post('realisasi/store_rinci', [RealisasiController::class, 'store_rinci'])->name('realisasi.store_rinci');
    Route::get('realisasipdd/tambah/{id}', [RealisasipddController::class, 'tambah'])->name('realisasipdd.tambah');
    Route::post('realisasipdd/store_rinci', [RealisasipddController::class, 'store_rinci'])->name('realisasipdd.store_rinci');
    Route::get('realisasitl/tambah/{id}', [RealisasitlController::class, 'tambah'])->name('realisasitl.tambah');
    Route::post('realisasitl/store_rinci', [RealisasitlController::class, 'store_rinci'])->name('realisasitl.store_rinci');

    //Transaksi-Pembayaran
    Route::get('pembayaran/rincian/{id}', [PembayaranController::class, 'rincian'])->name('pembayaran.rincian');
    Route::get('pembayaran/tambah/{id}', [PembayaranController::class, 'tambah'])->name('pembayaran.tambah');

    // Transaksi-Belanja-Panjar
    Route::resource('panjar', PanjarController::class);
    Route::get('panjar-rinci/{id}/pilih', [PanjarRinciController::class, 'pilih'])->name('panjar-rinci.pilih');
    Route::get('panjar-rinci/{id}/tambah', [PanjarRinciController::class, 'tambah'])->name('panjar-rinci.tambah');
    Route::resource('panjar-rinci', PanjarRinciController::class);
    Route::get('panjar.cetak/{id}', [PanjarController::class, 'cetak'])->name('panjar.cetak');

    //Pengajuan
    Route::resource('kasawal', KasawalController::class);
    Route::resource('lsnonkontrak', LsnonkontrakController::class);
    Route::resource('lsnonkontrakutang', LsnonkontrakutangController::class);
    Route::resource('lskontrak', LskontrakController::class);
    Route::resource('spjgu', SpjGuController::class);
    Route::resource('spjguutang', SpjguUtangController::class);
    Route::resource('spppanjar', SppPanjarController::class);
    Route::resource('spjnihil', SpjNihilController::class);
    Route::resource('sppnihilpanjar', SppNihilPanjarController::class);
    Route::resource('spjpendapatan', SpjPendapatanController::class);
    route::resource('verifikasi', VerifikasiController::class);
    Route::post('verifikasi/batal/{id}', [VerifikasiController::class, 'batal'])->name('verifikasi.batal');
    Route::post('otorisasi/batal/{id}', [OtorisasiController::class, 'batal'])->name('otorisasi.batal');
	

    // Pengajuan Bulan
    Route::get('lsnonkontrak/bulan/{id}', [LsnonkontrakController::class, 'v_bulan'])->name('lsnonkontrak.bulan');
    Route::get('spjgu/bulan/{id}', [SpjGuController::class, 'v_bulan'])->name('spjgu.bulan');
    Route::get('verifikasi/bulan/{id}', [VerifikasiController::class, 'v_bulan'])->name('verifikasi.bulan');

    //cetak verifikasi
    Route::get('verifikasi/cetak_ksppd/{id}', [VerifikasiController::class, 'cetak_ksppd'])->name('verifikasi.cetak_ksppd');
    Route::get('verifikasi/cetak_sptjb/{id}', [VerifikasiController::class, 'cetak_sptjb'])->name('verifikasi.cetak_sptjb');
    Route::get('verifikasi/cetak_sptjverif/{id}', [VerifikasiController::class, 'cetak_sptjverif'])->name('verifikasi.cetak_sptjverif');

    //verifikasi pengajuan
    Route::post('kasawal/verifikasi/{id}', [KasawalController::class, 'verifikasi'])->name('kasawal.verifikasi');
    Route::post('lsnonkontrak/verifikasi/{id}', [LsnonkontrakController::class, 'verifikasi'])->name('lsnonkontrak.verifikasi');
    Route::post('lsnonkontrakutang/verifikasi/{id}', [LsnonkontrakutangController::class, 'verifikasi'])->name('lsnonkontrakutang.verifikasi');
    Route::post('lskontrak/verifikasi/{id}', [LskontrakController::class, 'verifikasi'])->name('lskontrak.verifikasi');
    Route::post('spjgu/verifikasi/{id}', [SpjGuController::class, 'verifikasi'])->name('spjguutang.verifikasi');
    Route::post('spjguutang/verifikasi/{id}', [SpjguUtangController::class, 'verifikasi'])->name('spjgu.verifikasi');
    Route::post('spppanjar/verifikasi/{id}', [SppPanjarController::class, 'verifikasi'])->name('spppanjar.verifikasi');
    Route::post('spjnihil/verifikasi/{id}', [SpjNihilController::class, 'verifikasi'])->name('spjnihil.verifikasi');
    Route::post('sppnihilpanjar/verifikasi/{id}', [SppNihilPanjarController::class, 'verifikasi'])->name('sppnihilpanjar.verifikasi');
    Route::post('spjpendapatan/verifikasi/{id}', [SpjPendapatanController::class, 'verifikasi'])->name('spjpendapatan.verifikasi');

    //history
    Route::get('lskontrak/history/{id}', [LskontrakController::class, 'history'])->name('lskontrak.history');

    //Pengajuan-Kasawal
    Route::get('kasawal/rincian/{id}', [KasawalController::class, 'rincian'])->name('kasawal.rincian');
    Route::get('kasawal/viewtambahrincian/{id}', [KasawalController::class, 'viewtambahrincian'])->name('kasawal.viewtambahrincian');
    Route::post('kasawal/tambahrincian', [KasawalController::class, 'tambahrincian'])->name('kasawal.tambahrincian');
    Route::delete('hapusrinciankasawal/{id}', [KasawalController::class, 'hapusrinciankasawal'])->name('hapusrinciankasawal');
    Route::get('edit/{id}', [KasawalController::class, 'edit'])->name('edit');
    Route::get('kas_awal/edit/{id}', [KasawalController::class, 'editkasawal'])->name('editkasawal');
    Route::put('kas_awal/update/{id}', [KasawalController::class, 'updatekasawal'])->name('updatekasawal');
	Route::get('kas_awal_pdf/{id}', [KasawalController::class, 'sppdup_pdf'])->name('sppdup_pdf');

    //Pengajuan-LsNonKontrak
    Route::get('lsnonkontrak/rincian/{id}', [LsnonkontrakController::class, 'rincian'])->name('lsnonkontrak.rincian');
    Route::get('lsnonkontrak/list_tagihan/{id}', [LsnonkontrakController::class, 'list_tagihan'])->name('lsnonkontrak.list_tagihan');
    Route::get('lsnonkontrak/viewtambahrincian/{id}', [LsnonkontrakController::class, 'viewtambahrincian'])->name('lsnonkontrak.viewtambahrincian');
    Route::post('lsnonkontrak/tambahrincian', [LsnonkontrakController::class, 'tambahrincian'])->name('lsnonkontrak.tambahrincian');
    Route::delete('lsnonkontrak/hapusrinciantagihan/{id}', [LsnonkontrakController::class, 'hapusrinciantagihan'])->name('lsnonkontrak.hapusrinciantagihan');
    Route::post('lsnonkontrak/hapusrincian', [LsnonkontrakController::class, 'hapusrincian'])->name('lsnonkontrak.hapusrincian');
    Route::get('lsnonkontrak_edit/{id}', [LsnonkontrakController::class, 'lsnonkontrakedit'])->name('lsnonkontrakedit');
    Route::put('lsnonkotrakupdate/{id}', [LsnonkontrakController::class, 'lsnonkotrakupdate'])->name('lsnonkotrakupdate');
	Route::get('lsnonkontrak_pdf/{id}', [LsnonkontrakController::class, 'sppdlsnon_pdf'])->name('sppdlsnon_pdf');

    //Pengajuan-LsNonKontrakUtang
    Route::get('lsnonkontrakutang/rincian/{id}', [LsnonkontrakutangController::class, 'rincian'])->name('lsnonkontrakutang.rincian');
    Route::get('lsnonkontrakutang/viewtambahrincian/{id}', [LsnonkontrakutangController::class, 'viewtambahrincian'])->name('lsnonkontrakutang.viewtambahrincian');
    Route::post('lsnonkontrakutang/tambahrincian', [LsnonkontrakutangController::class, 'tambahrincian'])->name('lsnonkontrakutang.tambahrincian');
    Route::delete('hapusrinciantagihanutang/{id}', [LsnonkontrakutangController::class, 'hapusrinciantagihanutang'])->name('hapusrinciantagihanutang');
    Route::get('lsnonkontrakutang_edit/{id}', [LsnonkontrakutangController::class, 'lsnonkontrakutangedit'])->name('lsnonkontrakutangedit');
    Route::put('lsnonkotrakutangupdate/{id}', [LsnonkontrakutangController::class, 'lsnonkotrakutangupdate'])->name('lsnonkotrakutangupdate');
	Route::get('lsnonkontrakutang_pdf/{id}', [LsnonkontrakutangController::class, 'sppdlsnonutang_pdf'])->name('sppdlsnonutang_pdf');

    //Pengajuan-Lskontrak
    Route::get('lskontrak/rincian/{id}', [LskontrakController::class, 'rincian'])->name('lskontrak.rincian');
    Route::get('lskontrak/list_tagihan/{id}', [LskontrakController::class, 'list_tagihan'])->name('lskontrak.list_tagihan');
    Route::get('lskontrak/viewtambahrincian/{id}', [LskontrakController::class, 'viewtambahrincian'])->name('lskontrak.viewtambahrincian');
    Route::post('lskontrak/tambahrincian', [LskontrakController::class, 'tambahrincian'])->name('lskontrak.tambahrincian');
    Route::delete('lskontrak/hapusrinciankontrak/{id}', [LskontrakController::class, 'hapusrinciankontrak'])->name('lskontrak.hapusrinciankontrak');
    Route::post('lskontrak/hapusrincian', [LskontrakController::class, 'hapusrincian'])->name('lskontrak.hapusrincian');
    Route::get('lskontrak_edit/{id}', [LskontrakController::class, 'lskontrakedit'])->name('lskontrakedit');
    Route::put('lskontrakupdate/{id}', [LskontrakController::class, 'lskontrakupdate'])->name('lskontrakupdate');
	Route::get('lskontrak_pdf/{id}', [LskontrakController::class, 'sppdls_pdf'])->name('sppdls_pdf');

    //Pengajuan-SPJGU
    Route::get('spjgu/rincian/{id}', [SpjGuController::class, 'rincian'])->name('spjgu.rincian');
    Route::get('spjgu/list_tagihan/{id}', [SpjGuController::class, 'list_tagihan'])->name('spjgu.list_tagihan');
    Route::get('spjgu/viewtambahrincian/{id}', [SpjGuController::class, 'viewtambahrincian'])->name('spjgu.viewtambahrincian');
    Route::post('spjgu/tambahrincian', [SpjGuController::class, 'tambahrincian'])->name('spjgu.tambahrincian');
    Route::delete('spjgu/hapusrincianspjgu/{id}', [SpjGuController::class, 'hapusrincianspjgu'])->name('spjgu.hapusrincianspjgu');
    Route::post('spjgu/hapusrincian', [SpjGuController::class, 'hapusrincian'])->name('spjgu.hapusrincian');
    Route::get('spjguedit/{id}', [SpjGuController::class, 'spjguedit'])->name('spjguedit');
    Route::put('spjgu_update/{id}', [SpjGuController::class, 'spjgu_update'])->name('spjgu_update');
	Route::get('spjgu_pdf/{id}', [SpjGuController::class, 'sppdgu_pdf'])->name('sppdgu_pdf');

    //Pengajuan-SPJGU Utang
    Route::get('spjguutang/rincian/{id}', [SpjguUtangController::class, 'rincian'])->name('spjguutang.rincian');
    Route::get('spjguutang/viewtambahrincian/{id}', [SpjguUtangController::class, 'viewtambahrincian'])->name('spjguutang.viewtambahrincian');
    Route::post('spjguutang/tambahrincian', [SpjguUtangController::class, 'tambahrincian'])->name('spjguutang.tambahrincian');
    Route::delete('hapusrincianspjguutang/{id}', [SpjguUtangController::class, 'hapusrincianspjgu'])->name('hapusrincianspjguutang');
    Route::get('spjguutangedit/{id}', [SpjguUtangController::class, 'spjguedit'])->name('spjguutangedit');
    Route::put('spjguutang_update/{id}', [SpjguUtangController::class, 'spjgu_update'])->name('spjguutang_update');

    //Pengajuan-SPJ Nihil
    Route::get('spjnihil/rincian/{id}', [SpjNihilController::class, 'rincian'])->name('spjnihil.rincian');
	Route::get('spjnihil/list_tagihan/{id}', [SpjNihilController::class, 'list_tagihan'])->name('spjnihil.list_tagihan');
    Route::get('spjnihil/viewtambahrincian/{id}', [SpjNihilController::class, 'viewtambahrincian'])->name('spjnihil.viewtambahrincian');
    Route::post('spjnihil/tambahrincian', [SpjNihilController::class, 'tambahrincian'])->name('spjnihil.tambahrincian');
    Route::delete('spjnihil/hapusrincianspjnihil/{id}', [SpjNihilController::class, 'hapusrincianspjnihil'])->name('spjnihil.hapusrincianspjnihil');
	Route::post('spjnihil/hapusrincian', [SpjNihilController::class, 'hapusrincian'])->name('spjnihil.hapusrincian');
    Route::get('spjnihiledit/{id}', [SpjNihilController::class, 'spjnihiledit'])->name('spjnihiledit');
    Route::put('spjnihilupdate/{id}', [SpjNihilController::class, 'spjnihilupdate'])->name('spjnihilupdate');
	Route::get('spjnihil_pdf/{id}', [SpjNihilController::class, 'sppdnihil_pdf'])->name('sppdnihil_pdf');

    Route::get('spppanjar-rinci/{id}/pilih', [SppPanjarRinciController::class, 'pilih'])->name('spppanjar-rinci.pilih');
    Route::get('spppanjar-rinci/{id}/tambah', [SppPanjarRinciController::class, 'tambah'])->name('spppanjar-rinci.tambah');
    Route::resource('spppanjar-rinci', SppPanjarRinciController::class);
    Route::get('spppanjar.cetak/{id}', [SppPanjarController::class, 'cetak'])->name('spppanjar.cetak');

    // Pengajuan - SPP Nihil Panjar
    Route::get('sppnihilpanjar-rinci/{id}/pilih', [SppNihilPanjarRinciController::class, 'pilih'])->name('sppnihilpanjar-rinci.pilih');
    Route::get('sppnihilpanjar-rinci/{id}/tambah', [SppNihilPanjarRinciController::class, 'tambah'])->name('sppnihilpanjar-rinci.tambah');
    Route::resource('sppnihilpanjar-rinci', SppNihilPanjarRinciController::class,);

    //Pengajuan-SPJ Pendapatan
    Route::get('spjpendapatan/rincian/{id}', [SpjPendapatanController::class, 'rincian'])->name('spjpendapatan.rincian');
    Route::get('spjpendapatan/viewtambahrincian/{id}', [SpjPendapatanController::class, 'viewtambahrincian'])->name('spjpendapatan.viewtambahrincian');
    Route::get('spjpendapatan/viewtambahrinciansts/{id}', [SpjPendapatanController::class, 'viewtambahrinciansts'])->name('spjpendapatan.viewtambahrinciansts');
    Route::post('spjpendapatan/tambahrincian', [SpjPendapatanController::class, 'tambahrincian'])->name('spjpendapatan.tambahrincian');
    Route::post('spjpendapatan/tambahrinciansts', [SpjPendapatanController::class, 'tambahrinciansts'])->name('spjpendapatan.tambahrinciansts');
    Route::delete('hapusrincianspjpendapatan/{id}', [SpjPendapatanController::class, 'hapusrincianspjpendapatan'])->name('hapusrincianspjpendapatan');
    Route::get('spjpendapatanedit/{id}', [SpjPendapatanController::class, 'spjpendapatanedit'])->name('spjpendapatanedit');
    Route::put('spjpendapatanupdate/{id}', [SpjPendapatanController::class, 'spjpendapatanupdate'])->name('spjpendapatanupdate');

    // Otorisasi
    Route::resource('otorisasi', OtorisasiController::class);
    Route::get("otorisasi_batal/{id}", [OtorisasiController::class, "bataloto"])->name("otorisasi_batal");
    Route::get("otorisasi_batal_nomor/{id}", [OtorisasiController::class, "batalnomor"])->name("otorisasi_batal_nomor");
    Route::get("penomoran", [OtorisasiController::class, "penomoran"])->name("penomoran");
    Route::get("penomoran_bernomor", [OtorisasiController::class, "bernomor"])->name("penomoran_bernomor");
    Route::put("penomoran_update/{id}", [OtorisasiController::class, "penomoran_update"])->name("penomoran_update");
    Route::delete("penomoran_hapus/{id}", [OtorisasiController::class, "penomoran_hapus"])->name("penomoran_hapus");
    
    // otorisasi bulan
    Route::get('penomoran_bernomor/bulan/{id}', [OtorisasiController::class, 'bernomor_bulan'])->name('penomoran_bernomor.bulan');
    Route::get("sopd_pdf/{id}", [OtorisasiController::class, "sopd_pdf"])->name("sopd_pdf");
    
    // Laporan - Penatausahaan - Otorisasi
    Route::get("lap_oto", [OtorisasiController::class, "lap_oto_index"])->name("lap_oto");
    Route::post("lap_oto_isi_spm", [OtorisasiController::class, "lap_oto_index_isi_spm"])->name("lap_oto_isi_spm");
    Route::get("lap_oto_cetak_spm", [OtorisasiController::class, "lap_oto_index_cetak_spm"])->name("lap_oto_cetak_spm");
    Route::post("lap_oto_isi_spd", [OtorisasiController::class, "lap_oto_index_isi_spd"])->name("lap_oto_isi_spd");
    Route::get("lap_oto_cetak_spd", [OtorisasiController::class, "lap_oto_index_cetak_spd"])->name("lap_oto_cetak_spd");
    
    Route::get("spd_pdf/{id_byro}", [OtorisasiController::class, "spd_pdf"])->name("spd_pdf");

    // Pengesahan
    Route::resource('pengesahan', PengesahanController::class);
    Route::put("sp3b_store", [PengesahanController::class, "sp3b_store"])->name("sp3b_store");
    Route::post("sp3b_rinci_store", [PengesahanController::class, "sp3b_rinci_store"])->name("sp3b_rinci_store");
    Route::delete("sp3b_rinci_destroy/{id}", [PengesahanController::class, "sp3b_rinci_destroy"])->name("sp3b_rinci_destroy");
    Route::post("sp3b_rinci_delete", [PengesahanController::class, "sp3b_rinci_delete"])->name("sp3b_rinci_delete");
    Route::get("sp3b_pdf/{id_sp3}", [PengesahanController::class, "sp3b_pdf"])->name("sp3b_pdf");
    Route::get("sp3b_pajak/{id}", [PengesahanController::class, "sp3b_pajak"])->name("sp3b_pajak");
    Route::get("sp3b_detail/{id}", [PengesahanController::class, "sp3b_detail"])->name("sp3b_detail");
    Route::get("sp3b_bbpajak/{id}", [PengesahanController::class, "sp3b_bbpajak"])->name("sp3b_bbpajak");
    Route::get("sp3b_rinci/{id}", [PengesahanController::class, "get_sp3b_rinci"])->name("sp3b_rinci");
    Route::get("sp3b_list", [PengesahanController::class, "get_sp3b_list"])->name("sp3b_list");

    Route::resource('sp2b', Sp2bController::class);

    // Setting
    Route::resource('pemda', PemdaController::class)->only(['index', 'edit', 'update']);
    Route::get("get-kabkota-list", [PemdaController::class, "GetKabkotaList"])->name("get_kabkota_list");

    Route::resource('unit', UnitController::class)->only(['index', 'edit', 'update']);
    Route::resource('unitsub', UnitSubController::class);
    Route::resource('unitsub1', UnitSub1Controller::class);
    Route::get('unitsub/delpemda/{id}', [UnitSubController::class, 'delpemda'])->name('unitsub.delpemda');
    Route::get('unitsub/delblud/{id}', [UnitSubController::class, 'delblud'])->name('unitsub.delblud');

    Route::resource('setkegiatan', SetKegiatanController::class);
    Route::resource('setkegs1', SetKegBlu1Controller::class);
    Route::resource('setkegs2', SetKegBlu2Controller::class);

    Route::resource('rekening', RekeningController::class)->only('index');
    Route::get("rek", [RekeningController::class, "rek"])->name("rek");

    Route::get('rekening1', [RekeningController::class, 'rekening1'])->name('rekening1');
    Route::get('rekening2', [RekeningController::class, 'rekening2'])->name('rekening2.show');
    Route::get('rekening3', [RekeningController::class, 'rekening3'])->name('rekening3.show');
    Route::get('rekening4', [RekeningController::class, 'rekening4'])->name('rekening4.show');
    Route::get('rekening5', [RekeningController::class, 'rekening5'])->name('rekening5.show');
    Route::get('rekening6', [RekeningController::class, 'rekening6'])->name('rekening6.show');


    Route::resource('rekanan', RekananController::class);

    Route::resource('jnslayanan', JnslayananController::class);
    Route::resource('bank', BankController::class);

    Route::resource('pegawai', PegawaiController::class);

    Route::resource('user', UserController::class);
    Route::put('user_change/{id}', [UserController::class, 'change'])->name('user_change');

    // Pembukuan
    Route::resource('penyesuaian', PenyesuaianController::class);
    Route::get('/penyesuaian-detail/{id}', [PenyesuaianController::class, 'penyesuaiandetail'])->name('penyesuaian.detail');
    Route::get('/penyesuaian-getRekening', [PenyesuaianController::class, 'getRekening'])->name('penyesuaian.getRekening');
    Route::get('/penyesuaian-getTransaksi', [PenyesuaianController::class, 'getTransaksi'])->name('penyesuaian.getTransaksi');
    Route::resource('koreksi', KoreksiController::class);
    Route::match(['post', 'get'], '/rebuild', [RebuildController::class, 'index'])->name('rebuild.index');
    //Route::post('rebuild', [RebuildController::class, 'index'])->name('rebuild.index');
    Route::post('process_rebuild', [RebuildController::class, 'process'])->name('rebuild.process');

    Route::resource('penyesuaian_rinci', PenyesuaianrinciController::class);

    Route::get('/sts-detail/{st}', [StsnewController::class, 'stsdetail'])->name('sts.detail');
    Route::resource('sts', StsnewController::class);
    Route::resource('stsrinci', StsrcController::class);
    Route::get('sts_pdf/{id_sts}', [StsnewController::class, 'sts_pdf'])->name('sts_pdf');

    //saldo awal
    Route::get('saldoawal/{id}/pilih', [SoawController::class, 'pilih'])->name('saldoawal.pilih');
    Route::get('saldoawal/lo', [SoawController::class, 'lo'])->name('saldoawal.lo');
    Route::get('saldoawal/lra', [SoawController::class, 'lra'])->name('saldoawal.lra');
    Route::get('saldoawal/lpsal', [SoawController::class, 'lpsal'])->name('saldoawal.lpsal');
    Route::get('saldoawal/lpe', [SoawController::class, 'lpe'])->name('saldoawal.lpe');
    Route::resource('saldoawal', SoawController::class)->except('edit');
    Route::post('saldoawal/lpsal-store', [SoawController::class, 'store_lpsal'])->name('saldoawal.store_lpsal');
    Route::post('saldoawal/lpe-store', [SoawController::class, 'store_lpe'])->name('saldoawal.store_lpe');
    Route::delete('saldoawal/lpsal-delete/{id}', [SoawController::class, 'delete_lpsal'])->name('saldoawal.delete_lpsal');
    Route::delete('saldoawal/lpe-delete/{id}', [SoawController::class, 'delete_lpe'])->name('saldoawal.delete_lpe');
    Route::resource('saldoawalpiutang', SopiutController::class);
    Route::resource('saldoawalutang', SoutaController::class);
    Route::resource('mutasikasbank', MutasikasbankController::class);

    Route::get('/pembiayaan-detail/{pembiayaan}', [PembiayaanController::class, 'pembiayaandetail'])->name('pembiayaan.detail');
    Route::resource('pembiayaan', PembiayaanController::class);
    Route::resource('pembiayaanrinci', PembiayaanrinciController::class);

    Route::get('/titipan-detail/{titipan}', [TitipanController::class, 'titipandetail'])->name('titipan.detail');
    Route::resource('titipan', TitipanController::class);

    Route::resource('titipanrinci', TitipanrinciController::class);

    Route::get('rba-pdf', [PDFRbaController::class, 'showrba1'])->name('rba.pdf');
    Route::get('rbapendapatan-pdf', [PDFRbaController::class, 'rbapendapatanPDF'])->name('rbapendapatanPDF');

    Route::get('rba2-pdf', [PDFRbaController::class, 'showrba2'])->name('rba2.pdf');
    Route::get('rbabelanja-pdf', [PDFRbaController::class, 'rbabelanjaPDF'])->name('rbabelanjaPDF');

    Route::get('rba2rinci', [PDFRbaController::class, 'showrba2rinci'])->name('rba2rinci');
    Route::get('rba2rinciPDF', [PDFRbaController::class, 'showrba2rinciPDF'])->name('rba2rinciPDF');

    Route::get('rba3-pdf', [PDFRbaController::class, 'showrba3'])->name('rba3.pdf');
    Route::get('rbapembiayaan-pdf', [PDFRbaController::class, 'rbapembiayaanPDF'])->name('rbapembiayaanPDF');

    Route::get('rba4-pdf', [PDFRbaController::class, 'showrba4'])->name('rba4.pdf');
    Route::get('rbaringkas-pdf', [PDFRbaController::class, 'rbaringkasPDF'])->name('rbaringkasPDF');

    Route::get('rba5-pdf', [PDFRbaController::class, 'showrba5'])->name('rba5.pdf');
    Route::get('rbarinci-pdf', [PDFRbaController::class, 'rbarinciPDF'])->name('rbarinciPDF');

    Route::get('dba-pdf', [PDFDbaController::class, 'showdba1'])->name('dba.pdf');
    Route::get('dbapendapatan-pdf', [PDFDbaController::class, 'dbapendapatanPDF'])->name('dbapendapatanPDF');

    Route::get('dba2-pdf', [PDFDbaController::class, 'showdba2'])->name('dba2.pdf');
    Route::get('dbabelanja-pdf', [PDFDbaController::class, 'dbabelanjaPDF'])->name('dbabelanjaPDF');

    Route::get('dba3-pdf', [PDFDbaController::class, 'showdba3'])->name('dba3.pdf');
    Route::get('dbapembiayaan-pdf', [PDFDbaController::class, 'dbapembiayaanPDF'])->name('dbapembiayaanPDF');

    Route::get('dba4-pdf', [PDFDbaController::class, 'showdba4'])->name('dba4.pdf');
    Route::get('dbaringkas-pdf', [PDFDbaController::class, 'dbaringkasPDF'])->name('dbaringkasPDF');

    Route::get('dba5-pdf', [PDFDbaController::class, 'showdba5'])->name('dba5.pdf');
    Route::get('dbarinci-pdf', [PDFDbaController::class, 'dbarinciPDF'])->name('dbarinciPDF');

    // Laporan Penatausahaan - Belanja
    Route::get('npd_pdf', [PDFBelanjaController::class, 'npd'])->name('npd_pdf');
    Route::get('npd/d_npd/{id}', [PDFBelanjaController::class, 'd_npd'])->name('npd_d_npd');
    Route::get('npd/print_npd/{id}', [PDFBelanjaController::class, 'print_npd'])->name('npd_print_npd');
    Route::get('pump_pdf', [PDFBelanjaController::class, 'pump'])->name('pump_pdf');
    Route::get('pump/d_pump/{id}', [PDFBelanjaController::class, 'd_pump'])->name('pumpd_pump');
    Route::get('pump/print_pump/{id}', [PDFBelanjaController::class, 'print_pump'])->name('pump_print_pump');
    Route::get('kump_pdf', [PDFBelanjaController::class, 'kump'])->name('kump_pdf');
    Route::get('kump/d_kump/{id}', [PDFBelanjaController::class, 'd_kump'])->name('kump_d_kump');
    Route::get('kump/print_kump/{id}', [PDFBelanjaController::class, 'print_kump'])->name('kump_print_kump');

    Route::get('tagihan-pdf', [PDFBelanjaController::class, 'showtagihan'])->name('tagihan.pdf');
    Route::post('tagihan-pdf-isi', [PDFBelanjaController::class, 'showtagihan_isi'])->name('tagihan.pdf.isi');
    Route::get('tagihan-pdf-cetak', [PDFBelanjaController::class, 'showtagihan_cetak'])->name('tagihan.pdf.cetak');
    Route::post('tagihan-pdf/fetch_data', [PDFBelanjaController::class, 'fetch_data'])->name('daterange.fetch_data');
    Route::get('prtagihan-pdf', [PDFBelanjaController::class, 'prtagihan'])->name('prtagihan.pdf');

    Route::get('kontrak-pdf', [PDFBelanjaController::class, 'showkontrak'])->name('kontrak.pdf');
    Route::get('prkontrak-pdf', [PDFBelanjaController::class, 'prkontrak'])->name('prkontrak.pdf');
    Route::get('sp2d-pdf', [PDFBelanjaController::class, 'showsp2d'])->name('sp2d.pdf');
    Route::get('prsp2d-pdf', [PDFBelanjaController::class, 'prsp2d'])->name('prsp2d.pdf');
    Route::get('panjar-pdf', [PDFBelanjaController::class, 'showpanjar'])->name('panjar.pdf');
    Route::get('prpanjar-pdf', [PDFBelanjaController::class, 'prpanjar'])->name('prpanjar.pdf');
    Route::get('kuitansi-pdf', [PDFBelanjaController::class, 'showkuitansi'])->name('kuitansi.pdf');
    Route::get('prkuitansi-pdf', [PDFBelanjaController::class, 'prkuitansi'])->name('prkuitansi.pdf');
    Route::get('pajak-pdf', [PDFBelanjaController::class, 'showpajak'])->name('pajak.pdf');
    Route::get('prpajak-pdf', [PDFBelanjaController::class, 'prpajak'])->name('prpajak.pdf');
    Route::get('bku-show', [PDFBelanjaController::class, 'bkushow'])->name('bku.show');
    Route::post('bku-show-isi', [PDFBelanjaController::class, 'bkushow_isi'])->name('bku.show.isi');
    Route::get('bku-show-cetak', [PDFBelanjaController::class, 'bkushow_cetak'])->name('bku.show.cetak');
    Route::get('bku-pdf', [PDFBelanjaController::class, 'bkupdf'])->name('bku.pdf');
    Route::get('bpgu-show', [PDFBelanjaController::class, 'bpgushow'])->name('bpgu.show');
    Route::post('bpgu-show-isi', [PDFBelanjaController::class, 'bpgushow_isi'])->name('bpgu.show.isi');
    Route::get('bpgu-show-cetak', [PDFBelanjaController::class, 'bpgushow_cetak'])->name('bpgu.show.cetak');
    Route::get('bpgu-pdf', [PDFBelanjaController::class, 'bpgupdf'])->name('bpgu.pdf');
    Route::get('bplsnon-show', [PDFBelanjaController::class, 'bplsnonshow'])->name('bplsnon.show');
    Route::post('bplsnon-show-isi', [PDFBelanjaController::class, 'bplsnonshow_isi'])->name('bplsnon.show.isi');
    Route::get('bplsnon-show-cetak', [PDFBelanjaController::class, 'bplsnonshow_cetak'])->name('bplsnon.show.cetak');
    Route::get('bplsnon-pdf', [PDFBelanjaController::class, 'bplsnonpdf'])->name('bplsnon.pdf');
    Route::get('bplscontr-show', [PDFBelanjaController::class, 'bplscontrshow'])->name('bplscontr.show');
    Route::post('bplscontr-show-isi', [PDFBelanjaController::class, 'bplscontrshow_isi'])->name('bplscontr.show.isi');
    Route::get('bplscontr-show-cetak', [PDFBelanjaController::class, 'bplscontrshow_cetak'])->name('bplscontr.show.cetak');
    Route::get('bplscontr-pdf', [PDFBelanjaController::class, 'bplscontrpdf'])->name('bplscontr.pdf');
    Route::get('bppj', [PDFBelanjaController::class, 'bppj'])->name('bppj.show');
    Route::post('bppj-isi', [PDFBelanjaController::class, 'bppj_isi'])->name('bppj.show.isi');
    Route::get('bppj-cetak', [PDFBelanjaController::class, 'bppj_cetak'])->name('bppj.show.cetak');
    Route::get('bppajak', [PDFBelanjaController::class, 'bppajak'])->name('bppajak.show');
    Route::post('bppajak_isi', [PDFBelanjaController::class, 'bppajak_isi'])->name('bppajak.show.isi');
    Route::get('bppajak_isi_cetak', [PDFBelanjaController::class, 'bppajak_cetak'])->name('bppajak.show.cetak');
    Route::get('regspp', [PDFBelanjaController::class, 'regspp'])->name('regspp.show');
    Route::post('regspp-isi', [PDFBelanjaController::class, 'regspp_isi'])->name('regspp.show.isi');
    Route::get('reg-kontrak', [PDFBelanjaController::class, 'regKontrak'])->name('reg.kontrak');
    Route::post('reg-kontrak-isi', [PDFBelanjaController::class, 'regKontrak_isi'])->name('reg.kontrak.isi');
    Route::get('reg-kontrak-cetak', [PDFBelanjaController::class, 'regKontrak_cetak'])->name('reg.kontrak.cetak');
    Route::get('bpobjek', [PDFBelanjaController::class, 'bpobjek'])->name('bpobjek');
    Route::post('bpobjek_isi', [PDFBelanjaController::class, 'bpobjek_isi'])->name('bpobjek_isi');
    Route::post('bpobjek_cetak', [PDFBelanjaController::class, 'bpobjek_cetak'])->name('bpobjek_cetak');
    Route::get('fungsionalpengeluaran', [PDFBelanjaController::class, 'fungsionalpengeluaran'])->name('fungsionalpengeluaran');
    Route::post('fungsionalpengeluaran_isi', [PDFBelanjaController::class, 'fungsionalpengeluaran_isi'])->name('fungsionalpengeluaran_isi');
    Route::post('fungsionalpengeluaran_cetak', [PDFBelanjaController::class, 'fungsionalpengeluaran_cetak'])->name('fungsionalpengeluaran_cetak');


    // Laporan Penatausahaan - Bendahara - Pengeluaran
    Route::get('pengeluaran_rss', [PengeluaranController::class, 'pengeluaran_rss'])->name('pengeluaran_rss');
    Route::get('pengeluaran_bku', [PengeluaranController::class, 'pengeluaran_bku'])->name('pengeluaran_bku');
    Route::get('pengeluaran_bpb', [PengeluaranController::class, 'pengeluaran_bpb'])->name('pengeluaran_bpb');
    Route::get('pengeluaran_bpk', [PengeluaranController::class, 'pengeluaran_bpk'])->name('pengeluaran_bpk');
    Route::get('pengeluaran_bppk', [PengeluaranController::class, 'pengeluaran_bppk'])->name('pengeluaran_bppk');
    Route::get('pengeluaran_lpj', [PengeluaranController::class, 'pengeluaran_lpj'])->name('pengeluaran_lpj');


    // Route::get('bku-show', [BendPengeluaranController::class, 'bkushow'])->name('bku.show'); move
    // Route::get('bku-pdf', [BendPengeluaranController::class, 'bkupdf'])->name('bku.pdf'); move

    // Laporan - Penatausahaan
    // Laporan - Penatausahaan - S-PPD
    Route::get('spp-pdf', [PDFSppController::class, 'spp'])->name('spp.pdf');
    Route::post('spp-pdf', [PDFSppController::class, 'pilihSpp'])->name('spp.pdf.pilih');
    Route::post('spp-pdf-cetak', [PDFSppController::class, 'cetakSpp'])->name('spp.pdf.cetak');


    // Laporan - Penatausahaan - SPM
    Route::get('spm-pdf', [PDFSpmController::class, 'spm'])->name('spm.pdf');
    Route::post('spm-pdf', [PDFSpmController::class, 'pilihSpm'])->name('spm.pdf.pilih');
    Route::post('spm-pdf-cetak', [PDFSpmController::class, 'cetakSpm'])->name('spm.pdf.cetak');

    // end atan

    Route::resource('spm', SpmController::class);
    Route::get('spm/tambah/{id}', [SpmController::class, 'tambah'])->name('spm.tambah');
    Route::post('spm_getData', [SpmController::class, 'getData'])->name('spm_getData');
	Route::get("spd_spm_pdf/{id}", [SpmController::class, "spd_spm_pdf"])->name("spd_spm_pdf");

    // Laporan
    Route::resource('rencana_ba_pendapatan', RencanaBApendapatanController::class);

    // Laporan - Penatausahaan - SPP
    Route::get('spp-pdf', [PDFSppController::class, 'spp'])->name('spp.pdf');
    Route::post('spp-pdf', [PDFSppController::class, 'pilihSpp'])->name('spp.pdf.pilih');
    Route::post('spp-pdf-cetak', [PDFSppController::class, 'cetakSpp'])->name('spp.pdf.cetak');

    // Laporan - Penatausahaan - Pengajuan - SPPD
    Route::resource('lap_sppd', SppdController::class);
    Route::post('sppd-isi', [SppdController::class, 'regspp_isi'])->name('register.sppd.isi');
    Route::get('sppd-cetak', [SppdController::class, 'regspp_cetak'])->name('register.sppd.cetak');
    Route::get("sppd/{id}", [SppdController::class, "sppd_pdf"])->name("sppd_pdf");

    // Laporan - Penatausahaan - SPM
    Route::get('spm-pdf', [PDFSpmController::class, 'spm'])->name('spm.pdf');
    Route::post('spm-pdf', [PDFSpmController::class, 'pilihSpm'])->name('spm.pdf.pilih');
    Route::post('spm-pdf-cetak', [PDFSpmController::class, 'cetakSpm'])->name('spm.pdf.cetak');

    // Laporan - Pembukuan - Lapkeu
    Route::get('lapkeu-pdf', [PDFLapkeuController::class, 'pilihLapkeu'])->name('lapkeu.pdf.pilih');
    Route::post('lapkeu-pdf-cetak', [PDFLapkeuController::class, 'cetakLapkeu'])->name('lapkeu.pdf.cetak');
    Route::get('jurnal-show', [PDFLapManajemenController::class, 'jurnalshow'])->name('jurnal.show');
    Route::get('bb-show', [PDFLapManajemenController::class, 'bbshow'])->name('bb.show');

    Route::resource('lapkeu', PDFLapkeuController::class);
    Route::get('lapkeu_pdf', [PDFLapkeuController::class, 'lapkeu_pdf'])->name('lapkeu_pdf');

    // Laporan - Pembukuan - Jurnal
    Route::resource('lapjurnal', LapjurnalController::class);

    // Laporan - Pembukuan - Buku Besar
    Route::resource('lapbb', LapbbController::class);
    Route::get('lapbb_rekap', [LapbbController::class, 'rekap'])->name('lapbb_rekap');
    Route::get('lapbb_sub', [LapbbController::class, 'subrekap'])->name('lapbb_sub');
    Route::get('lapbb_subrinci', [LapbbController::class, 'subrekaprinci'])->name('lapbb_subrinci');
    Route::get('lapbbrekap', [LapbbController::class, 'lapbbrekap'])->name('lapbbrekap');
    Route::get('cariakun', [LapbbController::class, 'search'])->name('cariakun');
    Route::get('cariakunrekap', [LapbbController::class, 'searchrekap'])->name('cariakunrekap');
    Route::get('cariakunsubrekap', [LapbbController::class, 'searchsubrekap'])->name('cariakunsubrekap');
    Route::get('cariakunsub2rekap', [LapbbController::class, 'searchsub2rekap'])->name('cariakunsub2rekap');

    // Laporan - Pembukuan - Laporan Manajemen
    Route::get('lapman-pdf', [PDFLapManajemenController::class, 'pilihLapman'])->name('lapman.pdf.pilih');
    Route::post('lapman-pdf-cetak', [PDFLapManajemenController::class, 'cetakLapman'])->name('lapman.pdf.cetak');

    Route::get('lapregPiutang', [PDFLapManajemenController::class, 'regPiutang'])->name('lapregPiutang');
    Route::post('reg-piutang-show-isi', [PDFLapManajemenController::class, 'regPiutangIsi'])->name('reg.piutang.show.isi');
    Route::get('reg-piutang-show-cetak', [PDFLapManajemenController::class, 'regPiutangCetak'])->name('reg.piutang.show.cetak');

    Route::get('bkublud', [PDFLapManajemenController::class, 'bkublud'])->name('bkublud');
    Route::post('bku_blud_isi', [PDFLapManajemenController::class, 'bku_blud_isi'])->name('bku_blud_isi');
    Route::get('bku_blud_cetak', [PDFLapManajemenController::class, 'bku_blud_cetak'])->name('bku_blud_cetak');

    Route::get('realisasipb', [PDFLapManajemenController::class, 'realisasipb'])->name('realisasipb');
    Route::post('realisasipb_isi', [PDFLapManajemenController::class, 'realisasipb_isi'])->name('realisasipb_isi');

    Route::get('lapsoaw', [PDFLapManajemenController::class, 'lapsoaw'])->name('lapsoaw');

    Route::resource('lapman', PDFLapManajemenController::class);
    Route::get('lapman_pdf', [PDFLapkeuController::class, 'lapman_pdf'])->name('lapman_pdf');

    // Laporan RKA
    Route::get("rka1_pendapatan", [RkaController::class, "rka1_pendapatan"])->name("rka1_pendapatan");
    Route::get("rka2_belanja", [RkaController::class, "rka2_belanja"])->name("rka2_belanja");
    Route::get("rka3_terima_biaya", [RkaController::class, "rka3_terima_biaya"])->name("rka3_terima_biaya");
    Route::get("rka4_keluar_biaya", [RkaController::class, "rka4_keluar_biaya"])->name("rka4_keluar_biaya");

    // Laporan RKA PDF
    Route::get("rka1_pendapatan_pdf", [RkaController::class, "rka1_pendapatan_pdf"])->name("rka1_pendapatan_pdf");
    Route::get("rka2_belanja_pdf", [RkaController::class, "rka2_belanja_pdf"])->name("rka2_belanja_pdf");
    Route::get("rka3_terima_biaya_pdf", [RkaController::class, "rka3_terima_biaya_pdf"])->name("rka3_terima_biaya_pdf");
    Route::get("rka4_keluar_biaya_pdf", [RkaController::class, "rka4_keluar_biaya_pdf"])->name("rka4_keluar_biaya_pdf");

    // DPA
    Route::get("dpa1", [DPAController::class, "dpa1"])->name("dpa1");
    Route::get("dpa2", [DPAController::class, "dpa2"])->name("dpa2");
    Route::get("dpa3", [DPAController::class, "dpa3"])->name("dpa3");
    Route::get("dpa4", [DPAController::class, "dpa4"])->name("dpa4");

    // DPA PDF
    Route::get("dpa1_pdf", [DPAController::class, "dpa1_pdf"])->name("dpa1_pdf");
    Route::get("dpa2_pdf", [DPAController::class, "dpa2_pdf"])->name("dpa2_pdf");
    Route::get("dpa3_pdf", [DPAController::class, "dpa3_pdf"])->name("dpa3_pdf");
    Route::get("dpa4_pdf", [DPAController::class, "dpa4_pdf"])->name("dpa4_pdf");

    // Laporan Penatausahaan - Belanja
    // Route::get('npd_pdf',[PDFBelanjaController::class,'npd'])->name('npd_pdf');
    // Route::get('npd/d_npd/{id}',[PDFBelanjaController::class,'d_npd'])->name('npd_d_npd');
    // Route::get('npd/print_npd/{id}',[PDFBelanjaController::class,'print_npd'])->name('npd_print_npd');
    // Route::get('pump_pdf',[PDFBelanjaController::class,'pump'])->name('pump_pdf');
    // Route::get('pump/d_pump/{id}',[PDFBelanjaController::class,'d_pump'])->name('pumpd_pump');
    // Route::get('pump/print_pump/{id}',[PDFBelanjaController::class,'print_pump'])->name('pump_print_pump');
    // Route::get('kump_pdf',[PDFBelanjaController::class,'kump'])->name('kump_pdf');
    // Route::get('kump/d_kump/{id}',[PDFBelanjaController::class,'d_kump'])->name('kump_d_kump');
    // Route::get('kump/print_kump/{id}',[PDFBelanjaController::class,'print_kump'])->name('kump_print_kump');
    // Route::get('tagihan-pdf', [PDFBelanjaController::class, 'showtagihan'])->name('tagihan.pdf');
    //  Route::post('tagihan-pdf/fetch_data', [PDFBelanjaController::class, 'fetch_data'])->name('daterange.fetch_data');
    // Route::get('prtagihan-pdf', [PDFBelanjaController::class, 'prtagihan'])->name('prtagihan.pdf');
    // Laporan Penatausahaan - Pendapatan
    Route::get('bppendapatan', [PendapatanController::class, 'bppendapatan'])->name('bppendapatan');
    Route::get('bppendapatan/d_bpp/{id}', [PendapatanController::class, 'd_bpp'])->name('bppendapatan/d_bpp');
    Route::get('bppendapatan/print_bpp/{id}', [PendapatanController::class, 'print_bpp'])->name('bppendapatan/print_bpp');
    Route::get('stspendapatan', [PendapatanController::class, 'stspendapatan'])->name('stspendapatan');
    Route::get('stspendapatan/d_stsp/{id}', [PendapatanController::class, 'd_stsp'])->name('stspendapatan/d_stsp');
    Route::get('stspendapatan/print_stsp/{id}', [PendapatanController::class, 'print_stsp'])->name('stspendapatan/print_stsp');
    Route::get('rppendapatan', [PendapatanController::class, 'rppendapatan'])->name('rppendapatan');
    Route::get('bkupenerimaan', [PendapatanController::class, 'bkupenerimaan'])->name('bkupenerimaan');
    Route::get('bprincian', [PendapatanController::class, 'bprincian'])->name('bprincian');
    Route::get('lpjbendahara', [PendapatanController::class, 'lpjbendahara'])->name('lpjbendahara');
    Route::get('otopenerimaan', [PendapatanController::class, 'otopenerimaan'])->name('otopenerimaan');

    // Laporan Penatausahaan - Bendahara - Penerimaan
    Route::get('penerimaan_sts', [PenerimaanController::class, 'penerimaan_sts'])->name('penerimaan_sts');
    Route::post('penerimaan_sts_isi', [PenerimaanController::class, 'penerimaan_sts_isi'])->name('penerimaan_sts_isi');
    Route::get('penerimaan_sts_cetak', [PenerimaanController::class, 'penerimaan_sts_cetak'])->name('penerimaan_sts_cetak');
    Route::get('qr_sts', [PenerimaanController::class, 'qr_sts'])->name('qr_sts');
    Route::get('qr_sts_cetak', [PenerimaanController::class, 'qr_sts_cetak'])->name('qr_sts_cetak');
    Route::get('penerimaan_bku', [PenerimaanController::class, 'penerimaan_bku'])->name('penerimaan_bku');
    Route::post('penerimaan_bku_isi', [PenerimaanController::class, 'penerimaan_bku_isi'])->name('penerimaan_bku_isi');
    Route::get('penerimaan_bku_cetak', [PenerimaanController::class, 'penerimaan_bku_cetak'])->name('penerimaan_bku_cetak');
    Route::get('penerimaan_bpkt', [PenerimaanController::class, 'penerimaan_bpkt'])->name('penerimaan_bpkt');
    Route::post('penerimaan_bpkt_isi', [PenerimaanController::class, 'penerimaan_bpkt_isi'])->name('penerimaan_bpkt_isi');
    Route::get('penerimaan_bpkt_cetak', [PenerimaanController::class, 'penerimaan_bpkt_cetak'])->name('penerimaan_bpkt_cetak');
    Route::get('penerimaan_bpb', [PenerimaanController::class, 'penerimaan_bpb'])->name('penerimaan_bpb');
    Route::post('penerimaan_bpb_isi', [PenerimaanController::class, 'penerimaan_bpb_isi'])->name('penerimaan_bpb_isi');
    Route::get('penerimaan_bpb_cetak', [PenerimaanController::class, 'penerimaan_bpb_cetak'])->name('penerimaan_bpb_cetak');
    Route::get('penerimaan_lpj', [PenerimaanController::class, 'penerimaan_lpj'])->name('penerimaan_lpj');
    Route::get('penerimaan_lpp', [PenerimaanController::class, 'penerimaan_lpp'])->name('penerimaan_lpp');
    Route::post('penerimaan_lpp_isi', [PenerimaanController::class, 'penerimaan_lpp_isi'])->name('penerimaan_lpp_isi');
    Route::get('penerimaan_lpp_cetak', [PenerimaanController::class, 'penerimaan_lpp_cetak'])->name('penerimaan_lpp_cetak');
    Route::get('reg-piutang', [PenerimaanController::class, 'regPiutang'])->name('regPiutang');
    Route::post('reg-piutang-isi', [PenerimaanController::class, 'regPiutangIsi'])->name('regPiutangIsi');
    Route::get('reg-piutang-cetak', [PenerimaanController::class, 'regPiutangCetak'])->name('regPiutangCetak');
    Route::get('fungsionalpenerimaan', [PenerimaanController::class, 'fungsionalpenerimaan'])->name('fungsionalpenerimaan');
    Route::post('fungsionalpenerimaan_isi', [PenerimaanController::class, 'fungsionalpenerimaan_isi'])->name('fungsionalpenerimaan_isi');
    Route::post('fungsionalpenerimaan_cetak', [PenerimaanController::class, 'fungsionalpenerimaan_cetak'])->name('fungsionalpenerimaan_cetak');


    // Laporan Penatausahaan - Bendahara - Pengeluaran
    // Route::get('pengeluaran_rss',[PengeluaranController::class,'pengeluaran_rss'])->name('pengeluaran_rss');
    // Route::get('pengeluaran_bku',[PengeluaranController::class,'pengeluaran_bku'])->name('pengeluaran_bku');
    // Route::get('pengeluaran_bpb',[PengeluaranController::class,'pengeluaran_bpb'])->name('pengeluaran_bpb');
    // Route::get('pengeluaran_bpk',[PengeluaranController::class,'pengeluaran_bpk'])->name('pengeluaran_bpk');
    // Route::get('pengeluaran_bppk',[PengeluaranController::class,'pengeluaran_bppk'])->name('pengeluaran_bppk');
    // Route::get('pengeluaran_bppj',[PengeluaranController::class,'pengeluaran_bppj'])->name('pengeluaran_bppj');
    // Route::get('pengeluaran_lpj',[PengeluaranController::class,'pengeluaran_lpj'])->name('pengeluaran_lpj');


    // Laporan - Perencanaan - Anggaran Kas
    Route::resource('lap_ang_kas', LapAngKasController::class);
    Route::get('lap_ang_kas_pendapatan', [LapAngKasController::class, 'lap_ang_kas_pendapatan'])->name('lap_ang_kas_pendapatan');
    Route::get('lap_ang_kas_belanja_keg', [LapAngKasController::class, 'lap_ang_kas_belanja_keg'])->name('lap_ang_kas_belanja_keg');
    Route::get('lap_ang_kas_pembiayaan', [LapAngKasController::class, 'lap_ang_kas_pembiayaan'])->name('lap_ang_kas_pembiayaan');

    
});


Route::middleware(['auth', 'akses: 1,2,3,4,5,6,7,8,9,10,98,99'])->prefix('laporan1')->name('laporan.perencanaan.')->group(function () {
    //Cetak RKA
	Route::prefix('cetak-rka')->name('cetak-rka.')->group(function () {
		Route::get('/', [CetakLaporanRKAController::class, 'laporan'])->name('index');
		Route::get('selectProgram/{id?}', [CetakLaporanRKAController::class, 'selectProgram'])->name('selectProgram');
		Route::get('selectKegiatan/{id?}', [CetakLaporanRKAController::class, 'selectKegiatan'])->name('selectKegiatan');
		Route::get('selectSubKegiatan/{id?}', [CetakLaporanRKAController::class, 'selectSubKegiatan'])->name('selectSubKegiatan');
		Route::get('rptrka', [CetakLaporanRKAController::class, 'export'])->name('rptrka');
	});

    //Cetak DPA
	Route::prefix('cetak-dpa')->name('cetak-dpa.')->group(function () {
		Route::get('/', [CetakLaporanDPAController::class, 'laporan'])->name('index');
		Route::get('selectProgram/{id?}', [CetakLaporanDPAController::class, 'selectProgram'])->name('selectProgram');
		Route::get('selectKegiatan/{id?}', [CetakLaporanDPAController::class, 'selectKegiatan'])->name('selectKegiatan');
		Route::get('selectSubKegiatan/{id?}', [CetakLaporanDPAController::class, 'selectSubKegiatan'])->name('selectSubKegiatan');
		Route::get('selectJenisDokumen/{id?}', [CetakLaporanDPAController::class, 'selectJenisDokumen'])->name('selectJenisDokumen');
		Route::get('selectRevisi/{id?}', [CetakLaporanDPAController::class, 'selectRevisi'])->name('selectRevisi');
		Route::get('rptdpa', [CetakLaporanDPAController::class, 'export'])->name('rptdpa');
	});

});

Route::middleware(['auth', 'akses: 1,2,3,4,5,6,7,8,9,10,98,99'])->prefix('laporan2')->name('laporan.penatausahaan.')->group(function () {
    //Cetak Bend Penerimaan
	Route::prefix('cetak-penerimaan')->name('cetak-penerimaan.')->group(function () {
		Route::get('/', [CetakLaporanPenerimaanController::class, 'laporan'])->name('index');
		Route::get('selectRek2/{id?}', [CetakLaporanPenerimaanController::class, 'selectRek2'])->name('selectRek2');
        Route::get('selectRek3/{id?}', [CetakLaporanPenerimaanController::class, 'selectRek3'])->name('selectRek3');
        Route::get('getNoTBP', [CetakLaporanPenerimaanController::class, 'getNoBukti'])->name('getNoTBP');
		Route::get('getNoSTS', [CetakLaporanPenerimaanController::class, 'getNoBukti'])->name('getNoSTS');
		Route::get('rptpenerimaan', [CetakLaporanPenerimaanController::class, 'export'])->name('rptpenerimaan');
	});
	
	//Cetak Bend Pengeluaran
	Route::prefix('cetak-pengeluaran')->name('cetak-pengeluaran.')->group(function () {
		Route::get('/', [CetakLaporanPengeluaranController::class, 'laporan'])->name('index');
		Route::get('selectRek2/{id?}', [CetakLaporanPengeluaranController::class, 'selectRek2'])->name('selectRek2');
        Route::get('selectRek3/{id?}', [CetakLaporanPengeluaranController::class, 'selectRek3'])->name('selectRek3');
        Route::get('selectProgram/{id?}', [CetakLaporanPengeluaranController::class, 'selectProgram'])->name('selectProgram');
		Route::get('selectKegiatan/{id?}', [CetakLaporanPengeluaranController::class, 'selectKegiatan'])->name('selectKegiatan');
		Route::get('selectSubKegiatan/{id?}', [CetakLaporanPengeluaranController::class, 'selectSubKegiatan'])->name('selectSubKegiatan');
		Route::get('rptpengeluaran', [CetakLaporanPengeluaranController::class, 'export'])->name('rptpengeluaran');
	});

});

Route::middleware(['auth', 'akses: 1,2,3,4,5,6,7,8,9,10,98,99'])->prefix('laporan3')->name('laporan.pembukuan.')->group(function () {
    //Cetak Pembukuan
	Route::prefix('cetak-lapkeu')->name('cetak-lapkeu.')->group(function () {
		Route::get('/', [CetakLaporanPembukuanController::class, 'laporan'])->name('index');
		Route::get('selectProgram/{id?}', [CetakLaporanPembukuanController::class, 'selectProgram'])->name('selectProgram');
		Route::get('selectKegiatan/{id?}', [CetakLaporanPembukuanController::class, 'selectKegiatan'])->name('selectKegiatan');
		Route::get('selectSubKegiatan/{id?}', [CetakLaporanPembukuanController::class, 'selectSubKegiatan'])->name('selectSubKegiatan');
		Route::get('selectRek2/{id?}', [CetakLaporanPembukuanController::class, 'selectRek2'])->name('selectRek2');
        Route::get('selectRek3/{id?}', [CetakLaporanPembukuanController::class, 'selectRek3'])->name('selectRek3');
        Route::get('getNoBukti', [CetakLaporanPembukuanController::class, 'getNoBukti'])->name('getNoBukti');
		Route::get('rptpembukuan', [CetakLaporanPembukuanController::class, 'export'])->name('rptpembukuan');
	});

});

// Manajemen User
Route::middleware(['auth', 'akses: 98,99'])->prefix('setting.manajemen-user')->name('setting.manajemen-user.')->group(function () {
    // User
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [MasterUserController::class, 'index'])->name('index');
        Route::get('datatable', [MasterUserController::class, 'datatable'])->name('datatable');
        Route::get('form/{code?}', [MasterUserController::class, 'form'])->name('form');
        Route::post('store', [MasterUserController::class, 'store'])->name('store');
        Route::put('update/{code}', [MasterUserController::class, 'update'])->name('update');
        Route::delete('destroy/{code}', [MasterUserController::class, 'destroy'])->name('destroy');
        Route::post('password/{code}', [MasterUserController::class, 'password'])->name('password');
        Route::get('pemda', [MasterUserController::class, 'pemda'])->name('pemda');
        Route::get('unit', [MasterUserController::class, 'unit'])->name('unit');
        Route::get('subunit', [MasterUserController::class, 'subunit'])->name('subunit');
        Route::get('subunit1', [MasterUserController::class, 'subunit1'])->name('subunit1');
    });
});

// Manajemen Pemda
Route::middleware(['auth', 'akses: 98,99'])->prefix('setting.manajemen-pemda')->name('setting.manajemen-pemda.')->group(function () {
    Route::get('/', [MasterPemdaController::class, 'index'])->name('index');
    Route::get('datatable', [MasterPemdaController::class, 'datatable'])->name('datatable');
    Route::get('form/{code?}', [MasterPemdaController::class, 'form'])->name('form');
    Route::post('store', [MasterPemdaController::class, 'store'])->name('store');
    Route::put('update/{code}', [MasterPemdaController::class, 'update'])->name('update');
    Route::delete('destroy/{code}', [MasterPemdaController::class, 'destroy'])->name('destroy');
    Route::get('pemda', [MasterPemdaController::class, 'pemda'])->name('pemda');
});

// Manajemen Rekening
Route::middleware(['auth', 'akses: 98,99'])->prefix('setting.manajemen-rekening')->name('setting.manajemen-rekening.')->group(function () {
    Route::get('/', [MasterRekeningController::class, 'index'])->name('index');
    Route::post('datatable', [MasterRekeningController::class, 'datatable'])->name('datatable');
    Route::get('form/{Ko_Rk}', [MasterRekeningController::class, 'form'])->name('form');
    Route::post('store/{Ko_Rk}', [MasterRekeningController::class, 'store'])->name('store');
    Route::put('update/{Ko_Rk}', [MasterRekeningController::class, 'update'])->name('update');
    Route::delete('destroy/{Ko_Rk}', [MasterRekeningController::class, 'destroy'])->name('destroy');
    Route::get('export', [MasterRekeningController::class, 'export'])->name('export');
    Route::get('copy', [MasterRekeningController::class, 'copy'])->name('copy');
});

// Manajemen Unit
Route::middleware(['auth', 'akses: 98,99'])->prefix('setting.manajemen-unit')->name('setting.manajemen-unit.')->group(function () {
   Route::get('/', [UnitOrganisasiController::class, 'index'])->name('index');
	Route::get('datatable', [UnitOrganisasiController::class, 'datatable'])->name('datatable');
	Route::get('form', [UnitOrganisasiController::class, 'form'])->name('form');
	Route::post('store', [UnitOrganisasiController::class, 'store'])->name('store');
	Route::put('update/{code}', [UnitOrganisasiController::class, 'update'])->name('update');
	Route::delete('destroy/{code}', [UnitOrganisasiController::class, 'destroy'])->name('destroy');
	Route::post('wizard/{code}', [UnitOrganisasiController::class, 'wizard'])->name('wizard');
});
