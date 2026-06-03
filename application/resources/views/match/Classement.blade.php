@extends('layouts.app')

@section('title', 'Les Classements')

@section('content')


    <style>
        :root {
            --gold: #D4A947;
            --gold-lt: #F2CE72;
            --gold-dk: #8C6A1A;
            --silver: #B8C5D6;
            --silver-lt: #D8E4F0;
            --bronze: #CD7F32;
            --bronze-lt: #E8A96A;
            --navy: #07111F;
            --navy-mid: #0D1E30;
            --navy-lt: #162844;
            --card-bg: rgba(13, 30, 48, .92);
            --border: rgba(212, 169, 71, .18);
            --border-md: rgba(212, 169, 71, .35);
            --text: #EBF0F6;
            --muted: rgba(235, 240, 246, .45);
            --green: #27AE60;
            --red: #E74C3C;
            --radius-card: 20px;
            --radius-sm: 10px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--navy);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        /* ── STRIPE ── */
        .cnx-stripe {
            height: 4px;
            background: linear-gradient(90deg, #D4A947 0%, #F2CE72 40%, #D4A947 70%, #8C6A1A 100%);
        }

        /* ── HEADER ── */
        .cnx-header {
            background: rgba(7, 17, 31, .96);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(16px);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .cnx-header-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 28px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cnx-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .cnx-logo img {
            height: 36px;
            border-radius: 8px;
        }



        .cnx-logo-text {
            font-family: 'Antonio', sans-serif;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text);
        }

        .cnx-nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cnx-nav-link {
            padding: 8px 18px;
            border-radius: 40px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: .5px;
            color: var(--muted);
            transition: all .2s;
        }

        .cnx-nav-link:hover,
        .cnx-nav-link.active {
            background: rgba(212, 169, 71, .12);
            color: var(--gold-lt);
        }

        .cnx-nav-link.active {
            border: 1px solid rgba(212, 169, 71, .25);
        }

        .cnx-logout {
            margin-left: 12px;
            padding: 8px 18px;
            border-radius: 40px;
            border: 1px solid rgba(231, 76, 60, .3);
            color: rgba(231, 76, 60, .8);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
        }

        .cnx-logout:hover {
            background: rgba(231, 76, 60, .1);
            color: var(--red);
        }


        .cnx-eyebrow {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 10px;
        }

        .cnx-title {
            font-family: 'Antonio', sans-serif;
            font-size: clamp(32px, 5vw, 56px);
            font-weight: 700;
            line-height: .95;
            letter-spacing: -1px;
            text-transform: uppercase;
            color: var(--text);
        }

        .cnx-title span {
            background: linear-gradient(90deg, var(--gold-lt), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cnx-flags {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .cnx-flag-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 40px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, .04);
            font-size: 12px;
            font-weight: 500;
            color: var(--text);
        }


        .cnx-stat-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .cnx-stat-card {
            min-width: 120px;
            background: rgba(13, 30, 48, .7);
            border: 1px solid var(--border-md);
            border-radius: 18px;
            padding: 18px 20px 16px;
            text-align: center;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
        }

        .cnx-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .cnx-glow-card {
            box-shadow: 0 0 32px rgba(212, 169, 71, .12);
            border-color: rgba(212, 169, 71, .5);
        }

        .cnx-stat-icon {
            font-size: 20px;
            line-height: 1;
            margin-bottom: 2px;
        }

        .cnx-stat-value {
            font-family: 'Antonio', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--text);
            line-height: 1;
        }

        .cnx-gold {
            color: var(--gold-lt) !important;
        }

        .cnx-stat-label {
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 500;
        }

        .cnx-mini-info {
            font-size: 11px;
            color: var(--gold);
            font-weight: 600;
            margin-top: 4px;
        }

        .cnx-ranking-tier {
            margin-top: 4px;
            font-size: 11px;
            font-weight: 700;
            color: var(--gold-lt);
            letter-spacing: .3px;
        }

        /* progress bar inside stat card */
        .cnx-stat-progress {
            width: 100%;
            margin-top: 6px;
        }

        .cnx-stat-progress-bar {
            height: 4px;
            background: rgba(255, 255, 255, .08);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .cnx-stat-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--gold-dk), var(--gold-lt));
            border-radius: 4px;
            transition: width .6s ease;
        }

        .cnx-stat-progress small {
            font-size: 10px;
            color: var(--muted);
        }

        .wc-main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 36px 28px 64px;
        }


        .wc-podium {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 16px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .wc-podium-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
        }

        .wc-podium-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px 20px 20px;
            border-radius: 20px;
            border: 1px solid;
            min-width: 180px;
            max-width: 210px;
            position: relative;
            text-align: center;
            backdrop-filter: blur(10px);
            transition: transform .2s;
        }

        .wc-podium-card:hover {
            transform: translateY(-4px);
        }

        .wc-podium-card.gold {
            background: linear-gradient(160deg, rgba(26, 19, 4, .95) 0%, rgba(13, 10, 2, .9) 100%);
            border-color: rgba(212, 169, 71, .55);
            box-shadow: 0 8px 48px rgba(212, 169, 71, .18), inset 0 1px 0 rgba(242, 206, 114, .12);
        }

        .wc-podium-card.silver {
            background: linear-gradient(160deg, rgba(10, 18, 30, .95) 0%, rgba(7, 17, 31, .9) 100%);
            border-color: rgba(184, 197, 214, .35);
            box-shadow: 0 4px 28px rgba(184, 197, 214, .08);
        }

        .wc-podium-card.bronze {
            background: linear-gradient(160deg, rgba(18, 10, 4, .95) 0%, rgba(7, 17, 31, .9) 100%);
            border-color: rgba(205, 127, 50, .35);
            box-shadow: 0 4px 28px rgba(205, 127, 50, .08);
        }

        .wc-crown {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 28px;
            filter: drop-shadow(0 0 12px rgba(212, 169, 71, .7));
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateX(-50%) translateY(0);
            }

            50% {
                transform: translateX(-50%) translateY(-5px);
            }
        }

        .wc-podium-avatar-wrap {
            position: relative;
            margin-top: 8px;
            margin-bottom: 12px;
        }

        .wc-podium-avatar {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            object-fit: cover;
            border: 2.5px solid;
            display: block;
        }

        .podium-king {
            width: 82px;
            height: 82px;
            box-shadow: 0 0 28px rgba(212, 169, 71, .45);
        }

        .gold .wc-podium-avatar {
            border-color: var(--gold);
        }

        .silver .wc-podium-avatar {
            border-color: var(--silver);
        }

        .bronze .wc-podium-avatar {
            border-color: var(--bronze);
        }

        .wc-podium-rank {
            position: absolute;
            bottom: -4px;
            right: -4px;
            font-size: 18px;
            line-height: 1;
        }

        .wc-podium-name {
            font-family: 'Antonio', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .gold .wc-podium-name {
            color: var(--gold-lt);
        }

        .silver .wc-podium-name {
            color: var(--silver-lt);
        }

        .bronze .wc-podium-name {
            color: var(--bronze-lt);
        }

        .wc-podium-realname {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
        }

        .wc-podium-project {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
        }

        .wc-podium-level {
            margin-top: 6px;
            font-size: 10px;
            padding: 3px 10px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .1);
            color: var(--text);
        }

        .wc-podium-points {
            font-family: 'Antonio', sans-serif;
            font-size: 30px;
            font-weight: 700;
            margin-top: 10px;
            line-height: 1;
        }

        .gold .wc-podium-points {
            color: var(--gold-lt);
        }

        .silver .wc-podium-points {
            color: var(--silver-lt);
        }

        .bronze .wc-podium-points {
            color: var(--bronze-lt);
        }

        .wc-podium-pts-label {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--muted);
        }

        .wc-podium-xp {
            margin-top: 6px;
            font-size: 11px;
            color: var(--gold);
            font-weight: 600;
        }

        .wc-streak-fire {
            margin-top: 4px;
            font-size: 11px;
            color: #ff9534;
            font-weight: 700;
        }

        /* podium bars */
        .wc-podium-bar {
            width: 100%;
            border-radius: 8px 8px 0 0;
            margin-top: 0;
        }

        .bar-gold {
            height: 80px;
            background: linear-gradient(180deg, rgba(212, 169, 71, .35), rgba(212, 169, 71, .05));
        }

        .bar-silver {
            height: 52px;
            background: linear-gradient(180deg, rgba(184, 197, 214, .25), rgba(184, 197, 214, .02));
        }

        .bar-bronze {
            height: 34px;
            background: linear-gradient(180deg, rgba(205, 127, 50, .25), rgba(205, 127, 50, .02));
        }


        .wc-my-banner {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0;
            background: var(--card-bg);
            border: 1px solid var(--border-md);
            border-radius: 18px;
            padding: 20px 28px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
        }

        .wc-my-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .wc-my-banner-player {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 200px;
        }

        .wc-my-banner-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--gold);
            box-shadow: 0 0 18px rgba(212, 169, 71, .25);
        }

        .wc-my-banner-title {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 2px;
        }

        .wc-my-banner-name {
            font-family: 'Antonio', sans-serif;
            font-size: 17px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--gold-lt);
            line-height: 1.1;
        }

        .wc-my-banner-realname {
            font-size: 11px;
            color: var(--muted);
        }

        .wc-my-banner-sep {
            width: 1px;
            height: 40px;
            background: rgba(212, 169, 71, .2);
            margin: 0 24px;
            flex-shrink: 0;
        }

        .wc-my-banner-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            text-align: center;
            flex-shrink: 0;
        }

        .wc-my-banner-stat-val {
            font-family: 'Antonio', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            line-height: 1;
        }

        .wc-my-banner-stat-lbl {
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
        }


        .wc-progress-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .wc-progress-bar-bg {
            flex: 1;
            height: 6px;
            background: rgba(255, 255, 255, .08);
            border-radius: 6px;
            overflow: hidden;
        }

        .wc-progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--gold-dk), var(--gold-lt));
            border-radius: 6px;
            transition: width .8s ease;
        }

        .wc-progress-pct {
            font-size: 12px;
            font-weight: 700;
            color: var(--gold-lt);
            min-width: 38px;
            text-align: right;
        }


        .wc-tabs-wrap {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-card);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .wc-tabs-nav {
            display: flex;
            gap: 4px;
            padding: 16px 20px 0;
            border-bottom: 1px solid var(--border);
        }

        .wc-tab-btn {
            padding: 10px 20px 12px;
            border: none;
            border-bottom: 2px solid transparent;
            background: none;
            color: var(--muted);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            letter-spacing: .3px;
            transition: all .2s;
            white-space: nowrap;
            border-radius: 10px 10px 0 0;
        }

        .wc-tab-btn:hover {
            color: var(--text);
            background: rgba(255, 255, 255, .04);
        }

        .wc-tab-btn.active {
            color: var(--gold-lt);
            border-bottom-color: var(--gold);
            background: rgba(212, 169, 71, .06);
        }

        .wc-tab-content {
            display: none;
            padding: 0;
        }

        .wc-tab-content.active {
            display: block;
        }

        .wc-ranking-wrap {
            padding: 8px 0;
        }

        div.dataTables_wrapper {
            padding: 16px 24px 20px;
            color: var(--text);
        }

        div.dataTables_filter label,
        div.dataTables_length label {
            color: var(--muted);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        div.dataTables_filter input,
        div.dataTables_length select {
            background: rgba(255, 255, 255, .06);
            border: 1px solid var(--border-md);
            border-radius: 8px;
            color: var(--text);
            padding: 6px 12px;
            font-size: 13px;
            outline: none;
        }

        div.dataTables_filter input:focus,
        div.dataTables_length select:focus {
            border-color: var(--gold);
        }

        div.dataTables_info {
            color: var(--muted);
            font-size: 12px;
        }

        div.dataTables_paginate .paginate_button {
            color: var(--muted) !important;
            border-radius: 8px !important;
            border: none !important;
            font-size: 13px !important;
            padding: 4px 12px !important;
        }

        div.dataTables_paginate .paginate_button.current,
        div.dataTables_paginate .paginate_button:hover {
            background: rgba(212, 169, 71, .15) !important;
            color: var(--gold-lt) !important;
            border: 1px solid var(--border-md) !important;
        }


        .wc-ranking-table {
            width: 100% !important;
            border-collapse: collapse;
        }

        .wc-ranking-table thead th {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 500;
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
            background: transparent;
            text-align: left;
        }

        .th-center {
            text-align: center !important;
        }

        .wc-ranking-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, .04);
            transition: background .15s;
        }

        .wc-ranking-table tbody tr:hover {
            background: rgba(212, 169, 71, .04);
        }

        .wc-ranking-table tbody tr:last-child {
            border-bottom: none;
        }

        .wc-ranking-table tbody td {
            padding: 12px;
            vertical-align: middle;
            font-size: 13px;
        }

        /* rank badge */
        .wc-rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            font-family: 'Antonio', sans-serif;
            font-size: 14px;
            font-weight: 700;
        }

        .rank-1 {
            background: linear-gradient(135deg, #D4A947, #F2CE72);
            color: var(--navy);
        }

        .rank-2 {
            background: linear-gradient(135deg, #A8B8C8, #D0DCE8);
            color: var(--navy);
        }

        .rank-3 {
            background: linear-gradient(135deg, #CD7F32, #E8A96A);
            color: var(--navy);
        }

        .rank-other {
            background: rgba(255, 255, 255, .07);
            color: var(--muted);
        }

        .wc-player-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .wc-rank-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid var(--border-md);
            flex-shrink: 0;
        }

        .wc-rank-pseudo {
            font-weight: 600;
            font-size: 13px;
            color: var(--text);
        }

        .wc-rank-name {
            font-size: 11px;
            color: var(--muted);
            margin-top: 1px;
        }

        /* current user row highlight */
        .wc-ranking-table tbody tr.is-me {
            background: rgba(212, 169, 71, .07) !important;
        }

        .wc-ranking-table tbody tr.is-me td:first-child {
            border-left: 3px solid var(--gold);
        }

        .wc-pts-cell {
            font-family: 'Antonio', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--gold-lt);
            text-align: center;
        }

        .wc-prog-cell {
            min-width: 140px;
        }

        .wc-prog-bar-bg {
            height: 5px;
            background: rgba(255, 255, 255, .07);
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .wc-prog-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--gold-dk), var(--gold-lt));
            border-radius: 5px;
        }

        .wc-prog-pct {
            font-size: 11px;
            color: var(--muted);
        }

        .wc-score-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            background: rgba(212, 169, 71, .12);
            border: 1px solid var(--border-md);
            font-size: 12px;
            font-weight: 700;
            color: var(--gold-lt);
        }

        .wc-footer {
            border-top: 1px solid var(--border);
            padding: 20px 28px;
            text-align: center;
        }

        .wc-footer-text {
            font-size: 12px;
            color: var(--muted);
            letter-spacing: .5px;
        }

        .wc-footer-text span {
            color: var(--gold);
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .wc-my-banner {
                flex-wrap: wrap;
                gap: 16px;
            }

            .wc-my-banner-sep {
                display: none;
            }

            .wc-my-banner-stat {
                flex: 1 1 calc(50% - 8px);
                align-items: flex-start;
            }

            .wc-my-banner-player {
                flex: 100%;
            }

            .wc-podium-card {
                min-width: 150px;
            }
        }

        @media (max-width: 640px) {
            .wc-main {
                padding: 20px 16px 48px;
            }



            .cnx-header-inner {
                padding: 0 16px;
            }


            .cnx-stat-row {
                flex-wrap: wrap;
            }

            .cnx-stat-card {
                min-width: calc(50% - 6px);
            }

            .wc-tabs-nav {
                flex-wrap: wrap;
                gap: 6px;
            }

            .wc-ranking-table thead th:nth-child(3),
            .wc-ranking-table thead th:nth-child(4),
            .wc-ranking-table tbody td:nth-child(3),
            .wc-ranking-table tbody td:nth-child(4) {
                display: none;
            }
        }


        .cnx-table-wrap {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            background:
                linear-gradient(145deg,
                    rgba(18, 22, 40, 0.95),
                    rgba(10, 12, 24, 0.98));
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow:
                0 10px 35px rgba(0, 0, 0, 0.45),
                inset 0 1px 0 rgba(255, 255, 255, 0.03);
            padding: 12px;
            backdrop-filter: blur(18px);
        }


        #cnxtable {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 10px !important;
        }


        #cnxtable thead th {
            position: sticky;
            top: 0;
            z-index: 5;

            background:
                linear-gradient(135deg,
                    rgba(255, 255, 255, 0.08),
                    rgba(255, 255, 255, 0.03));

            color: #fff;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;

            padding: 16px 18px;

            border: none !important;
            backdrop-filter: blur(10px);
        }



        #cnxtable tbody tr {
            transition:
                transform .18s ease,
                background .18s ease,
                box-shadow .18s ease;

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, 0.03),
                    rgba(255, 255, 255, 0.015));

            border-radius: 18px;
        }

        #cnxtable tbody tr:hover {
            transform: translateY(-2px);

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, 0.06),
                    rgba(255, 255, 255, 0.03));

            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.28);
        }


        #cnxtable tbody td {
            padding: 18px 16px;
            vertical-align: middle;
            border: none !important;
            color: #f5f7ff;
            font-size: 14px;
        }

        .cnx-match-cell {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .cnx-team-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 90px;
        }

        .cnx-team-avatar {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.04);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        .cnx-team-name {
            margin-top: 8px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            line-height: 1.3;
        }


        .cnx-vs-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .cnx-vs-text {
            font-size: 15px;
            font-weight: 800;
            color: #ffd54a;
            letter-spacing: 1px;
        }

        .cnx-match-date {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.68);
        }

        .cnx-phase-badge {
            padding: 4px 10px;
            border-radius: 999px;

            background:
                linear-gradient(135deg,
                    rgba(255, 215, 64, 0.18),
                    rgba(255, 180, 0, 0.12));

            border: 1px solid rgba(255, 215, 64, 0.25);

            color: #ffd54a;
            font-size: 11px;
            font-weight: 700;
        }


        .cnx-pred-display,
        .cnx-result-display {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cnx-pred-avatar,
        .cnx-result-avatar,
        .cnx-null-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.08);
        }

        .cnx-pred-name,
        .cnx-result-name {
            font-weight: 700;
            font-size: 14px;
        }


        .cnx-select {
            width: 100%;
            min-width: 160px;

            background: rgba(255, 255, 255, 0.06);
            color: #fff;

            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;

            padding: 10px 14px;

            outline: none;

            transition: all .18s ease;
        }

        .cnx-select:focus {
            border-color: #ffd54a;
            box-shadow: 0 0 0 4px rgba(255, 213, 74, 0.12);
        }


        .cnx-btn-ok,
        .cnx-btn-done {
            border: none;
            border-radius: 12px;

            padding: 10px 14px;

            font-weight: 700;
            font-size: 13px;

            transition: all .18s ease;
        }

        .cnx-btn-ok {
            background:
                linear-gradient(135deg,
                    #00c853,
                    #00e676);

            color: #fff;
        }

        .cnx-btn-ok:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(0, 230, 118, 0.28);
        }

        .cnx-btn-done {
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.55);
        }


        .dataTables_wrapper .dataTables_filter input {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            color: #fff;
            padding: 8px 12px;
        }

        .dataTables_wrapper .dataTables_length select {
            background: rgba(255, 255, 255, 0.06);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
        }


        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 10px !important;
            border: none !important;
            background: transparent !important;
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background:
                linear-gradient(135deg,
                    #ffd54a,
                    #ffb300) !important;

            color: #111 !important;
        }



        @media (max-width: 768px) {

            .cnx-match-cell {
                flex-direction: column;
                gap: 12px;
            }

            .cnx-team-avatar {
                width: 44px;
                height: 44px;
            }

            #cnxtable tbody td {
                padding: 14px 10px;
            }
        }
    </style>

    {{-- GOLD STRIPE --}}
    <div class="cnx-stripe"></div>

    <div class="wc-app">

        {{-- ── HEADER ── --}}
        <header class="cnx-header">
            <div class="cnx-header-inner">
                <a href="{{ url('/') }}" class="cnx-logo">
                    @if (file_exists(public_path('avatars/logo.webp')))
                        <img src="{{ asset('avatars/logo.webp') }}" alt="Logo Concentrix">
                    @else
                        <div class="cnx-logo-badge">Game Changer</div>
                    @endif
                </a>

                <nav class="cnx-nav">
                    <a href="{{ route('home') }}" class="cnx-nav-link">Pronostics</a>
                    <a href="{{ route('classement') }}" class="cnx-nav-link active">Classements</a>
                    <a href="{{ route('duels') }}" class="cnx-nav-link">Duels</a>
                    <a href="{{ route('guide') }}" class="cnx-nav-link">Aide</a>
                    <form method="POST" action="{{ route('logout.user') }}" style="display:inline;" >
                        @csrf

                        <button type="submit" class="cnx-nav-link"style=" background-color: #a11a1ad4; color: white;">
                            Déconnexion
                        </button>
                    </form>
                </nav>
            </div>
        </header>

        {{-- ── HERO ── --}}
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


            </div>
        </div>

        {{-- ── MAIN ── --}}
        <main class="wc-main">

            {{-- ══ PODIUM ══ --}}
            @if ($users && $users->count() >= 3)
                @php $top = $users->take(3)->values(); @endphp

                <div class="wc-podium">

                    {{-- 2ème --}}
                    <div class="wc-podium-step">
                        <div class="wc-podium-card silver">
                            <div class="wc-podium-avatar-wrap">
                                 <img src="{{ asset('avatars/avatar.webp') }}?v={{ time() }}"  class="wc-podium-avatar"  alt="Avatar">
                                <div class="wc-podium-rank">🥈</div>
                            </div>
                            <span class="wc-podium-name">{{ $top[1]->pseudo ?? $top[1]->name }}</span>
                            <span class="wc-podium-realname">{{ $top[1]->name }}</span>
                            <span class="wc-podium-project">{{ $top[1]->projet_service }}</span>
                            <div class="wc-podium-level">⭐ Niveau {{ $top[1]->level ?? 1 }}</div>
                            <span class="wc-podium-points">{{ $top[1]->points }}</span>
                            <span class="wc-podium-pts-label">pts</span>
                            <div class="wc-podium-xp">⚡ {{ $top[1]->xp ?? 0 }} XP</div>
                        </div>
                        <div class="wc-podium-bar bar-silver"></div>
                    </div>

                    {{-- 1er --}}
                    <div class="wc-podium-step">
                        <div class="wc-podium-card gold">
                            <div class="wc-crown">👑</div>
                            <div class="wc-podium-avatar-wrap">
                              <img
    src="{{ asset($top[0]->avatar ?: 'avatars/avatar.webp') }}?v={{ time() }}"
    class="wc-podium-avatar podium-king"
    alt="Avatar"
>
                                <div class="wc-podium-rank">🥇</div>
                            </div>
                            <span class="wc-podium-name">{{ $top[0]->pseudo ?? $top[0]->name }}</span>
                            <span class="wc-podium-realname">{{ $top[0]->name }}</span>
                            <span class="wc-podium-project">{{ $top[0]->projet_service }}</span>
                            <div class="wc-podium-level">⭐ Niveau {{ $top[0]->level ?? 1 }}</div>
                            <span class="wc-podium-points">{{ $top[0]->points }}</span>
                            <span class="wc-podium-pts-label">pts</span>
                            <div class="wc-podium-xp">⚡ {{ $top[0]->xp ?? 0 }} XP</div>
                            <div class="wc-streak-fire">🔥 Meilleure série : {{ $top[0]->best_streak ?? 0 }}</div>
                        </div>
                        <div class="wc-podium-bar bar-gold"></div>
                    </div>

                    {{-- 3ème --}}
                    <div class="wc-podium-step">
                        <div class="wc-podium-card bronze">
                            <div class="wc-podium-avatar-wrap">
                                <img src="{{ asset($top[2]->avatar ?? 'avatars/avatar.webp') }}?v={{ time() }}" class="wc-podium-avatar"
                                    alt="Avatar">
                                <div class="wc-podium-rank">🥉</div>
                            </div>
                            <span class="wc-podium-name">{{ $top[2]->pseudo ?? $top[2]->name }}</span>
                            <span class="wc-podium-realname">{{ $top[2]->name }}</span>
                            <span class="wc-podium-project">{{ $top[2]->projet_service }}</span>
                            <div class="wc-podium-level">⭐ Niveau {{ $top[2]->level ?? 1 }}</div>
                            <span class="wc-podium-points">{{ $top[2]->points }}</span>
                            <span class="wc-podium-pts-label">pts</span>
                            <div class="wc-podium-xp">⚡ {{ $top[2]->xp ?? 0 }} XP</div>
                        </div>
                        <div class="wc-podium-bar bar-bronze"></div>
                    </div>

                </div>
            @endif

            {{-- ══ MA POSITION ══ --}}
            @php
                $currentUser = Auth::user();
                $myRank = null;
                $myPoints = 0;
                $maxPts = $users->first()?->points ?? 1;

                foreach ($users as $idx => $u) {
                    if ($u->id === $currentUser->id) {
                        $myRank = $idx + 1;
                        $myPoints = $u->points;
                        break;
                    }
                }

                $myPct = $maxPts > 0 ? round(($myPoints / $maxPts) * 100) : 0;
            @endphp

            @if ($myRank)
                <div class="wc-my-banner">
                    <div class="wc-my-banner-player">
                        <img src="{{ asset($currentUser->avatar ?? 'avatars/avatar.webp') }}?v={{ time() }}" class="wc-my-banner-avatar"
                            alt="Avatar">
                        <div>
                            <div class="wc-my-banner-title">Ma position</div>
                            <div class="wc-my-banner-name">{{ $currentUser->pseudo ?? $currentUser->name }}</div>
                            <div class="wc-my-banner-realname">{{ $currentUser->name }}</div>
                        </div>
                    </div>

                    <div class="wc-my-banner-sep"></div>

                    <div class="wc-my-banner-stat">
                        <span class="wc-my-banner-stat-val">
                            {{ $myRank }}<small
                                style="font-size:12px;color:var(--muted);">/{{ $users->count() }}</small>
                        </span>
                        <span class="wc-my-banner-stat-lbl">Classement</span>
                    </div>

                    <div class="wc-my-banner-sep"></div>

                    <div class="wc-my-banner-stat">
                        <span class="wc-my-banner-stat-val">{{ $myPoints }}</span>
                        <span class="wc-my-banner-stat-lbl">Points</span>
                    </div>

                    <div class="wc-my-banner-sep"></div>

                    <div class="wc-my-banner-stat">
                        <span class="wc-my-banner-stat-val">⭐ {{ $currentUser->level ?? 1 }}</span>
                        <span class="wc-my-banner-stat-lbl">Niveau</span>
                    </div>

                    <div class="wc-my-banner-sep"></div>

                    <div class="wc-my-banner-stat">
                        <span class="wc-my-banner-stat-val">⚡ {{ $currentUser->xp ?? 0 }}</span>
                        <span class="wc-my-banner-stat-lbl">XP</span>
                    </div>

                    <div class="wc-my-banner-sep"></div>

                    <div class="wc-my-banner-stat" style="flex:1; min-width:160px;">
                        <div class="wc-progress-wrap">
                            <div class="wc-progress-bar-bg">
                                <div class="wc-progress-bar-fill" style="width:{{ $myPct }}%;"></div>
                            </div>
                            <span class="wc-progress-pct">{{ $myPct }}%</span>
                        </div>
                        <span class="wc-my-banner-stat-lbl">vs leader</span>
                    </div>
                </div>
            @endif

            {{-- ══ ONGLETS CLASSEMENTS ══ --}}

            <div class="cnx-table-wrap">

                <div class="wc-tabs-nav">
                    <button class="wc-tab-btn active" data-tab="players">👤 Classement joueurs</button>
                    <button class="wc-tab-btn" data-tab="services">🏢 Classement des services</button>
                    <button class="wc-tab-btn" data-tab="myservice">👥 Mon service</button>
                </div>

                {{-- JOUEURS --}}
                <div class="wc-tab-content active" id="tab-players">
                    <div class="wc-ranking-wrap">
                        <table class="wc-ranking-table" id="rankingTable">
                            <thead>
                                <tr>
                                    <th style="width:56px;">#</th>
                                    <th>Joueur</th>
                                    <th>Projet / Service</th>
                                    <th>Fonction</th>
                                    <th class="th-center" style="width:90px;">Points</th>
                                    <th style="width:200px;">Progression</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                {{-- SERVICES --}}
                <div class="wc-tab-content" id="tab-services">
                    <div class="wc-ranking-wrap">
                        <table class="wc-ranking-table" id="serviceRankingTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Service</th>
                                    <th>Participants</th>
                                    <th>Matchs joués</th>
                                    <th>Pronostics</th>
                                    <th>Points</th>
                                    <th>Participation</th>
                                    <th>Précision</th>
                                    <th>Score équitable</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                {{-- MON SERVICE --}}
                <div class="wc-tab-content" id="tab-myservice">
                    <div class="wc-ranking-wrap">
                        <table class="wc-ranking-table" id="myServiceRankingTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Joueur</th>
                                    <th>Fonction</th>
                                    <th>Points</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

        </main>

        <footer class="wc-footer">
            <div class="wc-footer-text">
                Concentrix · Game Changer · FIFA World Cup 2026™ · <span>Developed by Lallène ACHI</span>
            </div>
        </footer>

    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {

            /* ── JOUEURS ── */
            $('#rankingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('classement.joueurs.data') }}",
                order: [
                    [0, 'asc']
                ],
                responsive: true,
                pageLength: 25,
                columns: [{
                        data: 'rank',
                        name: 'user_scores.rank'
                    },
                    {
                        data: 'joueur',
                        name: 'users.name',
                        orderable: false
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
                        data: 'points',
                        name: 'user_scores.points',
                        className: 'wc-pts-cell'
                    },
                    {
                        data: 'progression',
                        orderable: false,
                        searchable: false,
                        className: 'wc-prog-cell'
                    }
                ],
                language: {
                    processing: "Chargement...",
                    search: "Rechercher :",
                    lengthMenu: "Afficher _MENU_ joueurs",
                    info: "_START_ à _END_ sur _TOTAL_ participants",
                    infoEmpty: "Aucun participant",
                    paginate: {
                        previous: "‹",
                        next: "›"
                    }
                },
                createdRow: function(row, data) {
                    /* highlight current user */
                    if (data.is_me) $(row).addClass('is-me');
                }
            });

            /* ── SERVICES ── */
            $('#serviceRankingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('classement.services.data') }}",
                ordering: false,
                responsive: true,
                pageLength: 25,
                columns: [{
                        data: 'rank',
                        name: 'rank'
                    },
                    {
                        data: 'service',
                        name: 'service'
                    },
                    {
                        data: 'participants_display',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nb_matches_joues',
                        name: 'nb_matches_joues'
                    },
                    {
                        data: 'total_pronostics',
                        name: 'total_pronostics'
                    },
                    {
                        data: 'points',
                        name: 'points',
                        className: 'wc-pts-cell'
                    },
                    {
                        data: 'participation_display',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'precision_display',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'score_display',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    processing: "Chargement...",
                    search: "Rechercher :",
                    lengthMenu: "Afficher _MENU_ services",
                    info: "_START_ à _END_ sur _TOTAL_ services",
                    infoEmpty: "Aucun service",
                    paginate: {
                        previous: "‹",
                        next: "›"
                    }
                }
            });

            /* ── MON SERVICE ── */
            $('#myServiceRankingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('classement.monservice.data') }}",
                ordering: false,
                responsive: true,
                pageLength: 25,
                columns: [{
                        data: 'rank',
                        name: 'user_scores.rank'
                    },
                    {
                        data: 'joueur',
                        name: 'users.name',
                        orderable: false
                    },
                    {
                        data: 'fonction',
                        name: 'users.fonction'
                    },
                    {
                        data: 'points',
                        name: 'user_scores.points',
                        className: 'wc-pts-cell'
                    }
                ],
                language: {
                    processing: "Chargement...",
                    search: "Rechercher :",
                    lengthMenu: "Afficher _MENU_ joueurs",
                    info: "_START_ à _END_ sur _TOTAL_ collègues",
                    infoEmpty: "Aucun collègue",
                    paginate: {
                        previous: "‹",
                        next: "›"
                    }
                },
                createdRow: function(row, data) {
                    if (data.is_me) $(row).addClass('is-me');
                }
            });

            /* ── ONGLETS ── */
            $('.wc-tab-btn').on('click', function() {
                const tab = $(this).data('tab');
                $('.wc-tab-btn').removeClass('active');
                $(this).addClass('active');
                $('.wc-tab-content').removeClass('active');
                $('#tab-' + tab).addClass('active');
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust().responsive.recalc();
            });

        });
    </script>

@endsection
