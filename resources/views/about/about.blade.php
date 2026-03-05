@extends('layouts.template')

@section('content')
<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1></h1>
            </div>
            <div class="col-sm-6">
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-primary card-outline shadow">
                    <div class="card-body box-profile">
                        <div class="row">
                            <div class="col-6">
                                <img class="image" style="width: 20%" src="{{asset('template')}}/dist/img/logo_rs/logo_bpkp.png" alt="User profile picture">
                            </div>
                            <div class="col-6 text-right">
                                <img class="image" style="width: 15%" src="{{asset('template')}}//dist/img/logo_rs/logo_dan.png" alt="User profile picture">
                            </div>
                        </div>
                        <h3 class="profile-username text-center"><b>Aplikasi Forsa BLUD</b></h3>
                        <p class="text-center text-primary">Versi Aster 1.2</p>
                        <table style="font-size: 12pt">
                            <tr>
                                <td><b>Pengarah</b></td>
                                <td class="text-center" style="width: 5%">:</td>
                                <td>Deputi Kepala BPKP Bidang Akuntan Negara</td>
                            </tr>
                            <tr>
                                <td><b>Penanggung Jawab</b></td>
                                <td class="text-center">:</td>
                                <td>Direktur Pengawasan BLU, BLUD, BU Jasa Air, BUMD dan BUMDes</td>
                            </tr>
                            <tr>
                                <td><b>Wakil Penanggung Jawab</b></td>
                                <td class="text-center">:</td>
                                <td>Koordinator Pengawasan BLU dan BLUD</td>
                            </tr>
                            <tr>
                                <td><b>Tim Pengembang</b></td>
                                <td class="text-center">:</td>
                                <td>- Wahyujati Aryono Widi</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Atanasius Widarwanto</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Bayu Imam Prakoso</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Lastri Junaedah</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Eko Suryono</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Jati Kusuma</td>
                            </tr>
							 <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Arnold Restu @nyodd</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Andicha Pratama Rendra</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Eko Ferry Zuprianto</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Laras Handayani</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Fitrah Aditia</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Syafri Ali Putra</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td>- Martya Atika Diwasasri</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection