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
                linear-gradient(120deg, rgba(7, 20, 38, .94), rgba(16, 44, 84, .86)),
                url("/cnx-pronostic.com/avatars/bg_cdm.webp");
            background-size: cover;
            background-position: center;
            color: var(--wc-white);
        }

        .admin-login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            position: relative;
            overflow: hidden;
        }

        .admin-login-page::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(0deg, transparent, transparent 58px, rgba(255, 255, 255, .035) 59px),
                repeating-linear-gradient(90deg, transparent, transparent 58px, rgba(255, 255, 255, .035) 59px);
        }

        .admin-login-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1050px;
            min-height: 590px;
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            background: rgba(7, 20, 38, .84);
            border: 1px solid rgba(201, 168, 76, .38);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 30px 90px rgba(0, 0, 0, .58);
            backdrop-filter: blur(12px);
        }

        .admin-visual {
            padding: 42px;
            background:
                radial-gradient(circle at 30% 20%, rgba(201, 168, 76, .18), transparent 35%),
                linear-gradient(145deg, rgba(16, 44, 84, .95), rgba(7, 20, 38, .92));
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .admin-brand::before {
            content: "";
            width: 306px;
            height: 59px;

            background-image: url("/cnx-pronostic.com/avatars/logo.webp");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;

            display: block;
        }

        .admin-brand-text {
            font-family: 'Oswald', sans-serif;
            color: var(--wc-gold);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            margin-top: 29px;
        }

        .admin-hero {
            margin-top: 55px;
        }

        .admin-kicker {
            font-family: 'Oswald', sans-serif;
            color: var(--wc-gold);
            letter-spacing: 4px;
            text-transform: uppercase;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .admin-hero h1 {
            font-family: 'Oswald', sans-serif;
            font-size: clamp(42px, 5vw, 72px);
            line-height: .95;
            text-transform: uppercase;
            margin: 0;
        }

        .admin-hero h1 span {
            color: var(--wc-gold-light);
        }

        .admin-hero p {
            margin-top: 18px;
            max-width: 520px;
            color: var(--wc-muted);
            font-size: 18px;
            line-height: 1.45;
            font-weight: 500;
        }

        .admin-tags {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .admin-tag {
            padding: 8px 14px;
            border-radius: 30px;
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid rgba(255, 255, 255, .12);
        }

        .tag-secure {
            color: #F5D879;
            background: rgba(201, 168, 76, .14);
        }

        .tag-admin {
            color: #ff6b7a;
            background: rgba(200, 16, 46, .14);
        }

        .tag-worldcup {
            color: #4dba8c;
            background: rgba(0, 104, 71, .18);
        }

        .admin-form-zone {
            padding: 46px 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(5, 12, 24, .76);
        }

        .admin-form-title {
            margin-bottom: 28px;
        }

        .admin-form-title span {
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            color: var(--wc-gold);
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .admin-form-title h2 {
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

        .admin-input {
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

        .admin-input:focus {
            border-color: var(--wc-gold);
            box-shadow: 0 0 0 4px rgba(201, 168, 76, .12);
        }

        .admin-input::placeholder {
            color: rgba(248, 244, 234, .45);
        }

        .btn-admin-login {
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

        .btn-admin-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(201, 168, 76, .28);
        }

        .admin-security-note {
            margin-top: 18px;
            color: var(--wc-muted);
            font-size: 13px;
            text-align: center;
        }

        .admin-footer {
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

        .admin-footer strong {
            color: var(--wc-gold);
        }

        @media (max-width: 900px) {
            .admin-login-card {
                grid-template-columns: 1fr;
            }

            .admin-visual {
                padding: 32px;
            }

            .admin-hero {
                margin-top: 35px;
            }

            .admin-form-zone {
                padding: 32px;
            }
        }

        @media (max-width: 520px) {
            .admin-login-page {
                padding: 16px;
            }

            .admin-login-card {
                border-radius: 20px;
            }

            .admin-hero h1 {
                font-size: 38px;
            }

            .admin-form-title h2 {
                font-size: 28px;
            }
        }
    </style>

    <div class="admin-login-page">
        <div class="admin-login-card">

            <section class="admin-visual">
                <div>
                    <div class="admin-brand">
                        <div class="admin-brand-text">Game Changer</div>
                    </div>

                    <div class="admin-hero">
                        <div class="admin-kicker">Console d’administration</div>
                        <h1>World Cup <span>2026</span></h1>
                        <p>
                            Gérez les matchs, les résultats, les utilisateurs et les classements
                            du challenge pronostics Coupe du Monde 2026.
                        </p>
                    </div>
                </div>

                <div class="admin-tags">
                    <span class="admin-tag tag-secure">🔐 Accès sécurisé</span>
                    <span class="admin-tag tag-admin">⚙ Administration</span>
                    <span class="admin-tag tag-worldcup">🏆 WC 2026</span>
                </div>
            </section>

            <section class="admin-form-zone">
                <div class="admin-form-title">
                    <span>Espace réservé</span>
                    <h2>Connexion Admin</h2>
                </div>

                @if ($errors->any())
                    <div class="loginfail">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Adresse email admin</label>
                        <input type="email" id="email" name="email" class="admin-input" required
                            placeholder="admin@pronostic.com" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" class="admin-input" required
                            placeholder="Votre mot de passe">
                    </div>

                    <button type="submit" class="btn-admin-login">
                        Accéder au back-office
                    </button>

                    <div class="admin-security-note">
                        Zone protégée. Réservée aux administrateurs autorisés.
                    </div>
                </form>

                <div class="admin-footer">
                    <span>CNX</span>
                    <strong>Admin Center</strong>
                    <span>2026</span>
                </div>
            </section>

        </div>
    </div>

@endsection
