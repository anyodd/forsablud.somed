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
                        <h3 class="profile-username text-center"><b>Tutorial Forsa BLUD</b></h3>
                        <p class="text-center text-primary">Versi Aster 1.2</p>
                        <table style="font-size: 12pt">
                            <tr>
                                <td><b>Ebook</b></td>
                                <td class="text-center" style="width: 5%">:</td>
                                <td><a href="{{asset('template')}}/MANUAL_USER_FORSA_BLUD.pdf" target="_blank">Manual User Forsa BLUD</a></td>
                            </tr>
                            <tr>
                                <td><b>Video</b></td>
                                <td class="text-center">:</td>
                                <td><a href="https://youtube.com/playlist?list=PLYP1fvWt1tzd6HduwsWCbCzHN1XgvnVnl" target="_blank">Video Forsa BLUD</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection