@extends('layouts.admin')

@section('content')
    <style>
        /* ══════════════════════════════════════════
                                VARIABLES & RESET
                                ══════════════════════════════════════════ */
        :root {
            --wc-gold: #C9A84C;
            --wc-gold-light: #F0CE7A;
            --wc-gold-dark: #8B6914;
            --wc-navy: #0A1628;
            --wc-navy-mid: #132040;
            --wc-navy-light: #1C2E55;
            --wc-red: #C8102E;
            --wc-green: #006847;
            --wc-white: #F5F0E8;
            --wc-silver: #B0B8C4;
            --r-sm: 4px;
            --r-md: 8px;
            --r-lg: 12px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background: var(--wc-navy);
            color: var(--wc-white);
            min-height: 100vh;
        }

        .team-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .team-logo {
            width: 64px;
            height: 64px;
            object-fit: contain;

            background: rgba(255, 255, 255, .05);

            border: 1px solid rgba(201, 168, 76, .25);

            border-radius: 14px;

            padding: 8px;
        }

        .team-name {
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 500;

            text-transform: uppercase;
            letter-spacing: 1px;

            color: var(--wc-white);

            text-align: center;
        }

        /* ══════════════════════════════════════════
                                TOP STRIPE
                                ══════════════════════════════════════════ */
        .wc-stripe {
            height: 4px;
            background: linear-gradient(90deg,
                    var(--wc-red) 0%, var(--wc-gold) 33%,
                    var(--wc-green) 66%, var(--wc-red) 100%);
        }

        /* ══════════════════════════════════════════
                                FIELD TEXTURE
                                ══════════════════════════════════════════ */
        .wc-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: 0.03;
            background-image:
                repeating-linear-gradient(0deg, transparent, transparent 59px, rgba(255, 255, 255, .9) 59px, rgba(255, 255, 255, .9) 60px),
                repeating-linear-gradient(90deg, transparent, transparent 59px, rgba(255, 255, 255, .9) 59px, rgba(255, 255, 255, .9) 60px);
        }

        /* ══════════════════════════════════════════
                                HEADER
                                ══════════════════════════════════════════ */
        .wc-header {
            position: relative;
            z-index: 100;
            background: var(--wc-navy-mid);
            border-bottom: 1px solid rgba(201, 168, 76, .3);
            padding: 0 28px;
        }

        .wc-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .wc-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .wc-logo-badge {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--wc-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Oswald', sans-serif;
            font-size: 10px;
            font-weight: 700;
            color: var(--wc-navy);
            text-align: center;
            line-height: 1.2;
            flex-shrink: 0;
        }

        .wc-logo img {
            height: 38px;
            width: auto;
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
            gap: 4px;
        }

        .wc-nav-link {
            padding: 8px 14px;
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 1px;
            color: var(--wc-silver);
            text-decoration: none;
            text-transform: uppercase;
            border-bottom: 2px solid transparent;
            transition: color .2s;
        }

        .wc-nav-link:hover,
        .wc-nav-link.active {
            color: var(--wc-gold);
            border-bottom-color: var(--wc-gold);
            border-radius: 0;
        }

        .wc-nav-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            background: rgba(201, 168, 76, .12);
            border: 1px solid rgba(201, 168, 76, .3);
            border-radius: var(--r-sm);
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            color: var(--wc-gold);
            text-transform: uppercase;
        }

        .wc-nav-logout {
            padding: 6px 14px;
            background: transparent;
            border: 1px solid var(--wc-red);
            color: var(--wc-red);
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-radius: var(--r-sm);
            cursor: pointer;
            text-decoration: none;
            transition: background .2s, color .2s;
        }

        .wc-nav-logout:hover {
            background: var(--wc-red);
        }

        /* ══════════════════════════════════════════
                                HERO BAND
                                ══════════════════════════════════════════ */
        .wc-hero {
            position: relative;
            z-index: 10;
            background: rgba(19, 32, 64, .97);
            border-bottom: 1px solid rgba(201, 168, 76, .2);
            padding: 20px 28px;
        }

        .wc-hero-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .wc-eyebrow {
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 3px;
            color: var(--wc-gold);
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .wc-page-title {
            font-family: 'Oswald', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--wc-white);
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.1;
        }

        .wc-page-title span {
            color: var(--wc-gold);
        }

        .wc-hero-flags {
            display: flex;
            gap: 6px;
            margin-top: 8px;
        }

        .wc-flag-chip {
            padding: 3px 10px;
            border-radius: 2px;
            font-family: 'Oswald', sans-serif;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .f-usa {
            background: rgba(200, 16, 46, .2);
            color: #FF6B7A;
            border: 1px solid rgba(200, 16, 46, .4);
        }

        .f-can {
            background: rgba(200, 16, 46, .12);
            color: #FF9999;
            border: 1px solid rgba(200, 16, 46, .3);
        }

        .f-mex {
            background: rgba(0, 104, 71, .2);
            color: #4DBA8C;
            border: 1px solid rgba(0, 104, 71, .4);
        }

        .wc-hero-stats {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .wc-hero-stat {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(201, 168, 76, .2);
            border-radius: var(--r-md);
            padding: 10px 16px;
            text-align: center;
            min-width: 80px;
        }

        .wc-hero-stat-val {
            font-family: 'Oswald', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--wc-gold);
            display: block;
            line-height: 1;
        }

        .wc-hero-stat-lbl {
            font-size: 10px;
            color: var(--wc-silver);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-top: 3px;
            display: block;
        }

        /* ══════════════════════════════════════════
                                MAIN
                                ══════════════════════════════════════════ */
        .wc-main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 28px;
            position: relative;
            z-index: 10;
        }

        /* ══════════════════════════════════════════
                                ALERTS
                                ══════════════════════════════════════════ */
        .wc-alert {
            margin-bottom: 20px;
            padding: 12px 20px;
            border-radius: var(--r-md);
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: .5px;
        }

        .wc-alert-success {
            background: rgba(0, 104, 71, .2);
            border: 1px solid rgba(0, 104, 71, .5);
            color: #4DBA8C;
        }

        .wc-alert-danger {
            background: rgba(200, 16, 46, .15);
            border: 1px solid rgba(200, 16, 46, .4);
            color: #FF6B7A;
        }

        .wc-alert ul {
            margin: 6px 0 0 16px;
        }

        .wc-alert ul li {
            font-size: 13px;
            margin-bottom: 2px;
        }

        /* ══════════════════════════════════════════
                                LAYOUT GRID
                                ══════════════════════════════════════════ */
        .wc-layout {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1100px) {
            .wc-layout {
                grid-template-columns: 1fr;
            }
        }

        /* ══════════════════════════════════════════
                                FORM PANEL
                                ══════════════════════════════════════════ */
        .wc-form-panel {
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(201, 168, 76, .25);
            border-top: 3px solid var(--wc-gold);
            border-radius: var(--r-lg);
            overflow: hidden;
            position: sticky;
            top: 24px;
        }

        .wc-panel-header {
            background: rgba(201, 168, 76, .08);
            border-bottom: 1px solid rgba(201, 168, 76, .2);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .wc-panel-title {
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 2px;
            color: var(--wc-gold);
            text-transform: uppercase;
        }

        .wc-panel-body {
            padding: 20px;
        }

        .wc-form-row {
            margin-bottom: 18px;
        }

        .wc-label {
            display: block;
            margin-bottom: 6px;
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 1.5px;
            color: var(--wc-silver);
            text-transform: uppercase;
        }

        .wc-input,
        .wc-select-native {
            width: 100%;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(201, 168, 76, .3);
            color: var(--wc-white);
            font-family: 'Rajdhani', sans-serif;
            font-size: 14px;
            padding: 9px 12px;
            border-radius: var(--r-sm);
            outline: none;
            transition: border-color .2s;
            -webkit-appearance: none;
        }

        .wc-input:focus,
        .wc-select-native:focus {
            border-color: var(--wc-gold);
        }

        .wc-select-native option {
            background: #132040;
        }

        /* Team preview */
        .wc-team-preview {
            margin-top: 8px;
            min-height: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .wc-team-preview img {
            width: 48px;
            height: 36px;
            object-fit: contain;
            border-radius: 2px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .06);
            display: none;
        }

        .wc-team-preview-name {
            font-family: 'Oswald', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: var(--wc-white);
            display: none;
        }

        /* vs divider */
        .wc-vs-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 4px 0 18px;
        }

        .wc-vs-line {
            flex: 1;
            height: 1px;
            background: rgba(201, 168, 76, .15);
        }

        .wc-vs-label {
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            color: var(--wc-gold);
            opacity: .6;
        }

        /* Submit button */
        .wc-btn-submit {
            width: 100%;
            padding: 12px;
            background: var(--wc-gold);
            color: var(--wc-navy);
            border: none;
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-radius: var(--r-sm);
            cursor: pointer;
            transition: background .2s;
        }

        .wc-btn-submit:hover {
            background: var(--wc-gold-light);
        }

        /* ══════════════════════════════════════════
                                TABLE PANEL
                                ══════════════════════════════════════════ */
        .wc-table-panel {
            background: rgba(255, 255, 255, .03);
            border: 1px solid rgba(201, 168, 76, .2);
            border-radius: var(--r-lg);
            overflow: hidden;
        }

        .wc-table-header {
            background: rgba(201, 168, 76, .08);
            border-bottom: 1px solid rgba(201, 168, 76, .2);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .wc-table-title {
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 2px;
            color: var(--wc-gold);
            text-transform: uppercase;
        }

        .wc-match-count {
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            font-weight: 500;
            color: var(--wc-silver);
            letter-spacing: 1px;
        }

        /* DataTables wrapper */
        .wc-table-body {
            padding: 16px 20px 20px;
        }

        /* ══════════════════════════════════════════
                                MATCHES TABLE
                                ══════════════════════════════════════════ */
        table.wc-matches {
            width: 100% !important;
            border-collapse: collapse;
        }

        table.wc-matches thead tr {
            background: rgba(0, 0, 0, .3);
            border-bottom: 2px solid rgba(201, 168, 76, .3);
        }

        table.wc-matches thead th {
            padding: 10px 14px;
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            color: var(--wc-gold);
            text-transform: uppercase;
            text-align: left;
            white-space: nowrap;
            border-bottom: none !important;
        }

        table.wc-matches tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, .05);
            transition: background .15s;
        }

        table.wc-matches tbody tr:hover {
            background: rgba(201, 168, 76, .05);
        }

        table.wc-matches tbody td {
            padding: 12px 14px;
            font-size: 13px;
            color: var(--wc-white);
            vertical-align: middle;
        }

        /* Match cell */
        .wc-match-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .wc-match-flag {
            width: 38px;
            height: 28px;
            object-fit: contain;
            border-radius: 2px;
            border: 1px solid rgba(255, 255, 255, .1);
            background: rgba(255, 255, 255, .05);
            flex-shrink: 0;
        }

        .wc-match-flag-placeholder {
            width: 38px;
            height: 28px;
            border-radius: 2px;
            border: 1px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .04);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .wc-match-team {
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: var(--wc-white);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .wc-match-vs {
            font-family: 'Oswald', sans-serif;
            font-size: 10px;
            font-weight: 700;
            color: var(--wc-gold);
            letter-spacing: 2px;
            opacity: .7;
            flex-shrink: 0;
        }

        /* Date/phase cell */
        .wc-date-cell {
            line-height: 1.6;
        }

        .wc-date-main {
            font-family: 'Oswald', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: var(--wc-white);
            letter-spacing: .5px;
        }

        .wc-phase-tag {
            display: inline-block;
            background: rgba(201, 168, 76, .1);
            color: var(--wc-gold);
            font-family: 'Oswald', sans-serif;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 2px 8px;
            border-radius: 2px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* Action buttons */
        .wc-actions {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .wc-btn-edit {
            padding: 6px 14px;
            background: rgba(201, 168, 76, .12);
            border: 1px solid rgba(201, 168, 76, .4);
            color: var(--wc-gold);
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-radius: var(--r-sm);
            cursor: pointer;
            transition: background .2s;
            white-space: nowrap;
        }

        .wc-btn-edit:hover {
            background: rgba(201, 168, 76, .25);
        }

        .wc-btn-delete {
            padding: 6px 14px;
            background: rgba(200, 16, 46, .1);
            border: 1px solid rgba(200, 16, 46, .4);
            color: #FF6B7A;
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-radius: var(--r-sm);
            cursor: pointer;
            transition: background .2s;
            white-space: nowrap;
        }

        .wc-btn-delete:hover {
            background: rgba(200, 16, 46, .25);
        }

        /* ══════════════════════════════════════════
                                MODAL
                                ══════════════════════════════════════════ */
        .wc-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 1050;
            background: rgba(5, 12, 25, .85);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
        }

        .wc-modal-backdrop.open {
            display: flex;
        }

        .wc-modal {
            background: var(--wc-navy-mid);
            border: 1px solid rgba(201, 168, 76, .3);
            border-top: 3px solid var(--wc-gold);
            border-radius: var(--r-lg);
            width: 100%;
            max-width: 520px;
            box-shadow: 0 24px 80px rgba(0, 0, 0, .6);
            position: relative;
            animation: modalIn .2s ease;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(-16px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .wc-modal-header {
            background: rgba(201, 168, 76, .08);
            border-bottom: 1px solid rgba(201, 168, 76, .2);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .wc-modal-title {
            font-family: 'Oswald', sans-serif;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 2px;
            color: var(--wc-gold);
            text-transform: uppercase;
        }

        .wc-modal-close {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: var(--wc-silver);
            line-height: 1;
            padding: 0 4px;
            transition: color .2s;
        }

        .wc-modal-close:hover {
            color: var(--wc-white);
        }

        .wc-modal-body {
            padding: 22px 20px;
        }

        .wc-modal-footer {
            padding: 14px 20px;
            border-top: 1px solid rgba(255, 255, 255, .07);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .wc-btn-cancel {
            padding: 8px 20px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .12);
            color: var(--wc-silver);
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-radius: var(--r-sm);
            cursor: pointer;
            transition: background .2s;
        }

        .wc-btn-cancel:hover {
            background: rgba(255, 255, 255, .1);
        }

        .wc-btn-update {
            padding: 8px 24px;
            background: var(--wc-gold);
            border: none;
            color: var(--wc-navy);
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border-radius: var(--r-sm);
            cursor: pointer;
            transition: background .2s;
        }

        .wc-btn-update:hover {
            background: var(--wc-gold-light);
        }

        /* ══════════════════════════════════════════
                                SELECT2 OVERRIDES
                                ══════════════════════════════════════════ */
        .select2-container .select2-selection--single {
            background: rgba(255, 255, 255, .06) !important;
            border: 1px solid rgba(201, 168, 76, .3) !important;
            border-radius: var(--r-sm) !important;
            height: 38px !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            color: var(--wc-white) !important;
            font-family: 'Rajdhani', sans-serif !important;
            font-size: 14px !important;
            line-height: 38px !important;
            padding-left: 10px !important;
        }

        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }

        .select2-container .select2-selection--single .select2-selection__arrow b {
            border-color: var(--wc-gold) transparent transparent transparent !important;
        }

        .select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent var(--wc-gold) transparent !important;
        }

        .select2-dropdown {
            background: var(--wc-navy-mid) !important;
            border: 1px solid rgba(201, 168, 76, .3) !important;
            border-radius: var(--r-sm) !important;
        }

        .select2-search--dropdown .select2-search__field {
            background: rgba(255, 255, 255, .06) !important;
            border: 1px solid rgba(201, 168, 76, .3) !important;
            color: var(--wc-white) !important;
            font-family: 'Rajdhani', sans-serif !important;
            border-radius: var(--r-sm) !important;
            padding: 6px 10px !important;
            outline: none !important;
        }

        .select2-results__option {
            color: var(--wc-white) !important;
            font-family: 'Rajdhani', sans-serif !important;
            font-size: 14px !important;
            padding: 8px 12px !important;
        }

        .select2-results__option--highlighted {
            background: rgba(201, 168, 76, .15) !important;
            color: var(--wc-gold) !important;
        }

        .select2-results__option[aria-selected="true"] {
            background: rgba(201, 168, 76, .1) !important;
            color: var(--wc-gold-light) !important;
        }

        .select2-container {
            width: 100% !important;
        }

        /* ══════════════════════════════════════════
                                DATATABLES OVERRIDES
                                ══════════════════════════════════════════ */
        .dataTables_wrapper {
            color: var(--wc-silver) !important;
            font-family: 'Rajdhani', sans-serif !important;
        }

        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 12px;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            background: rgba(255, 255, 255, .06) !important;
            border: 1px solid rgba(201, 168, 76, .3) !important;
            color: var(--wc-white) !important;
            border-radius: var(--r-sm) !important;
            padding: 5px 10px !important;
            font-family: 'Rajdhani', sans-serif !important;
            font-size: 13px !important;
            outline: none !important;
            margin-left: 6px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--wc-silver) !important;
            font-family: 'Oswald', sans-serif !important;
            font-size: 12px !important;
            letter-spacing: 1px !important;
            border-radius: var(--r-sm) !important;
            border: none !important;
            background: transparent !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(201, 168, 76, .15) !important;
            color: var(--wc-gold) !important;
            border: 1px solid rgba(201, 168, 76, .3) !important;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 12px !important;
            color: rgba(255, 255, 255, .25) !important;
        }

        table.dataTable.no-footer {
            border-bottom: 1px solid rgba(201, 168, 76, .15) !important;
        }

        table.dataTable thead th,
        table.dataTable thead td {
            border-bottom: none !important;
        }

        table.dataTable tbody tr {
            background: transparent !important;
        }

        table.dataTable tbody tr:hover td {
            background: rgb(201 168 76 / 25%) !important;
        }

        /* ══════════════════════════════════════════
                                FOOTER
                                ══════════════════════════════════════════ */
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

        .resultats-card {
            border-radius: 24px;
            background: linear-gradient(145deg, rgba(18, 22, 40, .96), rgba(8, 10, 22, .98));
            border: 1px solid rgba(255, 255, 255, .06);
            box-shadow: 0 12px 35px rgba(0, 0, 0, .35);
            padding: 20px;
        }

        .resultats-table {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 10px !important;
        }

        .resultats-table thead th {
            text-align: center !important;
            color: #fff;
            background: rgba(255, 255, 255, .06);
            border: none !important;
            padding: 16px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .resultats-table tbody td {
            background: rgba(255, 255, 255, .035);
            color: #fff;
            border: none !important;
            padding: 16px;
            vertical-align: middle;
            text-align: center;
        }

        .match-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .team-block {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .team-logo,
        .result-badge img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
        }

        .match-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: rgba(255, 255, 255, .7);
        }

        .match-center strong {
            color: #ffd54a;
        }

        .result-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 215, 74, .12);
            color: #ffd54a;
            font-weight: 700;
        }

        .no-result {
            color: rgba(255, 255, 255, .45);
            font-style: italic;
        }

        .resultat-form {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .result-select {
            border-radius: 12px;
            background: rgba(255, 255, 255, .06);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .1);
            padding: 10px 12px;
        }

        .result-select option {
            background: #071426;
            color: #fff;
        }

        .btn-validate {
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #00c853, #00e676);
            color: #fff;
            font-weight: 800;
            padding: 10px 16px;
        }

        .btn-finished {
            border: none;
            border-radius: 12px;
            background: rgba(255, 255, 255, .08);
            color: rgba(255, 255, 255, .5);
            padding: 10px 16px;
        }

        .dataTables_filter input,
        .dataTables_length select {
            border-radius: 12px;
            background: rgba(255, 255, 255, .06);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .1);
            padding: 8px 12px;
        }

        .dataTables_info,
        .dataTables_filter label,
        .dataTables_length label {
            color: rgba(255, 255, 255, .65) !important;
        }



        .btn-delete-result {
            border: none;
            border-radius: 12px;
            background: rgba(231, 76, 60, .14);
            border: 1px solid rgba(231, 76, 60, .35);
            color: #f87171;
            font-weight: 800;
            padding: 10px 16px;
        }
    </style>
    {{-- ══ TOP STRIPE ══ --}}
    <div class="wc-stripe"></div>
    <div class="wc-bg"></div>

    {{-- ══ HEADER ══ --}}
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
                <span class="wc-nav-badge">⚙ Resultats</span>
                <a href="{{ route('classementadmin') }}" class="wc-nav-link">Classements</a>
                 <a href="{{ route('users.index') }}" class="wc-nav-link">Utilisateurs</a>

                 <form method="POST"
      action="{{ route('logoutadmin') }}"
      style="display:inline;">

    @csrf

    <button type="submit" class="wc-nav-link">
        Déconnexion
    </button>

</form>
            </nav>
        </div>
    </header>

    {{-- ══ HERO ══ --}}
    <div class="wc-hero">
        <div class="wc-hero-inner">
            <div>
                <div class="wc-eyebrow">Administration · Coupe du Monde 2026</div>
                <div class="wc-page-title">Gestion des <span>Matchs</span></div>
                <div class="wc-hero-flags">
                    <span class="wc-flag-chip f-usa">🇺🇸 USA</span>
                    <span class="wc-flag-chip f-can">🇨🇦 Canada</span>
                    <span class="wc-flag-chip f-mex">🇲🇽 Mexique</span>
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid resultats-page">

        @if (session('success'))
            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif

        <div class="resultats-card">
            <div class="resultats-header">
                <h1>Gestion des résultats</h1>
            </div>

            <div class="table-responsive">
                <table id="cnxtable" class="table resultats-table">
                    <thead>
                        <tr>
                            <th>Match</th>
                            <th>Résultat</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>


    <footer class="wc-footer">
        <div class="wc-footer-text">
            Concentrix · Game Changer · FIFA World Cup 2026™ ·
            <span>Developed by Lallene ACHI</span>
        </div>
    </footer>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            const table = $('#cnxtable').DataTable({

                processing: true,

                serverSide: true,

                ajax: "{{ route('resultats.data') }}",

                responsive: true,

                pageLength: 10,

                ordering: false,

                searching: true,

                columns: [{
                        data: 'match',
                        name: 'match'
                    },
                    {
                        data: 'resultat',
                        name: 'resultat'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

                language: {
                    processing: "Chargement...",
                    search: "Rechercher :",
                    lengthMenu: "Afficher _MENU_ matchs",
                    info: "_START_ à _END_ sur _TOTAL_ matchs",
                    zeroRecords: "Aucun match trouvé",
                    paginate: {
                        previous: "‹",
                        next: "›"
                    }
                }

            });

            $(document).on('click', '.ajax-result-btn', function() {

                const btn = $(this);

                const form = btn.closest('form');

                btn.prop('disabled', true);

                btn.html('⏳');

                $.ajax({

                    url: form.attr('action'),

                    type: 'POST',

                    data: form.serialize(),

                    success: function() {

                        table.ajax.reload(null, false);

                    },

                    error: function() {

                        alert('Erreur lors de la validation.');

                        btn.prop('disabled', false);

                        btn.html('Valider');
                    }

                });

            });

        });
        $(document).on('click', '.ajax-delete-result-btn', function() {
            if (!confirm('Supprimer ce résultat ? Les scores seront recalculés.')) {
                return;
            }

            const btn = $(this);
            const form = btn.closest('form');

            btn.prop('disabled', true).text('Suppression...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),

                success: function() {
                    $('#cnxtable').DataTable().ajax.reload(null, false);
                },

                error: function(xhr) {
                    console.log(xhr.responseText);

                    alert(
                        xhr.responseJSON?.message ?
                        xhr.responseJSON.message :
                        'Erreur lors de la suppression du résultat.'
                    );

                    btn.prop('disabled', false).text('Supprimer résultat');
                }
            });
        });
    </script>
@endsection
