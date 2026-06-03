@extends('layouts.app')

@section('content')

    <style>
        :root {
            --wc-navy: #071426;
            --wc-blue: #102C54;
            --wc-gold: #C9A84C;
            --wc-gold-light: #F5D879;
            --wc-red: #C8102E;
            --wc-green: #006847;
            --wc-white: #F8F4EA;
            --wc-muted: #AAB4C4;
        }


        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Rajdhani', sans-serif;
            background:
                linear-gradient(120deg, rgb(7 20 38 / 36%), rgb(16 44 84 / 48%)),
                url("{{ asset('avatars/bg_cdm.webp') }}");
            background-size: cover;
            background-position: center;
            color: var(--wc-white);
        }

        .login-worldcup {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            position: relative;
            overflow: hidden;
        }

        .login-worldcup::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(0deg, transparent, transparent 58px, rgba(255, 255, 255, .04) 59px),
                repeating-linear-gradient(90deg, transparent, transparent 58px, rgba(255, 255, 255, .04) 59px);
            pointer-events: none;
        }

        .login-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1050px;
            min-height: 590px;
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            background: rgba(7, 20, 38, .82);
            border: 1px solid rgba(201, 168, 76, .35);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 30px 90px rgba(0, 0, 0, .55);
            backdrop-filter: blur(12px);
        }

        .login-visual {
            padding: 42px;
            background:
                radial-gradient(circle at 30% 20%, rgba(201, 168, 76, .18), transparent 35%),
                linear-gradient(145deg, rgba(16, 44, 84, .95), rgba(7, 20, 38, .92));
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand img {
            height: 48px;
            width: auto;
        }

        .brand-text {
            font-family: 'Oswald', sans-serif;
            color: var(--wc-gold);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .hero-title {
            margin-top: 55px;
        }

        .hero-kicker {
            font-family: 'Oswald', sans-serif;
            color: var(--wc-gold);
            letter-spacing: 4px;
            text-transform: uppercase;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .hero-title h1 {
            font-family: 'Oswald', sans-serif;
            font-size: clamp(42px, 5vw, 72px);
            line-height: .95;
            text-transform: uppercase;
            margin: 0;
        }

        .hero-title h1 span {
            color: var(--wc-gold-light);
        }

        .hero-title p {
            margin-top: 18px;
            max-width: 520px;
            color: var(--wc-muted);
            font-size: 18px;
            line-height: 1.45;
            font-weight: 500;
        }

        .hosts {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .host-chip {
            padding: 8px 14px;
            border-radius: 30px;
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid rgba(255, 255, 255, .12);
        }

        .usa {
            color: #ff6b7a;
            background: rgba(200, 16, 46, .16);
        }

        .can {
            color: #ffb4b4;
            background: rgba(200, 16, 46, .10);
        }

        .mex {
            color: #4dba8c;
            background: rgba(0, 104, 71, .18);
        }

        .login-form-zone {
            padding: 46px 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(5, 12, 24, .74);
        }

        .form-title {
            margin-bottom: 28px;
        }

        .form-title span {
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            color: var(--wc-gold);
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .form-title h2 {
            font-family: 'Oswald', sans-serif;
            font-size: 34px;
            margin: 8px 0 0;
            text-transform: uppercase;
        }

        .loginfail {
            background: rgba(200, 16, 46, .14);
            border: 1px solid rgba(200, 16, 46, .45);
            color: #ff8a95;
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 18px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            color: var(--wc-muted);
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .form-control-wc {
            width: 100%;
            background: rgba(255, 255, 255, .06);
            color: var(--wc-white);
            border: 1px solid rgba(201, 168, 76, .3);
            border-radius: 14px;
            padding: 14px 15px;
            font-size: 16px;
            font-weight: 600;
            outline: none;
        }

        .form-control-wc:focus {
            border-color: var(--wc-gold);
            box-shadow: 0 0 0 4px rgba(201, 168, 76, .12);
        }

        .form-control-wc::placeholder {
            color: rgba(248, 244, 234, .45);
        }

        .btn-login-wc {
            width: 100%;
            margin-top: 8px;
            padding: 15px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--wc-gold-light), var(--wc-gold));
            color: var(--wc-navy);
            font-family: 'Oswald', sans-serif;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: .25s ease;
        }

        .btn-login-wc:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(201, 168, 76, .28);
        }

        .security-note {
            margin-top: 18px;
            color: var(--wc-muted);
            font-size: 13px;
            text-align: center;
        }

        .login-footer {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 8px;
            color: rgba(248, 244, 234, .45);
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-footer strong {
            color: var(--wc-gold);
        }

        @media (max-width: 900px) {
            .login-card {
                grid-template-columns: 1fr;
            }

            .login-visual {
                padding: 32px;
            }

            .hero-title {
                margin-top: 35px;
            }

            .login-form-zone {
                padding: 32px;
            }
        }

        @media (max-width: 520px) {
            .login-worldcup {
                padding: 16px;
            }

            .login-card {
                border-radius: 20px;
            }

            .hero-title h1 {
                font-size: 40px;
            }

            .form-title h2 {
                font-size: 28px;
            }
        }

        .wc-label {
            display: block;
            margin-bottom: 8px;
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            letter-spacing: 1px;
            color: var(--wc-gold);
            text-transform: uppercase;
        }

        .avatar-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 12px;
        }

        .avatar-choice {
            position: relative;
            cursor: pointer;
        }

        .avatar-choice input {
            display: none;
        }

        .avatar-choice img {
            width: 100%;
            border-radius: 18px;
            border: 2px solid transparent;
            transition: .2s ease;
            background: rgba(255, 255, 255, .06);
            padding: 6px;
        }

        .avatar-choice input:checked+img {
            border-color: var(--wc-gold);
            transform: scale(1.05);
            box-shadow: 0 0 18px rgba(201, 168, 76, .4);
        }
    </style>

    <div class="login-worldcup">
        <div class="login-card">

            <section class="login-visual">
                <div>
                    <div class="brand">
                        @if (file_exists(public_path('avatars/logo.webp')))
                            <img src="{{ asset('avatars/logo.webp') }}" alt="Logo Concentrix">
                        @endif
                        <div class="brand-text">Game Changer</div>
                    </div>

                    <div class="hero-title">
                        <div class="hero-kicker">Pronostics internes</div>
                        <h1>Coupe du Monde <span>2026</span></h1>
                        <p>
                            Connectez-vous pour pronostiquer les matchs, suivre vos points
                            et grimper dans le classement des Game Changers.
                        </p>
                    </div>
                </div>

                <div class="hosts">
                    <span class="host-chip usa">🇺🇸 USA</span>
                    <span class="host-chip can">🇨🇦 Canada</span>
                    <span class="host-chip mex">🇲🇽 Mexique</span>
                </div>
            </section>

            <section class="login-form-zone">
                <div class="form-title">
                    <span>Espace sécurisé</span>
                    <h2>Connexion</h2>
                </div>

                @if ($errors->any())
                    <div class="loginfail">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.force.update') }}">
                    @csrf

                    {{-- Avatar --}}
                    <div class="form-group">
                        <label class="wc-label">Choisissez votre avatar</label>

                        <div class="avatar-grid">
                            @for ($i = 1; $i <= 12; $i++)
                                <label class="avatar-choice">
                                    <input type="radio" name="avatar" value="avatars/avatar{{ $i }}.webp"
                                        {{ $i == 1 ? 'checked' : '' }}>

                                    <img src="{{ asset('avatars/avatar' . $i . '.webp') }}" alt="avatar {{ $i }}">
                                </label>
                            @endfor
                        </div>
                    </div>

                    {{-- Pseudo --}}
                    <div class="form-group">
                        <label class="wc-label">Pseudo</label>

                        <input type="text" id="pseudo" name="pseudo" class="form-control-wc" required maxlength="30"
                            placeholder="Ex: KingMessi95">
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label class="wc-label">Nouveau mot de passe</label>

                        <input type="password" id="password" name="password" class="form-control-wc" required
                            placeholder="Nouveau mot de passe" autocomplete="new-password">
                    </div>

                    {{-- Confirmation --}}
                    <div class="form-group">
                        <label class="wc-label">Confirmation</label>

                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control-wc" required placeholder="Confirmer le mot de passe"
                            autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn-login-wc">
                        Créer mon profil
                    </button>
                </form>

                <div class="login-footer">
                    <span>CNX</span>
                    <strong>World Cup Challenge</strong>
                    <span>2026</span>
                </div>
            </section>

        </div>
    </div>

@endsection
