<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        body {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: "Arial, Helvetica, sans-serif" ;
        }

        .header-logo {
            width: 100px;
        }

        .header-image {
            width: 80px;
            height: 80px;
        }

        thead { display: table-header-group; }
        tr { page-break-inside:avoid !important; }
        tfoot { display: table-footer-group; }

        .table-export-header th {
            border: 1px solid transparent;
            padding: 0;
            line-height: 30px;
            white-space: nowrap;
            word-wrap: normal;
        }

        .table-export tbody,
        .table-export thead th {
            border: 1px solid #000000;
        }

        .table-export thead th,
        .table-export tbody td {
            border-right: 1px solid #000000;
            padding: 5px 15px;
        }

        .table-export thead th {
            padding-top: 20px;
            padding-bottom: 20px;
            /* background-color: #4372d6; */
            background-color: whitesmoke;
            /* color: #ffffff; */
            color: #000000;
        }

        .border-none {
            border: none !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            border-bottom: none !important;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
    {{-- Custom CSS --}}
    @stack('styles')
</head>
<body>
    @include('export.header')
    <br>
    @yield('content')
    <br>
    @if(isset($nofooter) && $nofooter==true )
    @else
    @include('export.footer')
    @endif
</body>
</html>
