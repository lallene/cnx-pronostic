@extends('layouts.app')

@section('content')
    <style>
        * {
            box-sizing: border-box;
        }

        .cnx-page {
            min-height: 100vh;
            padding-bottom: 80px;
            background: radial-gradient(circle at top, #18233a 0%, #0b1020 55%);
            color: #fff;
        }




        /* ── LAYOUT ── */
        .cnx-section,
        .cnx-grid {
            width: min(1280px, 92%);
            margin: 0 auto 28px;
        }

        .cnx-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .cnx-section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .36);
            margin-bottom: 12px;
        }

        /* ── CARDS ── */
        .cnx-card {
            padding: 26px 28px;
            border-radius: 24px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
        }

        .cnx-card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .45);
            margin-bottom: 18px;
        }

        /* ── PRINCIPE ── */
        .cnx-principle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 0;
            border-bottom: 1px solid rgba(255, 255, 255, .06);
            font-size: 15px;
        }

        .cnx-principle-row:last-child {
            border-bottom: none;
        }

        .cnx-principle-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, .75);
        }

        .cnx-check {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 999px;
            background: rgba(34, 197, 94, .15);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, .2);
        }

        /* ── POINTS ── */
        .cnx-big-num {
            font-size: 40px;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 6px;
        }

        .cnx-big-label {
            font-size: 13px;
            color: rgba(255, 255, 255, .45);
            margin-bottom: 14px;
        }

        .cnx-formula {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .08);
            font-size: 14px;
            color: rgba(255, 255, 255, .65);
        }

        .cnx-formula strong {
            color: #fff;
        }

        /* ── COEFFICIENTS ── */
        .cnx-coeff-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, .07);
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
        }

        .cnx-coeff-row:last-child {
            margin-bottom: 0;
        }

        .cnx-coeff-pill {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 999px;
        }

        .coeff-1 {
            background: rgba(255, 255, 255, .05);
            color: rgba(255, 255, 255, .6);
        }

        .coeff-1 .cnx-coeff-pill {
            background: rgba(255, 255, 255, .08);
            color: rgba(255, 255, 255, .5);
        }

        .coeff-2 {
            background: rgba(59, 130, 246, .12);
            color: #93c5fd;
        }

        .coeff-2 .cnx-coeff-pill {
            background: rgba(59, 130, 246, .2);
            color: #60a5fa;
        }

        .coeff-3 {
            background: rgba(249, 115, 22, .12);
            color: #fdba74;
        }

        .coeff-3 .cnx-coeff-pill {
            background: rgba(249, 115, 22, .2);
            color: #fb923c;
        }

        .coeff-5 {
            background: rgba(250, 204, 21, .12);
            color: #fde047;
        }

        .coeff-5 .cnx-coeff-pill {
            background: rgba(250, 204, 21, .2);
            color: #facc15;
        }

        /* ── TIP LIST ── */
        .cnx-tip-list {
            list-style: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .cnx-tip-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 14px;
            color: rgba(255, 255, 255, .7);
            line-height: 1.55;
        }

        .cnx-tip-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .07);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ── STREAKS ── */
        .cnx-streak-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, .06);
            font-size: 14px;
        }

        .cnx-streak-row:last-child {
            border-bottom: none;
        }

        .cnx-streak-label {
            color: rgba(255, 255, 255, .65);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cnx-streak-val {
            font-size: 12px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 999px;
        }

        /* ── DUELS ── */
        .cnx-duel-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 14px;
            margin-top: 18px;
        }

        .cnx-duel-box {
            text-align: center;
            padding: 20px 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
        }

        .cnx-duel-num {
            font-size: 24px;
            font-weight: 900;
            margin-bottom: 6px;
        }

        .cnx-duel-lbl {
            font-size: 12px;
            color: rgba(255, 255, 255, .5);
        }

        /* ── CLASSEMENTS PILLS ── */
        .cnx-pill-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 4px;
        }

        .cnx-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .75);
        }

        /* ── BADGES ── */
        .cnx-badge-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 18px;
        }

        .cnx-filter-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .1);
            background: rgba(255, 255, 255, .05);
            color: rgba(255, 255, 255, .55);
            cursor: pointer;
            transition: all .15s;
            letter-spacing: .03em;
        }

        .cnx-filter-btn:hover,
        .cnx-filter-btn.active {
            background: rgba(255, 255, 255, .12);
            color: #fff;
            border-color: rgba(255, 255, 255, .2);
        }

        .cnx-badge-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
            margin-bottom: 22px;
        }

        .cnx-badge-stat-box {
            text-align: center;
            padding: 14px 10px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .07);
        }

        .cnx-badge-stat-box .num {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .cnx-badge-stat-box .lbl {
            font-size: 11px;
            color: rgba(255, 255, 255, .4);
        }

        .cnx-badge-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 14px;
        }

        .cnx-badge-card {
            padding: 20px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
            transition: transform .2s, border-color .2s;
            cursor: default;
        }

        .cnx-badge-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, .18);
        }

        .cnx-badge-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 14px;
            border: 1px solid rgba(255, 255, 255, .1);
        }

        .cat-win {
            background: rgba(34, 197, 94, .15);
        }

        .cat-streak {
            background: rgba(249, 115, 22, .15);
        }

        .cat-cold {
            background: rgba(59, 130, 246, .15);
        }

        .cat-xp {
            background: rgba(139, 92, 246, .15);
        }

        .cat-part {
            background: rgba(20, 184, 166, .15);
        }

        .cat-mvp {
            background: rgba(236, 72, 153, .15);
        }

        .cnx-badge-name {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 6px;
            color: #fff;
        }

        .cnx-badge-desc {
            font-size: 13px;
            color: rgba(255, 255, 255, .55);
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .cnx-badge-key {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 999px;
        }

        .key-win {
            background: rgba(34, 197, 94, .15);
            color: #4ade80;
        }

        .key-streak {
            background: rgba(249, 115, 22, .15);
            color: #fb923c;
        }

        .key-cold {
            background: rgba(59, 130, 246, .15);
            color: #60a5fa;
        }

        .key-xp {
            background: rgba(139, 92, 246, .15);
            color: #c084fc;
        }

        .key-part {
            background: rgba(20, 184, 166, .15);
            color: #2dd4bf;
        }

        .key-mvp {
            background: rgba(236, 72, 153, .15);
            color: #f472b6;
        }

        .cnx-badge-card.hidden {
            display: none;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .cnx-hero {
                padding: 80px 20px;
            }

            .cnx-hero h1 {
                font-size: 34px;
            }

            .cnx-hero p {
                font-size: 15px;
            }
        }
    </style>

    <div class="cnx-page">

        <div class="cnx-stripe"></div>


        <header class="cnx-header">
            <div class="cnx-header-inner">
                <a href="{{ url('/') }}" class="cnx-logo">
                    <div class="cnx-logo-badge">Game Changer</div>
                </a>

                <nav class="cnx-nav">
                    <a href="{{ route('home') }}" class="cnx-nav-link">Pronostics</a>
                    <a href="{{ route('classement') }}" class="cnx-nav-link">Classements</a>
                    <a href="{{ route('duels') }}" class="cnx-nav-link ">Duels</a>
                    <a href="{{ route('guide') }}" class="cnx-nav-link active">Aide</a>
                    <form method="POST" action="{{ route('logout.user') }}" style="display:inline;" >
                        @csrf

                        <button type="submit" class="cnx-nav-link"style=" background-color: #a11a1ad4; color: white;">
                            Déconnexion
                        </button>
                    </form>
                </nav>
            </div>
        </header>

        <div class="cnx-hero">
            <div class="cnx-hero-inner">
                <div>
                    <div class="cnx-eyebrow">Concentrix · Édition Spéciale</div>
                    <div class="cnx-title">Coupe du Monde<br><span>FIFA 2026™</span>
                    </div>
                    <div class="wc-hero-flags">
                        <span class="wc-flag-chip f-usa">🇺🇸 USA</span>
                        <span class="wc-flag-chip f-can">🇨🇦 Canada</span>
                        <span class="wc-flag-chip f-mex">🇲🇽 Mexique</span>
                    </div>

                </div>


            </div>
        </div>


        {{-- PRINCIPE --}}
        <section class="cnx-section" style="margin-top:40px">
            <div class="cnx-section-label">⚽ Principe du jeu</div>
            <div class="cnx-card">
                <div class="cnx-principle-row">
                    <span class="cnx-principle-label">🏠 Victoire à domicile</span>
                    <span class="cnx-check">✓ Pronostiquable</span>
                </div>
                <div class="cnx-principle-row">
                    <span class="cnx-principle-label">🤝 Match nul</span>
                    <span class="cnx-check">✓ Pronostiquable</span>
                </div>
                <div class="cnx-principle-row">
                    <span class="cnx-principle-label">✈️ Victoire extérieure</span>
                    <span class="cnx-check">✓ Pronostiquable</span>
                </div>
            </div>
        </section>

        {{-- POINTS --}}
        <section class="cnx-section">
            <div class="cnx-section-label">🏅 Système de points</div>
            <div class="cnx-grid">

                <div class="cnx-card">
                    <div class="cnx-card-title">Points par bon pronostic</div>
                    <div class="cnx-big-num">3 pts</div>
                    <div class="cnx-big-label">base par résultat correct</div>
                    <div class="cnx-formula">
                        <span>🔢</span>
                        Points = <strong>3 × coefficient du match</strong>
                    </div>
                </div>

                <div class="cnx-card">
                    <div class="cnx-card-title">🔥 Coefficients des matchs</div>
                    <div class="cnx-coeff-row coeff-1">
                        <span>Match standard</span>
                        <span class="cnx-coeff-pill">× 1 — 3 pts</span>
                    </div>
                    <div class="cnx-coeff-row coeff-2">
                        <span>Match difficile</span>
                        <span class="cnx-coeff-pill">× 2 — 6 pts</span>
                    </div>
                    <div class="cnx-coeff-row coeff-3">
                        <span>Gros choc</span>
                        <span class="cnx-coeff-pill">× 3 — 9 pts</span>
                    </div>
                    <div class="cnx-coeff-row coeff-5">
                        <span>👑 Finale / Légendaire</span>
                        <span class="cnx-coeff-pill">× 5 — 15 pts</span>
                    </div>
                </div>

            </div>
        </section>

        {{-- XP & SÉRIES --}}
        <section class="cnx-section">
            <div class="cnx-section-label">⚡ XP & Progression</div>
            <div class="cnx-grid">

                <div class="cnx-card">
                    <div class="cnx-card-title">Progression</div>
                    <ul class="cnx-tip-list">
                        <li>
                            <div class="cnx-tip-icon">📈</div>
                            Montez de niveau à chaque bonne série
                        </li>
                        <li>
                            <div class="cnx-tip-icon">🏆</div>
                            Débloquez des badges exclusifs
                        </li>
                        <li>
                            <div class="cnx-tip-icon">⚔️</div>
                            Affrontez les meilleurs joueurs en duel
                        </li>
                    </ul>
                </div>

                <div class="cnx-card">
                    <div class="cnx-card-title">🔥 Séries (Streaks)</div>
                    <div class="cnx-streak-row">
                        <span class="cnx-streak-label">🔥 Série actuelle</span>
                        <span class="cnx-streak-val" style="background:rgba(249,115,22,.15);color:#fb923c">
                            Pronostics corrects consécutifs
                        </span>
                    </div>
                    <div class="cnx-streak-row">
                        <span class="cnx-streak-label">🏆 Best streak</span>
                        <span class="cnx-streak-val" style="background:rgba(250,204,21,.15);color:#facc15">
                            Meilleure série historique
                        </span>
                    </div>
                    <div class="cnx-streak-row">
                        <span class="cnx-streak-label">❄️ Lose streak</span>
                        <span class="cnx-streak-val" style="background:rgba(59,130,246,.15);color:#60a5fa">
                            Mauvaises séries consécutives
                        </span>
                    </div>
                </div>

            </div>
        </section>

        {{-- DUELS --}}
        <section class="cnx-section">
            <div class="cnx-section-label">⚔️ Duels</div>
            <div class="cnx-card">
                <div class="cnx-card-title">Système de duels — misez votre XP contre un collègue</div>
                <div class="cnx-duel-grid">
                    <div class="cnx-duel-box">
                        <div class="cnx-duel-num">100 XP</div>
                        <div class="cnx-duel-lbl">XP de départ</div>
                    </div>
                    <div class="cnx-duel-box">
                        <div class="cnx-duel-num" style="color:#4ade80">× 2</div>
                        <div class="cnx-duel-lbl">Mise doublée si victoire</div>
                    </div>
                    <div class="cnx-duel-box">
                        <div class="cnx-duel-num" style="color:#f87171">− mise</div>
                        <div class="cnx-duel-lbl">XP perdue si défaite</div>
                    </div>
                </div>
            </div>
        </section>



        {{-- BADGES --}}
        <section class="cnx-section">
            <div class="cnx-section-label">🏅 Badges à débloquer</div>
            <div class="cnx-card">

                <div class="cnx-badge-stats">
                    <div class="cnx-badge-stat-box">
                        <div class="num">{{ $badges->count() }}</div>
                        <div class="lbl">Badges total</div>
                    </div>
                    <div class="cnx-badge-stat-box">
                        <div class="num">6</div>
                        <div class="lbl">Catégories</div>
                    </div>
                    <div class="cnx-badge-stat-box">
                        <div class="num">500 XP</div>
                        <div class="lbl">Légende CNX</div>
                    </div>
                    <div class="cnx-badge-stat-box">
                        <div class="num">50</div>
                        <div class="lbl">Matchs marathon</div>
                    </div>
                </div>

                <div class="cnx-badge-filters">
                    <button class="cnx-filter-btn active" onclick="filterBadges('all', this)">Tous</button>
                    <button class="cnx-filter-btn" onclick="filterBadges('win', this)">🥅 Victoires</button>
                    <button class="cnx-filter-btn" onclick="filterBadges('streak', this)">🔥 Séries</button>
                    <button class="cnx-filter-btn" onclick="filterBadges('cold', this)">❄️ Séries noires</button>
                    <button class="cnx-filter-btn" onclick="filterBadges('xp', this)">⚡ XP</button>
                    <button class="cnx-filter-btn" onclick="filterBadges('participation', this)">📅 Participation</button>
                    <button class="cnx-filter-btn" onclick="filterBadges('mvp', this)">🏢 MVP</button>
                </div>

                <div class="cnx-badge-grid" id="badgeGrid">
                    @foreach ($badges as $badge)
                        <div class="cnx-badge-card" data-cat="{{ $badge->category }}">
                            <div class="cnx-badge-icon-wrap cat-{{ $badge->category }}">
                                {{ $badge->icon }}
                            </div>
                            <div class="cnx-badge-name">{{ $badge->name }}</div>
                            <div class="cnx-badge-desc">{{ $badge->description }}</div>
                            <span class="cnx-badge-key key-{{ $badge->category }}">
                                {{ $badge->condition_key }}
                                @if (isset($badge->threshold))
                                    · {{ $badge->threshold }} {{ in_array($badge->category, ['xp']) ? 'XP' : 'matchs' }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

    </div>

    <script>
        function filterBadges(cat, el) {
            document.querySelectorAll('.cnx-filter-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.querySelectorAll('.cnx-badge-card').forEach(card => {
                card.classList.toggle('hidden', cat !== 'all' && card.dataset.cat !== cat);
            });
        }
    </script>
@endsection
