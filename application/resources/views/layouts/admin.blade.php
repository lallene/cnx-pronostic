<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>

    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('avatars/cmd2026.ico') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/css2.css') }}">
         <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div id="admin-layout">
        <header>
                        
        </header>
        <main class="container my-4">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
