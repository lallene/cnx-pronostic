@extends('layouts.app')

@section('title', 'Les Matchs')

@section('content')
  
<style>

.cnx-point-box {
    margin-top: 6px;
    padding: 6px 10px;
    border-radius: 10px;
    background: rgba(255, 255, 255, .06);
    border: 1px solid rgba(255, 255, 255, .08);
    text-align: center;
}

.cnx-point-main {
    display: block;
    font-weight: 900;
    color: #f0ce7a;
    font-size: 13px;
}

.cnx-point-box small {
    display: block;
    margin-top: 2px;
    color: rgba(255, 255, 255, .55);
    font-size: 10px;
}

.cnx-point-info.pending {
    margin-top: 6px;
    display: inline-block;
    color: #93c5fd;
    font-size: 11px;
    font-weight: 700;
}



</style>


    <meta name="csrf-token" content="{{ csrf_token() }}">


    @if (isset($gamificationEvents) && $gamificationEvents->isNotEmpty())
        <div id="rewardOverlay" class="reward-overlay">
            <div class="reward-card">
                <div class="reward-title">🎉 Résumé de ton absence</div>

                @foreach ($gamificationEvents as $event)
                    <div class="reward-item">
                        <strong>{{ $event->title }}</strong>
                        <span>{{ $event->message }}</span>
                    </div>
                @endforeach

                <button onclick="closeRewardOverlay()" class="reward-btn">
                    Continuer
                </button>
            </div>
        </div>
    @endif
    <div class="cnx-stripe"></div>

    <div>

        {{-- HEADER --}}
        <header class="cnx-header">

            <div class="cnx-header-inner">

                <a href="{{ route('home') }}" class="cnx-logo">
                    <div class="cnx-logo-badge">
                        Game Changer
                    </div>
                </a>

                <nav class="cnx-nav">

                    <a href="{{ route('home') }}" class="cnx-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        Pronostics
                    </a>

                    <a href="{{ route('classement') }}"
                        class="cnx-nav-link {{ request()->routeIs('classement') ? 'active' : '' }}">
                        Classements
                    </a>

                    <a href="{{ route('duels') }}" class="cnx-nav-link {{ request()->routeIs('duels') ? 'active' : '' }}">
                        Duels
                    </a>

                    <a href="{{ route('guide') }}" class="cnx-nav-link {{ request()->routeIs('guide') ? 'active' : '' }}">
                        Aide
                    </a>

                    <form method="POST" action="{{ route('logout.user') }}" style="display:inline;" >
                        @csrf

                        <button type="submit" class="cnx-nav-link"style=" background-color: #a11a1ad4; color: white;">
                            Déconnexion
                        </button>
                    </form>
                </nav>

            </div>

        </header>

        {{-- HERO --}}
        <div class="cnx-hero">
            <div class="cnx-hero-inner">
                <div>
                    <div class="cnx-eyebrow">Concentrix · Édition Spéciale</div>
                    <div class="cnx-title">Coupe du Monde<br><span>FIFA 2026™</span></div>
                    <div class="wc-hero-flags">
                        <span class="wc-flag-chip f-usa">🇺🇸 USA</span>
                        <span class="wc-flag-chip f-can">🇨🇦 Canada</span>
                        <span class="wc-flag-chip f-mex">🇲🇽 Mexique</span>
                    </div>
                </div>

                <div class="cnx-stat-row">

                    {{-- MATCHS --}}
                    <div class="cnx-stat-card">
                        <div class="cnx-stat-icon">⚽</div>

                        <span class="cnx-stat-value" id="statMatches">
                            {{ $match_joue }}/{{ $nbre_matches }}
                        </span>

                        <span class="cnx-stat-label">Matchs joués</span>

                        @php
                            $matchPct = $nbre_matches > 0 ? round(($match_joue / $nbre_matches) * 100) : 0;
                        @endphp

                        <div class="cnx-stat-progress">
                            <div class="cnx-stat-progress-bar">
                                <div id="statMatchProgress" class="cnx-stat-progress-fill"
                                    style="width: {{ $matchPct }}%;"></div>
                            </div>

                            <small id="statMatchPercent">{{ $matchPct }}%</small>
                        </div>
                    </div>

                    {{-- POINTS --}}
                    <div class="cnx-stat-card cnx-glow-card">
                        <div class="cnx-stat-icon">🏆</div>

                        <span class="cnx-stat-value cnx-gold" id="statPoints">
                            {{ $points }}
                        </span>

                        <span class="cnx-stat-label">Mes points</span>

                        <div class="cnx-mini-info" id="statXp">
                            ⚡ {{ Auth::user()->xp ?? 0 }} XP
                        </div>
                    </div>

                    {{-- CLASSEMENT --}}
                    <div class="cnx-stat-card">
                        <div class="cnx-stat-icon">👑</div>

                        <span class="cnx-stat-value" id="statClassement">
                            {{ $classement ?? '—' }}/{{ $Nbreusers }}
                        </span>

                        <span class="cnx-stat-label">Classement</span>

                        @php
                            $topPercent =
                                $Nbreusers > 0 && $classement
                                    ? round((($Nbreusers - $classement + 1) / $Nbreusers) * 100)
                                    : 0;
                        @endphp

                        <div class="cnx-ranking-tier" id="statTier">
                            @if (!$classement)
                                🎮 Non classé
                            @elseif ($classement == 1)
                                🥇 Champion
                            @elseif ($classement <= 3)
                                🏆 Top 3
                            @elseif ($classement <= 10)
                                🔥 Top 10
                            @elseif ($topPercent >= 50)
                                ⚡ Top {{ $topPercent }}%
                            @else
                                🎮 Challenger
                            @endif
                        </div>
                    </div>

                    {{-- STREAK --}}
                    <div class="cnx-stat-card">
                        <div class="cnx-stat-icon">🔥</div>

                        <span class="cnx-stat-value" id="statCurrentStreak">
                            {{ Auth::user()->current_streak ?? 0 }}
                        </span>

                        <span class="cnx-stat-label">Série actuelle</span>

                        <div class="cnx-mini-info" id="statBestStreak">
                            Best : {{ Auth::user()->best_streak ?? 0 }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- MAIN --}}
        <main class="cnx-main">

            {{-- TOP GRID --}}
            <div class="cnx-top-grid">

                {{-- PROFILE --}}
                <div class="cnx-card">

                    <div class="cnx-card-title-wrap">
                        <div class="cnx-card-title">
                            👤 Profil joueur
                        </div>

                        <div class="cnx-player-level">
                            ⭐ Niveau {{ Auth::user()->level ?? 1 }}
                        </div>
                    </div>

                    <div class="cnx-player-head">

                        <div class="cnx-avatar-wrap">

                            <img src="{{ asset(Auth::user()->avatar ?? 'avatars/avatar.webp') }}" class="cnx-player-avatar"
                                alt="Avatar">

                            @if ((Auth::user()->current_streak ?? 0) >= 5)
                                <div class="cnx-fire-ring">🔥</div>
                            @endif

                        </div>

                        <div>

                            <div class="cnx-player-pseudo">
                                {{ Auth::user()->pseudo ?? 'Pseudo non défini' }}
                            </div>

                            <div class="cnx-player-name">
                                {{ Auth::user()->name ?? 'Invité' }}
                            </div>

                            <div class="cnx-player-xp">
                                ⚡ {{ Auth::user()->xp ?? 0 }} XP
                            </div>

                        </div>

                    </div>

                    {{-- STREAKS --}}
                    <div class="cnx-streak-box">

                        <div class="cnx-streak-item">
                            <span class="cnx-streak-num">
                                🔥 {{ Auth::user()->current_streak ?? 0 }}
                            </span>

                            <span class="cnx-streak-label">
                                Série actuelle
                            </span>
                        </div>

                        <div class="cnx-streak-item">
                            <span class="cnx-streak-num">
                                🏆 {{ Auth::user()->best_streak ?? 0 }}
                            </span>

                            <span class="cnx-streak-label">
                                Meilleure série
                            </span>
                        </div>

                        <div class="cnx-streak-item">
                            <span class="cnx-streak-num">
                                ❄️ {{ Auth::user()->lose_streak ?? 0 }}
                            </span>

                            <span class="cnx-streak-label">
                                Mauvaise série
                            </span>
                        </div>

                    </div>

                    {{-- BADGES --}}
                    <div class="cnx-badges-header">

                        <div class="cnx-card-subtitle">
                            🏅 Badges débloqués
                        </div>

                    </div>

                    <div class="cnx-badges-row">

                        @php
                            $badgeCounts = Auth::user()->badges->groupBy('name')->map(fn($items) => $items->count());
                        @endphp

                        @forelse($badgeCounts as $badgeName => $count)
                            @php
                                $badge = Auth::user()->badges->firstWhere('name', $badgeName);
                            @endphp

                            <div class="cnx-badge" title="{{ $badge->description ?? $badge->name }}">

                                <span class="cnx-badge-icon">
                                    {{ $badge->icon }}
                                </span>

                                <small class="cnx-badge-name">
                                    {{ $badge->name }}
                                </small>

                                @if ($count > 1)
                                    <div class="cnx-badge-count">
                                        x{{ $count }}
                                    </div>
                                @endif

                            </div>

                        @empty

                            <div class="cnx-no-badge">
                                Aucun badge débloqué pour l'instant
                            </div>
                        @endforelse

                    </div>

                    {{-- INFOS --}}
                    <div class="cnx-info-list">

                        <div class="cnx-info-row">
                            <span class="cnx-info-label">
                                Projet / Service
                            </span>

                            <span class="cnx-info-value">
                                {{ Auth::user()->projet_service ?? '—' }}
                            </span>
                        </div>

                        <div class="cnx-info-row">
                            <span class="cnx-info-label">
                                Fonction
                            </span>

                            <span class="cnx-info-value">
                                {{ Auth::user()->fonction ?? '—' }}
                            </span>
                        </div>

                        <div class="cnx-info-row">
                            <span class="cnx-info-label">
                                Manager
                            </span>

                            <span class="cnx-info-value">
                                {{ Auth::user()->manager ?? '—' }}
                            </span>
                        </div>

                    </div>

                    <button type="button" class="cnx-btn-edit" data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">

                        ✏️ Modifier avatar / pseudo

                    </button>

                </div>

                {{-- LEADERBOARD --}}
                <div class="cnx-card cnx-lb-card">

                    <div class="cnx-card-title">
                        🏆 Top 10S — Classement
                    </div>

                    <table class="cnx-lb-table">

                        <thead>
                            <tr>
                                <th style="width:36px;">#</th>
                                <th>Joueur</th>
                                <th>Projet / Service</th>
                                <th>Fonction</th>
                                <th>Pts</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if ($users && $users->isNotEmpty())
                                @foreach ($users->take(10) as $key => $point)
                                    @php
                                        $rankClass = match ($key) {
                                            0 => 'rank-1',
                                            1 => 'rank-2',
                                            2 => 'rank-3',
                                            default => 'rank-other',
                                        };
                                    @endphp

                                    <tr>

                                        <td>
                                            <span class="cnx-rank-badge {{ $rankClass }}">
                                                {{ $key + 1 }}
                                            </span>
                                        </td>

                                        <td>

                                            <div class="cnx-top-player">

                                                <img
                                                    src="{{ asset('avatars/avatar.webp') }}?v={{ time() }}"
                                                    class="wc-podium-avatar"
                                                    alt="Avatar"
                                                >

                                                <div>

                                                    <div class="cnx-top-pseudo">
                                                        {{ $point->pseudo ?? $point->name }}
                                                    </div>

                                                    <div class="cnx-top-name">
                                                        {{ $point->name }}
                                                    </div>

                                                    <div class="cnx-mini-level">
                                                        ⭐ Niveau {{ $point->level ?? 1 }}
                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                        <td style="font-size:12px; color:var(--muted);">
                                            {{ $point->projet_service }}
                                        </td>

                                        <td style="font-size:12px; color:var(--muted);">
                                            {{ $point->fonction }}
                                        </td>

                                        <td class="cnx-lb-pts">

                                            <div>
                                                {{ $point->points }}
                                            </div>

                                            <small class="cnx-mini-xp">
                                                ⚡ {{ $point->xp ?? 0 }} XP
                                            </small>

                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5"
                                        style="text-align:center;
                               color:var(--muted);
                               padding:24px;
                               font-style:italic;">

                                        Aucune donnée disponible

                                    </td>
                                </tr>
                            @endif

                        </tbody>

                    </table>

                </div>

                {{-- ONLINE --}}
                <div class="cnx-card cnx-online-card">

                    <div class="cnx-pulse"></div>

                    <span class="cnx-online-count" id="activeUsersCount">

                        {{ $onlineUsersCount ?? '0' }}

                    </span>

                    <span class="cnx-online-label">
                        Game Changers<br>en ligne
                    </span>

                </div>

            </div>

            {{-- ALERTS --}}
            @if (session('success'))
                <div class="cnx-alert cnx-alert-success">✓ {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="cnx-alert cnx-alert-error">✗ {{ session('error') }}</div>
            @endif

            {{-- BULK FORM caché --}}
            <form id="bulkPredictionForm" action="{{ route('predictions.bulkStore') }}" method="POST"
                style="display:none;">
                @csrf
            </form>

            {{-- MATCHES HEADER --}}
            <div class="cnx-matches-header">
                <div class="cnx-matches-title">
                    Matchs &amp; <span>Pronostics</span>
                </div>

                <button type="button" id="bulkSaveBtn" class="cnx-btn-validate">
                    ✓ Valider tous mes pronostics
                </button>
            </div>

            {{-- MATCHES TABLE --}}
            <div class="cnx-table-wrap">
                <table id="cnxtable" style="width:100%;">

                    <thead>
                        <tr>
                            <th style="width:36%;">Match</th>
                            <th style="width:14%;">Mon pronostic</th>
                            <th style="width:24%;">Prédire</th>
                            <th style="width:16%;">Résultat</th>
                        </tr>
                    </thead>

                </table>
            </div>

            {{-- MODAL PROFIL --}}
            <div class="modal fade cnx-modal" id="editProfileModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('profile.gaming.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title">Modifier mon profil joueur</h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <label class="cnx-label">Pseudo</label>
                                <input type="text" name="pseudo" class="cnx-input"
                                    value="{{ Auth::user()->pseudo }}" required maxlength="30">

                                <label class="cnx-label" style="margin-top:20px;">Choisir un avatar</label>
                                <div class="avatar-grid">
                                    @for ($i = 1; $i <= 21; $i++)
                                        <label class="avatar-choice">
                                            <input type="radio" name="avatar"
                                                value="{{ asset('avatars/avatar' . $i . '.webp') }}"
                                                {{ Auth::user()->avatar === asset('avatars/avatar' . $i . '.webp') ? 'checked' : '' }}>

                                            <img src="{{ asset('avatars/avatar' . $i . '.webp') }}"
                                                alt="avatar {{ $i }}">
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="cnx-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="cnx-btn-save">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>

        {{-- FOOTER --}}
        <footer class="cnx-footer">
            <div class="cnx-footer-text">
                Concentrix · Game Changer · FIFA World Cup 2026™ · <span>Developed by Lallène ACHI</span>
            </div>
        </footer>

    </div>
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}">
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <script>
        function closeRewardOverlay() {
            document.getElementById('rewardOverlay')?.remove();
        }

        function refreshClassementStats() {
            $.ajax({
                url: "{{ route('classement.stats') }}?t=" + new Date().getTime(),
                type: "GET",
                cache: false,

                success: function(data) {
                    console.log('STATS OK LIVE', data);

                    const matchPct = data.nbre_matches > 0 ?
                        Math.round((data.match_joue / data.nbre_matches) * 100) :
                        0;

                    $('#statMatches').text(data.match_joue + '/' + data.nbre_matches);
                    $('#statMatchProgress').css('width', matchPct + '%');
                    $('#statMatchPercent').text(matchPct + '%');

                    $('#statPoints').text(data.points);
                    $('#statXp').text('⚡ ' + data.xp + ' XP');

                    $('#statClassement').text(
                        (data.classement ? data.classement : '—') +
                        '/' +
                        data.nbre_users
                    );


                    $('#statCurrentStreak').text(data.current_streak);
                    $('#statBestStreak').text('Best : ' + data.best_streak);

                    $('#statTier').html(
                        !data.classement ? '🎮 Non classé' :
                        data.classement == 1 ? '🥇 Champion' :
                        data.classement <= 3 ? '🏆 Top 3' :
                        data.classement <= 10 ? '🔥 Top 10' :
                        '🎮 Challenger'
                    );
                },

                error: function(xhr) {
                    console.log('STATS ERROR', xhr.status, xhr.responseText);
                }
            });
        }

        $(document).ready(function() {

            function fetchOnlineUsersCount() {
                $.ajax({
                    url: "{{ route('online.users.count') }}",
                    type: 'GET',
                    success: function(data) {
                        $('#activeUsersCount').text(data.activeUsersCount);
                    },
                    error: function() {
                        $('#activeUsersCount').text('—');
                    }
                });
            }

            fetchOnlineUsersCount();
            setInterval(fetchOnlineUsersCount, 30000);

            $('#cnxtable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('matches.data') }}",
                responsive: true,
                pageLength: 25,
                ordering: false,
                columns: [{
                        data: 'match',
                        name: 'match'
                    },
                    {
                        data: 'prediction',
                        name: 'prediction'
                    },
                    {
                        data: 'play',
                        name: 'play'
                    },
                    {
                        data: 'result',
                        name: 'result'
                    }
                ],
                language: {
                    processing: "Chargement...",
                    search: "Rechercher :",
                    lengthMenu: "Afficher _MENU_ matchs",
                    info: "_START_ à _END_ sur _TOTAL_ matchs",
                    infoEmpty: "Aucun match",
                    zeroRecords: "Aucun match trouvé",
                    paginate: {
                        previous: "‹",
                        next: "›"
                    }
                }
            });

            refreshClassementStats();
            setInterval(refreshClassementStats, 10000);
        });

        $(document).on('change', '.bulk-select', function() {
            const matchId = $(this).data('match-id');
            $('#single-prediction-' + matchId).val($(this).val());
        });

        $(document).on('click', '#bulkSaveBtn', function() {
            const button = $(this);

            let payload = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                predictions: {}
            };

            $('.bulk-select').each(function() {
                const value = $(this).val();
                const matchId = $(this).data('match-id');

                if (value && value !== '0') {
                    payload.predictions[matchId] = value;
                }
            });

            if (Object.keys(payload.predictions).length === 0) {
                alert('Aucun pronostic sélectionné.');
                return;
            }

            button.prop('disabled', true).text('Validation...');

            $.ajax({
                url: $('#bulkPredictionForm').attr('action'),
                type: 'POST',
                data: payload,

                success: function() {
                    button.text('✓ Pronostics validés');

                    $('#cnxtable').DataTable().ajax.reload(function() {
                        refreshClassementStats();
                    }, false);

                    setTimeout(function() {
                        button.prop('disabled', false).text('Valider tous mes pronostics');
                    }, 1200);
                },

                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Erreur lors de la validation.');
                    button.prop('disabled', false).text('Valider tous mes pronostics');
                }
            });
        });

        $(document).on('click', '.btn-single-save', function() {
            const button = $(this);
            const form = button.closest('form');

            button.prop('disabled', true).text('...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),

                success: function() {
                    button.text('✓');

                    $('#cnxtable').DataTable().ajax.reload(function() {
                        refreshClassementStats();
                    }, false);
                },

                error: function() {
                    alert('Erreur lors du pronostic.');
                    button.prop('disabled', false).text('OK');
                }
            });
        });
    </script>


@endsection
