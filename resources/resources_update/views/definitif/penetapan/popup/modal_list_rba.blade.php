<div class="modal fade" id="listRba">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ringkasan Rencana Bisnis dan Anggaran</h4>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <td class="text-center" colspan="12">
                                                    PEMERINTAH {{ nm_pemda() ?? 'DEMO' }} <br>
                                                    {{ nm_unit() ?? 'DEMO' }}
                                                    <br>
                                                    RINGKASAN RENCANA BISNIS DAN ANGGARAN
                                                    <br>
                                                    PENDAPATAN, BELANJA DAN PEMBIAYAAN PEMBIAYAAN TAHUN ANGARAN
                                                    {{ Tahun() ?? 'DEMO' }} <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" style="width: 3px">No</td>
                                                <td class="text-center" colspan="6">Uraian</td>
                                                <td class="text-center" colspan="5">Jumlah</td>

                                            </tr>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td class="text-center" style="width: 3px">2</td>
                                                <td class="text-center" colspan="5">3</td>
                                                <td class="text-center" colspan="5">4</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($gbrincirba as $gr => $rincirba)
                                            <tr>
                                                <td style="text-align: left">{{ $loop->iteration }}.</td>
                                                <td colspan="6"><strong style="color: black"> {{ $gr }} </strong>
                                                </td>
                                                <td colspan="5" style="text-align: right"> <strong style="color: black">
                                                        {{ number_format($rincirba['subtotal'], 2, ',', '.') }} </strong> </td>
                                            </tr>
                                            @foreach ($rincirba['subrincian'] as $key => $item)
                                            <tr>
                                                <td style="text-align: left"></td>
                                                <td>{{ $item[0]->Ko_Rc }}</td>
                                                {{-- <td colspan="1"></td> --}}
                                                <td colspan="5" style="text-align: left">{{ $item[0]->Ur_Rc1 }}</td>
                                                <td colspan="5" style="text-align: right">
                                                    {{ number_format($item[0]->To_Rp, 2, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                    <i class="fas fa-times"></i>Tutup
                </button>
            </div>
            </form>
        </div>
    </div>
</div>