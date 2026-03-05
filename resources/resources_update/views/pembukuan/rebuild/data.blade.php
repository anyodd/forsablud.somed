<div class="col-md-12">
    <div class="card card-info mt-2">
        <div class="card-header bg-info">
            <h5 class="card-title font-weight-bold">Daftar Transaksi</h5> 
        </div>
        <div class="card-body">
            <table id="table" class="table table-sm table-bordered table-striped" style="width: 100;font-size: 10pt">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 3%">No</th>
                        <th class="text-center">Bidang</th>
                        <th class="text-center">Jenis Transaksi</th>
                        <th class="text-center">No Bukti</th>
                        <th class="text-center" style="width: 6%">Tanggal</th> 
                        <th class="text-center">Uraian</th>
                        <th class="text-center">Rupiah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$loop->iteration}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>