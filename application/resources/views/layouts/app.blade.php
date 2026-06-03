<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('avatars/cdm2026.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/fixedHeader.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/moncss.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/css2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div id="app">
       
    </div>
    <main class="py-4">
        @yield('content')
    </main>
    </div>
</body>



<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>


<script>
    $(document).ready(function () {
        $('#cnxtable tbody tr').each(function () {
            let prediction = $(this).find('td:nth-child(2) li').text().trim();
            let result = $(this).find('td:nth-child(4) li').text().trim();

            if (prediction === result && prediction !== '') {
                $(this).css('background-color', '#d4edda');
            }
        });
    });
</script>