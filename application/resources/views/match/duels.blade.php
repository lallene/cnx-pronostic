@extends('layouts.app')

@section('title', 'Les Duels')

@section('content')



    <style>
        :root {
            --gold: #f0ce7a;
            --gold-deep: #c9a84c;
            --gold-glow: rgba(201, 168, 76, .22);
            --bg: #050d1a;
            --surface: rgba(255, 255, 255, .04);
            --surface-md: rgba(255, 255, 255, .07);
            --border: rgba(255, 255, 255, .08);
            --border-md: rgba(255, 255, 255, .14);
            --text: #f0f4ff;
            --muted: #6b7a99;
            --green: #22c55e;
            --red: #ef4444;
            --blue: #3b82f6;
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 10px;
        }

        .arena-wrap {
            max-width: 1160px;
            margin: 0 auto;
            padding: 0 24px 80px;
        }

        .arena-heading {
            display: flex;
            align-items: baseline;
            gap: 16px;
            margin-bottom: 8px;
        }

        .arena-heading-title {
            font-family: 'Anton', sans-serif;
            font-size: clamp(34px, 5vw, 52px);
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text);
            line-height: 1;
        }

        .arena-heading-title span {
            color: var(--gold);
        }

        .arena-heading-subtitle {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--muted);
            margin-bottom: 36px;
        }

        .arena-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            border-radius: var(--radius-md);
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
        }

        .arena-alert-success {
            background: rgba(34, 197, 94, .1);
            border: 1px solid rgba(34, 197, 94, .25);
            color: #86efac;
        }

        .arena-alert-error {
            background: rgba(239, 68, 68, .1);
            border: 1px solid rgba(239, 68, 68, .25);
            color: #fca5a5;
        }

        .create-card {
            position: relative;
            background: var(--surface);
            border: 1px solid var(--border-md);
            border-radius: var(--radius-lg);
            padding: 32px;
            margin-bottom: 48px;
            overflow: hidden;
        }

        .create-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(201, 168, 76, .06) 0%, transparent 60%);
            pointer-events: none;
        }

        .create-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }

        .create-card-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--gold), var(--gold-deep));
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .create-card-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text);
        }

        .create-card-desc {
            font-family: 'Barlow', sans-serif;
            font-size: 13px;
            color: var(--muted);
            margin-top: 2px;
        }

        .create-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .create-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .create-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--muted);
        }

        .create-input,
        .create-select {
            height: 48px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, .05);
            color: var(--text);
            padding: 0 14px;
            outline: none;
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            transition: border-color .2s, box-shadow .2s;
            -webkit-appearance: none;
        }

        .create-input:focus,
        .create-select:focus {
            border-color: var(--gold-deep);
            box-shadow: 0 0 0 3px var(--gold-glow);
        }

        .create-select option {
            background: #0a1628;
            color: var(--text);
        }

        .create-help {
            font-family: 'Barlow', sans-serif;
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px;
        }

        .create-footer {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-launch {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 52px;
            padding: 0 32px;
            border: none;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, var(--gold), var(--gold-deep));
            color: #050d1a;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
        }

        .btn-launch:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(201, 168, 76, .35);
        }

        .jackpot-preview {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 14px;
            color: var(--muted);
            letter-spacing: .5px;
        }

        .jackpot-preview strong {
            color: var(--gold);
            font-size: 16px;
        }

        .duels-list-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .duels-list-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 22px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text);
        }

        .duels-count {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 6px 14px;
            border-radius: 999px;
            background: var(--surface-md);
            border: 1px solid var(--border);
            color: var(--muted);
        }

        .duel-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .duel-item {
            position: relative;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 24px 28px;
            transition: border-color .2s, transform .2s;
            overflow: hidden;
        }

        .duel-item::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            border-radius: 3px 0 0 3px;
            background: var(--border);
            transition: background .2s;
        }

        .duel-item:hover {
            border-color: var(--border-md);
            transform: translateY(-1px);
        }

        /* status accent */
        .duel-item[data-status="pending"]::after {
            background: #f59e0b;
        }

        .duel-item[data-status="accepted"]::after {
            background: var(--blue);
        }

        .duel-item[data-status="winner"]::after {
            background: var(--green);
        }

        .duel-item[data-status="loser"]::after {
            background: var(--red);
        }

        .duel-item[data-status="draw"]::after {
            background: var(--muted);
        }

        .duel-item[data-status="refused"]::after {
            background: var(--red);
        }

        .duel-inner {
            display: grid;
            grid-template-columns: 1fr 56px 1fr;
            align-items: center;
            gap: 20px;
        }

        /* Player side */
        .duel-player {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .duel-player.right {
            flex-direction: row-reverse;
            text-align: right;
        }

        .duel-avatar-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .duel-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-md);
            display: block;
        }

        .duel-avatar-ring {
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            border: 2px solid transparent;
            transition: border-color .2s;
        }

        .duel-item[data-status="winner"] .duel-player.left .duel-avatar-ring {
            border-color: var(--green);
        }

        .duel-item[data-status="loser"] .duel-player.left .duel-avatar-ring {
            border-color: var(--red);
        }

        .duel-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: .3px;
        }

        .duel-service {
            font-family: 'Barlow', sans-serif;
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .duel-bet-tag {
            display: inline-block;
            margin-top: 6px;
            padding: 3px 10px;
            border-radius: 999px;
            background: var(--gold-glow);
            border: 1px solid rgba(201, 168, 76, .2);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: .5px;
        }

        /* VS separator */
        .duel-vs {
            font-family: 'Anton', sans-serif;
            font-size: 26px;
            color: var(--gold);
            text-align: center;
            line-height: 1;
            opacity: .85;
        }

        /* Match info bar */
        .duel-meta {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .duel-match-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            color: var(--text);
        }

        .duel-match-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--surface-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .duel-match-teams {
            font-weight: 600;
        }

        .duel-match-date {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .duel-jackpot {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 14px;
            color: var(--muted);
        }

        .duel-jackpot strong {
            color: var(--gold);
            font-size: 16px;
        }

        /* Predictions row */
        .duel-preds {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
        }

        .duel-pred-box {
            flex: 1;
            background: rgba(255, 255, 255, .03);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
        }

        .duel-pred-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .duel-pred-value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }

        .duel-pred-sep {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            flex-shrink: 0;
        }

        /* Status + Actions row */
        .duel-actions-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-top: 16px;
            flex-wrap: wrap;
        }

        /* Status pill */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 999px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        .status-pill.pending {
            background: rgba(245, 158, 11, .12);
            border: 1px solid rgba(245, 158, 11, .2);
            color: #fbbf24;
        }

        .status-pill.accepted {
            background: rgba(59, 130, 246, .12);
            border: 1px solid rgba(59, 130, 246, .2);
            color: #60a5fa;
        }

        .status-pill.winner {
            background: rgba(34, 197, 94, .12);
            border: 1px solid rgba(34, 197, 94, .2);
            color: #4ade80;
        }

        .status-pill.loser {
            background: rgba(239, 68, 68, .12);
            border: 1px solid rgba(239, 68, 68, .2);
            color: #f87171;
        }

        .status-pill.draw {
            background: rgba(156, 163, 175, .12);
            border: 1px solid rgba(156, 163, 175, .2);
            color: #d1d5db;
        }

        .status-pill.refused {
            background: rgba(239, 68, 68, .12);
            border: 1px solid rgba(239, 68, 68, .2);
            color: #f87171;
        }

        /* Accept form */
        .accept-form {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .accept-select {
            height: 42px;
            min-width: 170px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-md);
            background: rgba(255, 255, 255, .06);
            color: var(--text);
            padding: 0 12px;
            font-family: 'Barlow', sans-serif;
            font-size: 13px;
            outline: none;
            transition: border-color .2s;
            -webkit-appearance: none;
        }

        .accept-select:focus {
            border-color: var(--gold-deep);
        }

        .accept-select option {
            background: #0a1628;
        }

        .btn-accept,
        .btn-refuse {
            height: 42px;
            padding: 0 18px;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
        }

        .btn-accept {
            background: var(--green);
            color: #050d1a;
        }

        .btn-refuse {
            background: rgba(239, 68, 68, .15);
            border: 1px solid rgba(239, 68, 68, .3);
            color: #f87171;
        }

        .btn-accept:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, .3);
        }

        .btn-refuse:hover {
            transform: translateY(-2px);
            background: rgba(239, 68, 68, .25);
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            padding: 64px 32px;
            border-radius: var(--radius-lg);
            border: 1px dashed var(--border-md);
            background: var(--surface);
            text-align: center;
        }

        .empty-icon {
            font-size: 48px;
            opacity: .5;
        }

        .empty-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text);
            opacity: .6;
        }

        .empty-desc {
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            color: var(--muted);
            max-width: 300px;
        }

        .duel-pred-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .duel-pred-logo {
            width: 34px;
            height: 34px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, .08);
            background: #0b1525;
        }


        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            height: 58px;
            border-radius: 22px;
            border: 2px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .05);
            color: #fff;
            display: flex;
            align-items: center;
            padding: 0 16px;
            transition: .25s;
        }

        .select2-container--default .select2-selection--single:hover {
            border-color: #d7b85c;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #d7b85c;
            box-shadow: 0 0 0 4px rgba(215, 184, 92, .15);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
            line-height: 54px;
            font-size: 15px;
            font-weight: 500;
            padding-left: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 54px;
            right: 12px;
        }

        .select2-dropdown {
            background: #081528;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .45);
        }

        .select2-search--dropdown {
            padding: 12px;
            background: #081528;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            height: 44px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .05);
            color: #fff;
            padding: 0 14px;
            outline: none;
        }

        .select2-results {
            background: #081528;
        }

        .select2-results__option {
            padding: 14px 16px;
            font-size: 14px;
            color: #fff;
            transition: .15s;
        }

        .select2-results__option:hover {
            background: rgba(215, 184, 92, .12);
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background: #d7b85c;
            color: #071426;
            font-weight: 700;
        }

        .select2-results__option[aria-selected=true] {
            background: rgba(255, 255, 255, .04);
        }

        .select2-container--default .select2-results>.select2-results__options {
            max-height: 320px;
        }


        .select2-results__options::-webkit-scrollbar {
            width: 8px;
        }

        .select2-results__options::-webkit-scrollbar-track {
            background: #081528;
        }

        .select2-results__options::-webkit-scrollbar-thumb {
            background: #d7b85c;
            border-radius: 999px;
        }


        @media (max-width:768px) {

            .select2-container--default .select2-selection--single {
                height: 52px;
                border-radius: 16px;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 48px;
                font-size: 14px;
            }

        }

        .match-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            width: 100%;
        }

        .match-option-left {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .match-team {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #fff;
        }

        .match-team-logo {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, .08);
            background: #0b1525;
        }

        .match-vs {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #d7b85c;
            text-transform: uppercase;
        }

        .match-option-date {
            font-size: 11px;
            color: #9ca3af;
            white-space: nowrap;
        }

        /* Dropdown Select2 */

        .select2-results__option {
            padding: 14px 16px !important;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
        }

        .select2-results__option:last-child {
            border-bottom: none;
        }

        /* Selected item */

        .select2-selection__rendered .match-option {
            padding-right: 10px;
        }

        /* Responsive */

        @media (max-width:768px) {

            .match-option {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }

            .match-option-date {
                margin-left: 36px;
            }

            .match-team-logo {
                width: 24px;
                height: 24px;
            }

        }

        @media (max-width: 860px) {
            .create-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 600px) {
            .create-grid {
                grid-template-columns: 1fr;
            }

            .create-card {
                padding: 20px;
            }

            .duel-inner {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 12px;
            }

            .duel-player,
            .duel-player.right {
                flex-direction: column;
                text-align: center;
            }

            .duel-vs {
                font-size: 18px;
            }

            .duel-meta {
                flex-direction: column;
                align-items: flex-start;
            }

            .duel-preds {
                flex-direction: column;
            }

            .duel-actions-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .accept-form {
                flex-direction: column;
                align-items: stretch;
            }
        }

        /* ═══════════════════════════════════
           DUELS LIST
        ═══════════════════════════════════ */

        .duel-list {

            display: flex;
            flex-direction: column;

            gap: 22px;
        }

        /* ═══════════════════════════════════
           CARD
        ═══════════════════════════════════ */

        .duel-item {

            position: relative;

            overflow: hidden;

            border-radius: 28px;

            padding: 24px;

            background:
                linear-gradient(145deg,
                    rgba(18, 22, 40, .96),
                    rgba(8, 10, 22, .98));

            border: 1px solid rgba(255, 255, 255, .05);

            box-shadow:
                0 12px 35px rgba(0, 0, 0, .35),
                inset 0 1px 0 rgba(255, 255, 255, .03);

            backdrop-filter: blur(18px);

            transition:
                transform .2s ease,
                box-shadow .2s ease,
                border-color .2s ease;
        }

        .duel-item:hover {

            transform: translateY(-3px);

            border-color: rgba(255, 215, 64, .22);

            box-shadow:
                0 18px 45px rgba(0, 0, 0, .45);
        }

        /* ═══════════════════════════════════
           STATUS COLORS
        ═══════════════════════════════════ */

        .duel-item[data-status="winner"] {
            border: 1px solid rgba(0, 255, 140, .22);
        }

        .duel-item[data-status="loser"] {
            border: 1px solid rgba(255, 70, 70, .18);
        }

        .duel-item[data-status="accepted"] {
            border: 1px solid rgba(255, 215, 64, .18);
        }

        /* ═══════════════════════════════════
           HEADER
        ═══════════════════════════════════ */

        .duel-inner {

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 18px;
        }

        /* ═══════════════════════════════════
           PLAYER
        ═══════════════════════════════════ */

        .duel-player {

            display: flex;
            align-items: center;

            gap: 14px;

            width: 42%;
        }

        .duel-player.right {
            justify-content: flex-end;
            text-align: right;
        }

        /* ═══════════════════════════════════
           AVATAR
        ═══════════════════════════════════ */

        .duel-avatar-wrap {
            position: relative;
        }

        .duel-avatar {

            width: 72px;
            height: 72px;

            object-fit: cover;

            border-radius: 50%;

            border: 3px solid rgba(255, 255, 255, .08);

            box-shadow:
                0 6px 18px rgba(0, 0, 0, .28);
        }

        .duel-avatar-ring {

            position: absolute;
            inset: -5px;

            border-radius: 50%;

            border: 2px solid rgba(255, 215, 64, .35);

            animation: duelPulse 2.8s infinite;
        }

        @keyframes duelPulse {

            0% {
                transform: scale(1);
                opacity: .8;
            }

            50% {
                transform: scale(1.06);
                opacity: .35;
            }

            100% {
                transform: scale(1);
                opacity: .8;
            }
        }

        /* ═══════════════════════════════════
           TEXT
        ═══════════════════════════════════ */

        .duel-name {

            font-size: 16px;
            font-weight: 800;

            color: #fff;
        }

        .duel-service {

            margin-top: 4px;

            font-size: 12px;

            color: rgba(255, 255, 255, .65);
        }

        .duel-bet-tag {

            margin-top: 8px;

            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 6px 12px;

            border-radius: 999px;

            background:
                linear-gradient(135deg,
                    rgba(255, 215, 64, .18),
                    rgba(255, 180, 0, .12));

            color: #ffd54a;

            font-size: 11px;
            font-weight: 700;
        }

        /* ═══════════════════════════════════
           VS
        ═══════════════════════════════════ */

        .duel-vs {

            width: 80px;
            height: 80px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                radial-gradient(circle,
                    rgba(255, 215, 64, .22),
                    rgba(255, 215, 64, .06));

            border: 1px solid rgba(255, 215, 64, .2);

            color: #ffd54a;

            font-size: 22px;
            font-weight: 900;

            letter-spacing: 1px;
        }

        /* ═══════════════════════════════════
           MATCH META
        ═══════════════════════════════════ */

        .duel-meta {

            margin-top: 22px;
            padding-top: 18px;

            border-top: 1px solid rgba(255, 255, 255, .06);

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 18px;
        }

        .duel-match-info {

            display: flex;
            align-items: center;

            gap: 12px;
        }

        .duel-match-icon {

            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: rgba(255, 255, 255, .05);

            font-size: 18px;
        }

        .duel-match-teams {

            font-size: 14px;
            font-weight: 700;

            color: #fff;
        }

        .duel-match-date {

            margin-top: 3px;

            font-size: 12px;

            color: rgba(255, 255, 255, .58);
        }

        /* ═══════════════════════════════════
           JACKPOT
        ═══════════════════════════════════ */

        .duel-jackpot {

            padding: 10px 16px;

            border-radius: 999px;

            background:
                linear-gradient(135deg,
                    rgba(0, 255, 140, .14),
                    rgba(0, 200, 120, .08));

            border: 1px solid rgba(0, 255, 140, .18);

            color: #7dffb2;

            font-size: 13px;
            font-weight: 700;
        }

        /* ═══════════════════════════════════
           PREDICTIONS
        ═══════════════════════════════════ */

        .duel-preds {

            margin-top: 24px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 20px;
        }

        .duel-pred-box {

            flex: 1;

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, .04),
                    rgba(255, 255, 255, .02));

            border-radius: 18px;

            padding: 18px;
        }

        .duel-pred-label {

            font-size: 11px;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: 1px;

            color: rgba(255, 255, 255, .5);
        }

        .duel-pred-content {

            margin-top: 12px;

            display: flex;
            align-items: center;

            gap: 12px;
        }

        .duel-pred-logo {

            width: 54px;
            height: 54px;

            border-radius: 50%;

            object-fit: cover;

            border: 2px solid rgba(255, 255, 255, .08);
        }

        .duel-pred-value {

            font-size: 15px;
            font-weight: 800;

            color: #fff;
        }

        .duel-pred-sep {

            font-size: 24px;
            color: rgba(255, 255, 255, .25);
        }

        /* ═══════════════════════════════════
           STATUS PILLS
        ═══════════════════════════════════ */

        .status-pill {

            padding: 10px 16px;

            border-radius: 999px;

            font-size: 12px;
            font-weight: 800;

            letter-spacing: .5px;
        }

        .status-pill.pending {
            background: rgba(255, 193, 7, .12);
            color: #ffd54a;
        }

        .status-pill.accepted {
            background: rgba(0, 255, 140, .12);
            color: #6dffab;
        }

        .status-pill.refused {
            background: rgba(255, 70, 70, .12);
            color: #ff7f7f;
        }

        .status-pill.winner {
            background: rgba(0, 255, 140, .14);
            color: #6dffab;
        }

        .status-pill.loser {
            background: rgba(255, 70, 70, .14);
            color: #ff7f7f;
        }

        .status-pill.draw {
            background: rgba(255, 255, 255, .08);
            color: #d7d7d7;
        }

        /* ═══════════════════════════════════
           BUTTONS
        ═══════════════════════════════════ */

        .btn-accept,
        .btn-refuse {

            border: none;

            padding: 12px 18px;

            border-radius: 14px;

            font-size: 13px;
            font-weight: 800;

            transition: all .18s ease;
        }

        .btn-accept {

            background:
                linear-gradient(135deg,
                    #00c853,
                    #00e676);

            color: #fff;
        }

        .btn-accept:hover {

            transform: translateY(-1px);

            box-shadow:
                0 10px 18px rgba(0, 230, 118, .25);
        }

        .btn-refuse {

            background:
                linear-gradient(135deg,
                    #ff5252,
                    #ff1744);

            color: #fff;
        }

        .btn-refuse:hover {

            transform: translateY(-1px);

            box-shadow:
                0 10px 18px rgba(255, 23, 68, .22);
        }

        /* ═══════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════ */

        @media (max-width: 768px) {

            .duel-inner,
            .duel-meta,
            .duel-preds {

                flex-direction: column;
                align-items: stretch;
            }

            .duel-player,
            .duel-player.right {

                width: 100%;
                justify-content: flex-start;
                text-align: left;
            }

            .duel-vs {

                width: 60px;
                height: 60px;

                margin: auto;
            }

            .duel-pred-sep {
                display: none;
            }
        }

        /* ═══════════════════════════════════
       DUELS DATATABLE CARDS
    ═══════════════════════════════════ */

        .duels-table-wrap {
            border-radius: 28px;
            overflow: hidden;
        }

        #duelsTable {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 18px !important;
            background: transparent !important;
        }

        #duelsTable thead {
            display: none;
        }

        #duelsTable tbody tr,
        #duelsTable tbody td {
            background: transparent !important;
            border: none !important;
        }

        #duelsTable tbody td {
            padding: 0 !important;
        }

        .dataTables_wrapper,
        .dataTables_scroll,
        .dataTables_scrollBody {
            background: transparent !important;
        }

        .dataTables_filter {
            margin-bottom: 20px;
        }

        .dataTables_filter label,
        .dataTables_length label,
        .dataTables_info {
            color: rgba(255, 255, 255, .65) !important;
        }

        .dataTables_filter input,
        .dataTables_length select {
            height: 44px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .05);
            color: #fff;
            padding: 0 14px;
            outline: none;
        }

        .dataTables_filter input:focus {
            border-color: #d7b85c;
            box-shadow: 0 0 0 4px rgba(215, 184, 92, .15);
        }

        .dataTables_paginate {
            margin-top: 20px !important;
        }

        .dataTables_paginate .paginate_button {
            border: none !important;
            background: rgba(255, 255, 255, .04) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 8px 14px !important;
            margin: 0 4px;
        }

        .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #d7b85c, #b69239) !important;
            color: #071426 !important;
        }

        table.dataTable.hover tbody tr:hover,
        table.dataTable.display tbody tr:hover {
            background: transparent !important;
        }

        .duel-card {

            padding: 20px;

            border-radius: 24px;

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, .06),
                    rgba(255, 255, 255, .03));

            border: 1px solid rgba(255, 255, 255, .08);

            margin-bottom: 18px;
        }

        .duel-top {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 18px;
        }

        .duel-player {

            display: flex;

            align-items: center;

            gap: 14px;
        }

        .duel-avatar {

            width: 58px;

            height: 58px;

            border-radius: 50%;

            object-fit: cover;

            border: 2px solid rgba(255, 255, 255, .12);
        }

        .duel-name {

            font-weight: 800;

            color: #fff;
        }

        .duel-xp {

            font-size: 12px;

            color: #facc15;

            margin-top: 4px;
        }

        .duel-vs {

            font-size: 22px;

            font-weight: 900;

            color: #ef4444;
        }

        .duel-middle {

            margin-top: 18px;

            display: flex;

            flex-wrap: wrap;

            gap: 14px;
        }

        .duel-match,
        .duel-bet,
        .duel-jackpot {

            padding: 10px 14px;

            border-radius: 14px;

            background: rgba(255, 255, 255, .05);

            font-size: 13px;
        }

        .duel-bottom {

            margin-top: 18px;
        }

        .duel-status {

            padding: 8px 14px;

            border-radius: 999px;

            font-size: 11px;

            font-weight: 900;

            letter-spacing: .4px;
        }

        .status-pending {
            background: rgba(249, 115, 22, .16);
            color: #fdba74;
        }

        .status-live {
            background: rgba(59, 130, 246, .16);
            color: #93c5fd;
        }

        .status-finished {
            background: rgba(34, 197, 94, .16);
            color: #86efac;
        }
    </style>

    <div class="cnx-stripe"></div>
    <div>
        <header class="cnx-header">
            <div class="cnx-header-inner">
                <a href="{{ url('/') }}" class="cnx-logo">
                    <div class="cnx-logo-badge">Game Changer</div>
                </a>

                <nav class="cnx-nav">
                    <a href="{{ route('home') }}" class="cnx-nav-link">Pronostics</a>
                    <a href="{{ route('classement') }}" class="cnx-nav-link">Classements</a>
                    <a href="{{ route('duels') }}" class="cnx-nav-link active">Duels</a>
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

        <main class="cnx-main">
            <div class="arena-wrap">

                {{-- Alerts --}}
                @if (session('success'))
                    <div class="arena-alert arena-alert-success">✓ {{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="arena-alert arena-alert-error">✗ {{ session('error') }}</div>
                @endif

                {{-- Heading --}}
                <div class="arena-heading">
                    <div class="arena-heading-title">⚔️ Arena <span>des Duels</span></div>
                </div>
                <div class="arena-heading-subtitle">Défiez vos collègues · Misez des XP · Récupérez le jackpot</div>

                {{-- ─────────── CREATE CARD ─────────── --}}
                <div class="create-card">
                    <div class="create-card-header">
                        <div class="create-card-icon">⚔️</div>
                        <div>
                            <div class="create-card-title">Lancer un duel</div>
                            <div class="create-card-desc">Choisissez un adversaire, un match et misez vos XP</div>
                        </div>
                    </div>

                    <form action="{{ route('duels.store') }}" method="POST" id="createDuelForm">
                        @csrf
                        <div class="create-grid">

                            <div class="create-field">
                                <label class="create-label">Adversaire</label>
                                <select name="opponent_id" id="opponentSelect" class="wc-select" required>
                                    <option value="">Rechercher un collègue...</option>
                                </select>
                            </div>

                            <div class="create-field">
                                <label class="create-label">Match</label>
                                <select name="match_id" id="duel_match_id" class="create-select" required>
                                    <option value="">Sélectionner un match…</option>
                                    @foreach ($matches as $match)
                                        @if (now()->lessThan($match->match_date))
                                            <option value="{{ $match->id }}" data-home="{{ $match->home_team }}"
                                                data-away="{{ $match->away_team }}">
                                                {{ $match->home_team }} vs {{ $match->away_team }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="create-field">
                                <label class="create-label">Mise XP</label>
                                <input type="number" name="xp_bet" min="5" max="{{ Auth::user()->xp ?? 0 }}"
                                    class="create-input" id="xp_bet_input" required>
                                <span class="create-help">
                                    Solde disponible : <strong style="color:var(--gold)">{{ Auth::user()->xp ?? 0 }}
                                        XP</strong>
                                </span>
                            </div>

                            <div class="create-field">
                                <label class="create-label">Mon pronostic</label>
                                <select name="prediction" id="duel_prediction" class="create-select" required>
                                    <option value="">Sélectionner d'abord un match</option>
                                </select>
                            </div>

                        </div>

                        <div class="create-footer">
                            <button type="button" class="btn-launch" id="launchDuelBtn">⚔️ Lancer le duel</button>
                            <div class="jackpot-preview">
                                Jackpot potentiel : <strong id="jackpot_display">20 XP</strong>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="duels-list-header">
                    <div class="duels-list-title">🏆 Mes duels</div>
                    <div class="duels-count">{{ count($duels) }} duel{{ count($duels) > 1 ? 's' : '' }}</div>
                </div>

                <div class="duels-table-wrap">

                    <table id="duelsTable" class="display" style="width:100%;">

                        <thead>
                            <tr>
                                <th>Duels</th>

                            </tr>
                        </thead>

                    </table>

                </div>

            </div>
        </main>

        <footer class="cnx-footer">
            <div class="cnx-footer-text">
                Concentrix · Game Changer · FIFA World Cup 2026™ · <span>Developed by Lallène ACHI</span>
            </div>
        </footer>
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const matchSelect = document.getElementById('duel_match_id');
            const predictionSelect = document.getElementById('duel_prediction');
            const xpInput = document.getElementById('xp_bet_input');
            const jackpotDisplay = document.getElementById('jackpot_display');

            function updatePredictionOptions() {
                if (!matchSelect || !predictionSelect) return;

                const selectedOption = matchSelect.options[matchSelect.selectedIndex];
                if (!selectedOption) return;

                const home = selectedOption.dataset.home;
                const away = selectedOption.dataset.away;

                predictionSelect.innerHTML = '';

                if (!home || !away) {
                    predictionSelect.innerHTML = `<option value="">Sélectionner d'abord un match</option>`;
                    return;
                }

                predictionSelect.innerHTML = `
            <option value="">Sélectionner…</option>
            <option value="${home}">${home}</option>
            <option value="Null">Match nul</option>
            <option value="${away}">${away}</option>
        `;
            }

            function updateJackpot() {
                if (!xpInput || !jackpotDisplay) return;

                let xp = parseInt(xpInput.value, 10) || 0;
                if (xp < 0) xp = 0;

                jackpotDisplay.innerHTML = `🔥 ${xp * 2} XP`;
            }

            if (matchSelect) {
                matchSelect.addEventListener('change', updatePredictionOptions);
            }

            if (xpInput) {
                xpInput.addEventListener('input', updateJackpot);
            }

            updatePredictionOptions();
            updateJackpot();

            if ($('#opponentSelect').length) {
                $('#opponentSelect').select2({
                    placeholder: 'Rechercher un collègue...',
                    minimumInputLength: 2,
                    width: '100%',
                    allowClear: true,
                    ajax: {
                        url: "{{ route('duels.searchUsers') }}",
                        dataType: 'json',
                        delay: 250,
                        cache: true,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        }
                    }
                });
            }

            if ($('#duelsTable').length) {
                $('#duelsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('duels.data') }}",
                    responsive: false,
                    pageLength: 10,
                    ordering: false,
                    searching: true,
                    columns: [{
                        data: 'card',
                        name: 'card',
                        orderable: false,
                        searchable: false
                    }],
                    language: {
                        processing: "Chargement...",
                        search: "Rechercher :",
                        lengthMenu: "Afficher _MENU_ duels",
                        info: "_START_ à _END_ sur _TOTAL_ duels",
                        infoEmpty: "Aucun duel",
                        zeroRecords: "Aucun duel trouvé",
                        paginate: {
                            previous: "‹",
                            next: "›"
                        }
                    }
                });
            }

        });

        $(document).on('click', '#launchDuelBtn', function() {

            const button = $(this);
            const form = $('#createDuelForm');
            const formData = new FormData(form[0]);

            button.prop('disabled', true).html('⏳ Création...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,

                success: function() {
                    button.html('✅ Duel lancé');

                    form[0].reset();

                    $('#opponentSelect').val(null).trigger('change');
                    $('#duel_prediction').html(
                        `<option value="">Sélectionner d'abord un match</option>`);
                    $('#jackpot_display').html('🔥 0 XP');

                    if ($('#duelsTable').length) {
                        $('#duelsTable').DataTable().ajax.reload(null, false);
                    }

                    setTimeout(function() {
                        button.prop('disabled', false).html('⚔️ Lancer le duel');
                    }, 1200);
                },

                error: function(xhr) {
                    let message = 'Erreur lors du lancement du duel.';

                    if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                    }

                    alert(message);

                    button.prop('disabled', false).html('⚔️ Lancer le duel');
                }
            });
        });
    </script>

@endsection
