{{-- resources/views/resultat/classement.blade.php --}}
@extends('layouts.admin')

@section('title', 'Classement Utilisateurs')

@section('content')
    <style>
        :root {
            --wc-gold: #C9A84C;
            --wc-gold-light: #F0CE7A;
            --wc-navy: #0A1628;
            --wc-navy-mid: #132040;
            --wc-red: #C8102E;
            --wc-green: #006847;
            --wc-white: #F5F0E8;
            --wc-silver: #B0B8C4;
            --r-sm: 4px;
            --r-md: 8px;
            --r-lg: 12px;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background: var(--wc-navy);
            color: var(--wc-white);
        }

        .wc-stripe {
            height: 4px;
            background: linear-gradient(90deg, var(--wc-red), var(--wc-gold), var(--wc-green), var(--wc-red));
        }

        .wc-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: .03;
            background-image:
                repeating-linear-gradient(0deg, transparent, transparent 59px, rgba(255, 255, 255, .9) 59px, rgba(255, 255, 255, .9) 60px),
                repeating-linear-gradient(90deg, transparent, transparent 59px, rgba(255, 255, 255, .9) 59px, rgba(255, 255, 255, .9) 60px);
        }

        .wc-header {
            position: relative;
            z-index: 10;
            background: var(--wc-navy-mid);
            border-bottom: 1px solid rgba(201, 168, 76, .3);
            padding: 0 28px;
        }

        .wc-header-inner {
            height: 64px;
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .wc-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .wc-logo img {
            height: 38px;
        }

        .wc-logo-badge {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--wc-gold);
            color: var(--wc-navy);
            font-family: 'Oswald', sans-serif;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .wc-logo-text {
            font-family: 'Oswald', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--wc-gold);
            letter-spacing: 1px;
        }

        .wc-nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .wc-nav-link,
        .wc-nav-logout,
        .wc-nav-badge {
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
        }

        .wc-nav-link {
            color: var(--wc-silver);
            padding: 8px 12px;
        }

        .wc-nav-link:hover,
        .wc-nav-link.active {
            color: var(--wc-gold);
        }

        .wc-nav-badge {
            color: var(--wc-gold);
            border: 1px solid rgba(201, 168, 76, .3);
            background: rgba(201, 168, 76, .12);
            padding: 6px 12px;
            border-radius: var(--r-sm);
        }

        .wc-nav-logout {
            color: var(--wc-red);
            border: 1px solid var(--wc-red);
            padding: 6px 14px;
            border-radius: var(--r-sm);
        }

        .wc-nav-logout:hover {
            background: var(--wc-red);
            color: #fff;
        }

        .wc-hero {
            position: relative;
            z-index: 10;
            background: rgba(19, 32, 64, .97);
            border-bottom: 1px solid rgba(201, 168, 76, .2);
            padding: 22px 28px;
        }

        .wc-hero-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .wc-eyebrow {
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            letter-spacing: 3px;
            color: var(--wc-gold);
            text-transform: uppercase;
        }

        .wc-page-title {
            font-family: 'Oswald', sans-serif;
            font-size: 28px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .wc-page-title span {
            color: var(--wc-gold);
        }

        .wc-flag-chip {
            display: inline-block;
            margin-top: 8px;
            margin-right: 6px;
            padding: 3px 10px;
            font-family: 'Oswald', sans-serif;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .f-usa {
            background: rgba(200, 16, 46, .2);
            color: #FF6B7A;
        }

        .f-can {
            background: rgba(200, 16, 46, .12);
            color: #FF9999;
        }

        .f-mex {
            background: rgba(0, 104, 71, .2);
            color: #4DBA8C;
        }

        .wc-main {
            position: relative;
            z-index: 10;
            max-width: 1400px;
            margin: 0 auto;
            padding: 28px;
        }

        .wc-title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 16px;
        }

        .wc-title-row h2 {
            font-family: 'Oswald', sans-serif;
            color: var(--wc-white);
            text-transform: uppercase;
            font-weight: 700;
            margin: 0;
        }

        .wc-stats-badge {
            background: rgba(201, 168, 76, .1);
            border: 1px solid rgba(201, 168, 76, .35);
            color: var(--wc-gold);
            padding: 10px 16px;
            border-radius: 30px;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
        }

        .wc-alert-success {
            background: rgba(0, 104, 71, .2);
            border: 1px solid rgba(0, 104, 71, .5);
            color: #4DBA8C;
            padding: 12px 18px;
            border-radius: var(--r-md);
            margin-bottom: 20px;
        }

        .wc-pills {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 8px;
        }

        .wc-pills .nav-link {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(201, 168, 76, .25);
            color: var(--wc-silver);
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            border-radius: var(--r-sm);
            white-space: nowrap;
        }

        .wc-pills .nav-link.active {
            background: var(--wc-gold);
            color: var(--wc-navy);
            border-color: var(--wc-gold);
        }

        .wc-table-panel {
            background: rgba(255, 255, 255, .03);
            border: 1px solid rgba(201, 168, 76, .2);
            border-radius: var(--r-lg);
            padding: 22px;
        }

        .tab-pane h4,
        .wc-table-title {
            font-family: 'Oswald', sans-serif;
            color: var(--wc-gold);
            text-transform: uppercase;
            letter-spacing: 1px;
        }


        @media(max-width:768px) {

            .wc-header-inner,
            .wc-hero-inner,
            .wc-title-row {
                flex-direction: column;
                align-items: flex-start;
                height: auto;
                padding: 14px 0;
            }

            .wc-nav {
                flex-wrap: wrap;
            }

            .wc-main {
                padding: 16px;
            }
        }


        .wc-ranking-wrap {

            position: relative;

            overflow: hidden;

            border-radius: 28px;

            background:
                linear-gradient(145deg,
                    rgba(18, 22, 40, .96),
                    rgba(8, 10, 22, .98));

            border: 1px solid rgba(255, 255, 255, .05);

            box-shadow:
                0 12px 35px rgba(0, 0, 0, .35),
                inset 0 1px 0 rgba(255, 255, 255, .03);

            padding: 18px;

            backdrop-filter: blur(18px);
        }


        .wc-ranking-header {

            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 18px;
        }

        .wc-ranking-header h3 {

            margin: 0;

            color: #fff;

            font-size: 20px;
            font-weight: 800;
        }


        .wc-ranking-table {

            width: 100% !important;

            border-collapse: separate !important;

            border-spacing: 0 12px !important;

            background: transparent !important;
        }


        .wc-ranking-table thead th {

            text-align: center !important;

            vertical-align: middle !important;

            background:
                linear-gradient(135deg,
                    rgba(255, 255, 255, .08),
                    rgba(255, 255, 255, .03));

            color: #fff;

            font-size: 12px;
            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: 1px;

            padding: 16px;

            border: none !important;
        }


        .wc-ranking-table tbody tr {

            transition:
                transform .18s ease,
                background .18s ease,
                box-shadow .18s ease;

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, .03),
                    rgba(255, 255, 255, .015));

            border-radius: 20px;
            background-color: #00800000 !important;
        }

        .wc-ranking-table tbody tr:hover {

            transform: translateY(-2px);

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, .06),
                    rgba(255, 255, 255, .03));

            box-shadow:
                0 10px 25px rgba(0, 0, 0, .25);
        }


        .wc-ranking-table tbody td {

            padding: 18px 16px;

            border: none !important;

            vertical-align: middle;

            color: #fff;

            font-size: 14px;

            text-align: center;
        }

        /* player column */

        .wc-ranking-table tbody td:nth-child(2) {

            text-align: left;
        }


        .wc-player-cell {

            display: flex;
            align-items: center;

            gap: 14px;
        }

        .wc-player-avatar-img {

            width: 52px;
            height: 52px;

            object-fit: cover;

            border-radius: 50%;

            border: 2px solid rgba(255, 255, 255, .08);

            box-shadow:
                0 4px 12px rgba(0, 0, 0, .25);
        }

        .wc-player-content {

            display: flex;
            flex-direction: column;
        }

        .wc-player-name {

            font-weight: 700;

            font-size: 14px;

            color: #fff;
        }

        .wc-player-realname {

            font-size: 12px;

            color: rgba(255, 255, 255, .6);
        }


        .wc-rank-badge {

            width: 40px;
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            font-weight: 800;

            font-size: 14px;
        }

        .wc-rank-1 {

            background:
                linear-gradient(135deg,
                    #ffd54a,
                    #ffb300);

            color: #111;
        }

        .wc-rank-2 {

            background:
                linear-gradient(135deg,
                    #dfe6e9,
                    #95a5a6);

            color: #111;
        }

        .wc-rank-3 {

            background:
                linear-gradient(135deg,
                    #d7a86e,
                    #8d5a2b);

            color: #fff;
        }

        .wc-rank-other {

            background:
                rgba(255, 255, 255, .08);

            color: #fff;
        }

        .wc-progress-wrap {

            display: flex;
            flex-direction: column;

            gap: 6px;
        }

        .wc-progress-bar-bg {

            height: 10px;

            overflow: hidden;

            border-radius: 999px;

            background:
                rgba(255, 255, 255, .08);
        }

        .wc-progress-bar-fill {

            height: 100%;

            border-radius: 999px;

            background:
                linear-gradient(90deg,
                    #ffd54a,
                    #ffb300);

            box-shadow:
                0 0 12px rgba(255, 193, 7, .45);
        }

        .wc-progress-bottom {

            display: flex;
            justify-content: flex-end;
        }

        .wc-progress-pct {

            font-size: 11px;

            color: rgba(255, 255, 255, .65);
        }


        .dataTables_wrapper {

            color: #fff;
        }

        .dataTables_filter {

            margin-bottom: 18px;
        }

        .dataTables_filter input,
        .dataTables_length select {

            height: 44px;

            border-radius: 14px;

            border: 1px solid rgba(255, 255, 255, .08);

            background:
                rgba(255, 255, 255, .05);

            color: #fff;

            padding: 0 14px;
        }

        .dataTables_filter input:focus {

            border-color: #d7b85c;

            box-shadow:
                0 0 0 4px rgba(215, 184, 92, .15);

            outline: none;
        }

        .dataTables_info,
        .dataTables_length label,
        .dataTables_filter label {

            color: rgba(255, 255, 255, .65) !important;
        }


        .dataTables_paginate {

            margin-top: 18px !important;
        }

        .dataTables_paginate .paginate_button {

            border: none !important;

            background:
                rgba(255, 255, 255, .04) !important;

            color: #fff !important;

            border-radius: 12px !important;

            padding: 8px 14px !important;

            margin: 0 4px;
        }

        .dataTables_paginate .paginate_button.current {

            background:
                linear-gradient(135deg,
                    #d7b85c,
                    #b69239) !important;

            color: #071426 !important;
        }


        @media (max-width: 768px) {

            .wc-player-avatar-img {

                width: 42px;
                height: 42px;
            }

            .wc-ranking-table tbody td {

                padding: 14px 10px;
            }
        }

        .wc-footer {
            position: relative;
            z-index: 10;
            border-top: 1px solid rgba(201, 168, 76, .15);
            padding: 14px 28px;
            text-align: center;
            margin-top: 24px;
        }

        .wc-footer-text {
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            color: rgba(255, 255, 255, .2);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .wc-footer-text span {
            color: var(--wc-gold);
        }
    </style>

    <div class="wc-stripe"></div>
    <div class="wc-bg"></div>

    <header class="wc-header">
        <div class="wc-header-inner">
            <div class="wc-logo">
                @if (file_exists(public_path('avatars/logo.webp')))
                    <img src="{{ asset('avatars/logo.webp') }}" alt="Logo">
                @else
                    <div class="wc-logo-badge">CNX<br>ADM</div>
                @endif
                <span class="wc-logo-text">Game Changer</span>
            </div>

            <nav class="wc-nav">
                <a href="{{ route('dashboard') }}" class="wc-nav-link">Administration</a>
                <a href="{{ route('resultat.index') }}" class="wc-nav-link">Résultats</a>
                <span class="wc-nav-badge">⚙ Classements</span>
                <a href="{{ route('users.index') }}" class="wc-nav-link">Utilisateurs</a>
                <form method="POST" action="{{ route('logoutadmin') }}" style="display:inline;">
                        @csrf
                    <button type="submit" class="wc-nav-link" >
                        Déconnexion
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <section class="wc-hero">
        <div class="wc-hero-inner">
            <div>
                <div class="wc-eyebrow">Administration · Coupe du Monde 2026</div>
                <div class="wc-page-title">Classements des <span>Utilisateurs</span></div>

                <div>
                    <span class="wc-flag-chip f-usa">🇺🇸 USA</span>
                    <span class="wc-flag-chip f-can">🇨🇦 Canada</span>
                    <span class="wc-flag-chip f-mex">🇲🇽 Mexique</span>
                </div>
            </div>
        </div>
    </section>

    <main class="wc-main">

        @if (session('success'))
            <div class="wc-alert-success">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif

        <div class="wc-title-row">
            <div>
                <div class="wc-eyebrow">Compétition 2026</div>
                <h2>Scoreboard général</h2>
            </div>

            <div class="wc-stats-badge">
                {{ ($usersGlobal ?? ($users ?? collect()))->count() }} parieurs actifs
            </div>
        </div>

        <ul class="nav nav-pills wc-pills mb-4" id="classementTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#global" type="button">🏆
                    Global</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#phase_groupes" type="button">⚽ Phase de
                    groupes</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#huitiemes" type="button">16
                    Huitièmes</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#quarts" type="button">8 Quarts</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#demi_finales" type="button">4
                    Demi-finales</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#finale" type="button">👑 Finale</button>
            </li>
        </ul>

       <div class="tab-content wc-table-panel">

    @include('admin.partials.classement-table', [
        'tabId' => 'global',
        'active' => true,
        'tableId' => 'tableGlobal',
        'phase' => 'global',
        'users' => $usersGlobal ?? ($users ?? collect()),
        'title' => 'Classement Général',
    ])

    @include('admin.partials.classement-table', [
        'tabId' => 'phase_groupes',
        'active' => false,
        'tableId' => 'tableGroupes',
        'phase' => 'Phase de groupes',
        'users' => $usersPhaseGroupes ?? collect(),
        'title' => 'Phase de Groupes',
    ])

    @include('admin.partials.classement-table', [
        'tabId' => 'huitiemes',
        'active' => false,
        'tableId' => 'tableHuitiemes',
        'phase' => 'Huitièmes',
        'users' => $usersHuitiemes ?? collect(),
        'title' => 'Huitièmes de finale',
    ])

    @include('admin.partials.classement-table', [
        'tabId' => 'quarts',
        'active' => false,
        'tableId' => 'tableQuarts',
        'phase' => 'Quarts',
        'users' => $usersQuarts ?? collect(),
        'title' => 'Quarts de finale',
    ])

    @include('admin.partials.classement-table', [
        'tabId' => 'demi_finales',
        'active' => false,
        'tableId' => 'tableDemis',
        'phase' => 'Demi-finales',
        'users' => $usersDemis ?? collect(),
        'title' => 'Demi-finales',
    ])

    @include('admin.partials.classement-table', [
        'tabId' => 'finale',
        'active' => false,
        'tableId' => 'tableFinale',
        'phase' => 'Finale',
        'users' => $usersFinale ?? collect(),
        'title' => 'Finale',
    ])

</div>

    </main>

    <footer class="wc-footer">
        <div class="wc-footer-text">
            Concentrix · Game Changer · FIFA World Cup 2026™ ·
            <span>Developed by Lallene ACHI</span>
        </div>
    </footer>

@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $('.wc-ranking-table').each(function() {

                const table = $(this);

                if ($.fn.DataTable.isDataTable(table)) {
                    table.DataTable().destroy();
                }

                const phase = table.data('phase') || 'global';

                table.DataTable({
                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: "{{ route('admin.classement.data') }}",
                        type: "GET",
                        data: function(d) {
                            d.phase = phase;
                        }
                    },

                    responsive: true,
                    pageLength: 10,
                    searching: true,
                    ordering: false,

                    columns: [
                        {
                            data: 'rank_badge',
                            name: 'rank',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'joueur',
                            name: 'users.name'
                        },
                        {
                            data: 'projet_service',
                            name: 'users.projet_service'
                        },
                        {
                            data: 'fonction',
                            name: 'users.fonction'
                        },
                        {
                            data: 'xp',
                            name: 'users.xp'
                        },
                        {
                            data: 'points',
                            name: 'user_scores.points'
                        },
                        {
                            data: 'progression',
                            name: 'progression',
                            orderable: false,
                            searchable: false
                        }
                    ],

                    language: {
                        processing: "Chargement...",
                        search: "Rechercher :",
                        lengthMenu: "Afficher _MENU_ joueurs",
                        info: "_START_ à _END_ sur _TOTAL_ joueurs",
                        infoEmpty: "Aucun joueur",
                        zeroRecords: "Aucun joueur trouvé",
                        paginate: {
                            previous: "‹",
                            next: "›"
                        }
                    }
                });
            });
        });
    </script>
@endpush