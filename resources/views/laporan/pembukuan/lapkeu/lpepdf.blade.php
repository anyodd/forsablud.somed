<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="reportpdf/bootstrap.min.css">

    <style>
        @page {
            margin-left: 1rem !important;
            margin-right: 1.5rem !important;
        }

        /* body {
            margin: 0px auto;
            padding: 0px 85px;
            width: 1024px;
        } */

        .header {
            border-bottom: 5px solid #000;
        }

        .header-image {
            position: relative;

        }

        .header-image img {
            width: 175px;
        }

        .header-image1 img {
            width: 200px;
        }

        .header-center {
            padding: 10px;
        }

        .table,
        .table tr,
        .table td,
        .table th {
            border: 1px solid #000;
        }

        /* table no border */
        .no-border,
        .header,
        .no-border tr,
        .no-border td,
        .no-border th {
            border-bottom: 1px solid #fff !important;
        }

        .table .no-border-bottom td {
            border-left: 1px solid #fff !important;
        }
    </style>

</head>

<body>
    <div class="header d-flex text-center align-content-center col-lg-12 justify-content-around align-items-center">
        <div class="header-center">
            <h4>BADAN LAYANAN UMUM PROVINSI/KABUPATEN/KOTA CIMACAN</h4>
            <h6>LAPORAN PERUBAHAN EKUITAS</h6>
            <h6>&nbsp;</h6>
            <h6>UNTUK PERIODE YANG BERAKHIR SAMPAI DENGAN 31 DESEMBER 2021 DAN 2020</h6>
        </div>
    </div>


    <div class="content mt-5">
        <table class="table table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th class="align-middle text-center">NO</th>
                    <th class="align-middle text-center">URAIAN</th>
                    <th class="text-center">2021</th>
                    <th class="text-center"> 2020</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center align-middle no-border">1</td>
                    <td class="text-start no-border">EKUITAS AWAL</td>
                    <td class="text-center no-border">xxx</td>
                    <td class="text-center no-border">xxx</td>
                </tr>
                <tr style="border-top: hidden">
                    <td class="text-center align-middle no-border">2</td>
                    <td class="text-start no-border">SURPLUS/DEFISIT-LO DAMPAK KUMULATIF</td>
                    <td class="text-center no-border">xxx</td>
                    <td class="text-center no-border">xxx</td>
                </tr>
                <tr style="border-top: hidden">
                    <td class="text-center align-middle no-border">3</td>
                    <td class="text-start no-border">PERUBAHAN KEBIJAKAN/KESALAHAN MENDASAR</td>
                    <td class="text-center no-border">xxx</td>
                    <td class="text-center no-border">xxx</td>
                </tr>
                <tr style="border-top: hidden">
                    <td class="text-center align-middle no-border">4</td>
                    <td class="ps-5 no-border" style="padding-left: 35pt !important;">KOREKSI NILAI PERSEDIAAN</td>
                    <td class="text-center no-border">xxx</td>
                    <td class="text-center no-border">xxx</td>
                </tr>
                <tr style="border-top: hidden">
                    <td class="text-center align-middle no-border">5</td>
                    <td class="ps-5 no-border" style="padding-left: 35pt !important;">SELISIH REVALUASI ASET TETAP</td>
                    <td class="text-center no-border">xxx</td>
                    <td class="text-center no-border">xxx</td>
                </tr>
                <tr style="border-top: hidden">
                    <td class="text-center align-middle no-border">6</td>
                    <td class="ps-5 no-border" style="padding-left: 35pt !important;">LAIN_LAIN</td>
                    <td class="text-center no-border">xxx</td>
                    <td class="text-center no-border">xxx</td>
                </tr>
                <tr style="border-top: hidden">
                    <td class="text-center align-middle ">7</td>
                    <td class="text-start ">EKUITAS AKHIR</td>
                    <td class="text-center ">xxx</td>
                    <td class="text-center ">xxx</td>
                </tr>
            </tbody>
        </table>
    </div>


</body>

</html>