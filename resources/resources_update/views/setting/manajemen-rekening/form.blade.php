@php
    if ($action == 'edit') {
        $route = ['setting.manajemen-rekening.update', $Ko_Rk];
        $method = 'PUT';
        $title = 'Edit Satuan';
    } else if ($action == 'delete') {
        $route = ['setting.manajemen-rekening.destroy', $Ko_Rk];
        $method = 'DELETE';
        $title = 'Hapus Satuan';
    } else {
        $route = ['setting.manajemen-rekening.store', $Ko_Rk];
        $method = 'POST';
        $title = 'Tambah Satuan';
    }
@endphp
{!! Form::model($model, [
    'class' => 'form',
    'id' => 'form',
    'method' => 'POST',
    'route' => $route,
    'autocomplete' => 'off',
    'novalidate',
]) !!}
    {!! Form::hidden('_method', $method) !!}
    @if ($action == 'delete')
    <div class="text-center">
        <h4 class="modal-title w-100">Anda Yakin?</h4>
        <div class="modal-body">
            <p>Apakah anda yakin untuk menghapus rekening <strong>{{ $model->Ur_Rk }}</strong>? Data yang sudah dihapus tidak dapat dikembalikan.</p>
        </div>
        <div class="modal-footer justify-content-center">
            {!! Form::button('<i class="fa fa-trash"></i> Hapus', ['type' => 'submit', 'class' => 'btn btn-danger waves-effect waves-light']) !!}
            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
        </div>
    </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {!! Form::label('Ko_Rk', 'Kode Rekening', ['class' => 'col-sm-4 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-2">
                            {!! Form::text('Ko_Rk', $model->Ko_Rk ?? 1, [
                                'class' => 'form-control',
                                'id' => 'Ko_Rk',
                                'data-inputmask' => data_inputmask_numeric(),
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('Ur_Rk', 'Nama Rekening', ['class' => 'col-sm-4 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('Ur_Rk', null, [
                                'class' => 'form-control',
                                'id' => 'Ur_Rk',
                                'maxlength' => 255,
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 text-right">
                            {!! Form::button('<i class="fa fa-save"></i> Simpan', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                            {!! Form::button('<i class="fa fa-times"></i> Batal', ['type' => 'button', 'class' => 'btn btn-secondary ml-1', 'data-dismiss' => 'modal']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
{!! Form::close() !!}
