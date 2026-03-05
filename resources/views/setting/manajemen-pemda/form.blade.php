@php
    if ($action == 'edit') {
        $route = ['setting.manajemen-pemda.update', $pemda->code];
        $method = 'PUT';
        $title = 'Edit Pemda';
    }  else if ($action == 'delete') {
        $route = ['setting.manajemen-pemda.destroy', $pemda->code];
        $method = 'DELETE';
        $title = 'Hapus Pemda';
    } else {
        $route = ['setting.manajemen-pemda.store'];
        $method = 'POST';
        $title = 'Tambah Pemda';
        $password = true;
    }
@endphp
{!! Form::model($pemda, [
    'class' => 'form needs-validation',
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
				<p>Apakah anda yakin untuk menghapus Pemerintah Daerah <strong>{{ $pemda->Ur_Pemda }}</strong>? Data yang sudah dihapus tidak dapat dikembalikan.</p>
			</div>
			<div class="modal-footer justify-content-center">
				{!! Form::button('<i class="fa fa-trash"></i> Hapus', ['type' => 'submit', 'class' => 'btn btn-danger waves-effect waves-light']) !!}
				<button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
			</div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-2 justify-content-center">
                    <img src="{{ asset('template') }}/dist/img/icon_login/profile.png" alt="user" class="rounded-circle" width="100%">
                </div>
                <div class="col-10">
				@if ($action == 'edit')
					<div class="form-group row p-2">
                        {!! Form::label('id_kabkota', 'Pemerintah Daerah', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('id_kabkota', $kabkotaold, null, [
                                'class' => 'form-control select2',
                                'id' => 'id_kabkota',
                                'required',
                            ]) !!}
                        </div>
                    </div>
				 @else
					 <div class="form-group row p-2">
                        {!! Form::label('id_kabkota', 'Pemerintah Daerah', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('id_kabkota', $kabkotanew, null, [
                                'class' => 'form-control select2',
                                'id' => 'id_kabkota',
                                'required',
                            ]) !!}
                        </div>
                    </div>
				@endif
                    <div class="form-group row p-2">
                        {!! Form::label('Ibukota', 'Nama Ibukota', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('Ibukota', null, [
                                'class' => 'form-control',
                                'id' => 'Ibukota',
                                'required',
								'rows' => 2,
                                'maxlength' => 50,
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row p-2">
                        {!! Form::label('Ur_Kpl', 'Kepala daerah', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::textarea('Ur_Kpl', null, [
                                'class' => 'form-control',
                                'id' => 'Ur_Kpl',
                                'rows' => 2,
                                'maxlength' => 50,
                            ]) !!}
                        </div>
                    </div>    
					<div class="form-group row p-2">
                        {!! Form::label('Ur_Sekda', 'Sekretariat Daerah', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::textarea('Ur_Sekda', null, [
                                'class' => 'form-control',
                                'id' => 'Ur_Sekda',
                                'rows' => 2,
                                'maxlength' => 50,
                            ]) !!}
                        </div>
                    </div> 
					<div class="form-group row p-2">
                        {!! Form::label('Ur_PPKD', 'BUD', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::textarea('Ur_PPKD', null, [
                                'class' => 'form-control',
                                'id' => 'Ur_PPKD',
                                'rows' => 2,
                                'maxlength' => 50,
                            ]) !!}
                        </div>
                    </div> 
                    <div class="form-group row p-2">
                        <div class="col-12 text-right">
                            {!! Form::button('<i class="fa fa-save"></i> Simpan', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                            {!! Form::button('<i class="fa fa-times"></i> Batal', ['type' => 'button', 'class' => 'btn btn-secondary ml-2', 'data-dismiss' => 'modal']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
{!! Form::close() !!}
