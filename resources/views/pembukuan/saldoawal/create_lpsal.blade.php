<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@yield('title')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- About Me Box -->
                            <div class="card card-info">

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form action="{{ route('saldoawal.store_lpsal') }}" method="POST">
                                        @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Tag">Uraian</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select name="Ko_id" class="form-control" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                                                    <option value="">--Pilih Uraian--</option>
                                                    @foreach ($pf_lpsal as $item)
                                                        <option value="{{$item->id}}">{{ $item->ur_lpsal}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nilai</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="soaw_Rp" placeholder="Nilai Saldo Awal" class="form-control desimal" value="{{ old('soaw_Rp') ?? '' }}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                                            <a href="#" data-dismiss="modal"class="btn btn-success float-right"> <i class="far fa-arrow-alt-circle-left"> Back</i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
