@extends('layouts.template')
@section('title', 'Daftar Transaksi')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {{-- <span id="success_message"></span> --}}
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                    <h5 class="card-title font-weight-bold">Rebuild Jurnal</h5> 
                    </div>
                    <div class="card-body py-0">
                        <form method="post" id="sample_form">
                            @csrf
                            <div class="form-group row mb-0">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col">
                                            <code>Pilih Transaksi</code>
                                            <select name="transaksi" class="form-control select2" id="" disabled="">
                                                <option value="0">-- Pilih Transaksi --</option>
                                                <option value="1">Pendapatan</option>
                                                <option value="2">Belanja</option>
                                                <option value="3">Pengesahan</option>
                                            </select>
                                        </div>

                                        <div class="col">
                                            <code>Periode Bulan</code>
                                            <select name="bidang" class="form-control select2" id="" disabled="">
                                                <option value="0">-- Pilih Bulan --</option>
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">Juli</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>

                                        <div class="col">
                                            <code>.</code>
                                            <button type="submit" id="save" class="col btn btn-warning float-right" name="submit">
                                                <i class="fa-solid fa-gear"> REBUILD</i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group" id="process" style="display:none;">
        <div class="progress" style="height: 50px;">
            <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"  aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-success">
                <div class="modal-body">
                    <i class="fas fa-check"></i><p>Rebuild Jurnal Berhasil&hellip;</p>
                </div>
            </div>
        </div>
    </div>
                
</section>
@endsection

@section('script')
<script type="text/javascript">
    $('#reservation').daterangepicker()
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'MM/DD/YYYY hh:mm A'
        }
    });

    $(function() {
        $('.select2').select2()
        $("#table").DataTable({
            "responsive": true,
            "pageLength": 100,
            "buttons": ["excel"]
        }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

        $('#sample_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"{{ route('rebuild.process') }}",
                method:"POST",
                data:$(this).serialize(),
                beforeSend:function()
                {
                    $('#save').attr('disabled', 'disabled');
                    $('#process').css('display', 'block');
                },
                    success:function(data)
                {
                var percentage = 0;

                var timer = setInterval(function(){
                percentage = percentage + 20;
                progress_bar_process(percentage, timer);
                }, 1000);
                }
            })
        });
    })

    function progress_bar_process(percentage, timer)
    {
        $('.progress-bar').css('width', percentage + '%');
        $('.progress-bar').html(percentage + '%');
        if(percentage > 100)
        {
            clearInterval(timer);
            $('#sample_form')[0].reset();
            $('#process').css('display', 'none');
            $('.progress-bar').css('width', '0%');
            $('#save').attr('disabled', false);
            // $('#success_message').html("<div class='alert alert-success'>Rebuild Jurnal Berhasil</div>");
            $("#smallModal").modal('show');
            setTimeout(function(){
            $('#success_message').html('');
            $("#smallModal").modal('hide');
            }, 5000);
        }
    }

</script>
@endsection
