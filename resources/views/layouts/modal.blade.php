<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="updateModal">UPDATE FORSA BLUD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('dashboard') }}">
                    @csrf
					<div class="card card-body">
						<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
							UPDATE ASTER 1.2
						</button>
					</div>
					<div id="collapse2">
						<div class="card card-body">
							<div class="form-group row mb-0">
								<div class="modal-header">
									<div class="description md">
										<p>Tambahan Fitur:</p>
										<ol>
											<li>Penambahan Dashboard Ratio Keuangan</li>
											<li>Penambahan Menu "Preview/Cetak" di Inputan Aplikasi</li>
											<li>Penyederhanaan dan Refresh beberapa Menu/Tampilan Aplikasi</li>
											<li>Penambahan Fitur Tema Dark/Light Mode</li>
											<li>Update Parameter Program/Kegiatan/Subkegiatan</li>
										</ol>
										<p>Fixbug:</p>
										<ol>
											<li>Perbaikan Laporan RKA/RKAP</li>
											<li>Perbaikan Laporan DPA/DPPA</li>
											<li>Perbaikan Laporan Penatausahaan</li>
											<li>Perbaikan Laporan Akuntansi</li>
											<li>Perbaikan Kode Prog/Keg/Subkegiatan di Anggaran dan Penatausahaan Mengikuti Update terbaru</li>
										</ol>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card card-body">
						<button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
							UPDATE ASTER 1.1
						</button>
					</div>
					<div class="collapse" id="collapse1">
						<div class="card card-body">
							<div class="form-group row mb-0">
								<div class="modal-header">
									<div class="description md">
										<p>Tambahan Fitur:</p>
										<ol>
											<li>Dashboard Aplikasi</li>
											<li>Laporan Perubahan Anggaran (RKA/DPA)</li>
											<li>Laporan Bendahara Penerimaan</li>
											<li>Laporan Pembukuan (Neraca, LO, LPE, LRA, LPSAL, LAK Format SAP serta Laporan Pembukuan lainnya)</li>
											<li>Rebuild Jurnal</li>
										</ol>
										<p>Fixbug:</p>
										<ol>
											<li>Perbaikan Kontrol Realisasi Belanja di Perubahan Anggaran</li>
											<li>Perbaikan Kontrol Penetapan Anggaran</li>
											<li>Perbaikan Kontrol Nilai Kontrak atas Termin Kontrak</li>
											<li>Perbaikan Menu SPP Belanja</li>
											<li>Perbaikan Menu Setor Pajak</li>
											<li>Perbaikan Menu Tambah Rincian SP3B</li>
											<li>Perbaikan Kontrol Jurnal Penyesuaian</li>
										</ol>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-header">
						<div class="col-md-12 offset-md-5">
							<button type="submit" class="btn btn-primary" class="close" data-dismiss="modal" aria-label="Close">
								Tutup
							</button>
						</div>
					</div>
                </form>
            </div>
			<div class="bg-success" style="height: 12px; width: 100.08%"></div>
        </div>
    </div>
</div>