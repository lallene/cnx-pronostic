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
            color: #fff;
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
            background: rgb(201 168 76 / 44%) !important;
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
                <a href="{{ route('resultat.index') }}" class="wc-nav-link">Resultats</a>
                <a href="{{ route('classementadmin') }}" class="wc-nav-link">Classements</a>
                <span class="wc-nav-badge">⚙ Utilisateurs</span>
                <form method="POST" action="{{ route('logoutadmin') }}" style="display:inline;">
                        @csrf
                    <button type="submit" class="wc-nav-link">
                        Déconnexion
                    </button>
                </form>
            </nav>
        </div>
    </header>

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

    <div class="container-fluid users-page mt-4">

        @if (session('success'))
            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <strong>{{ session('error') }}</strong>
            </div>
        @endif

        <div class="users-card mb-4">
            <div class="users-header">
                <h1>Importation utilisateurs</h1>
                <span>Excel Copy / Paste</span>
            </div>
            <div class="users-info">
                Copier directement depuis Excel puis coller ici.<br>
                Ordre attendu :
                <strong>Workday ID | Name | Email | Project / Service | Fonction | Manager</strong>
            </div>
            <form action="{{ route('users.importPaste') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <textarea name="excel_data" class="excel-textarea" rows="10"
                        placeholder="WD001	John Doe	john@test.com	IT	Technicien	Manager 1" required></textarea>
                </div>

                <button type="submit" class="btn-import">
                    Importer les utilisateurs
                </button>
            </form>
        </div>

        <div class="users-card">
            <div class="users-header">
                <h1>Liste des utilisateurs</h1>
                <span>Gestion des comptes</span>
            </div>

            <div class="table-responsive">
                <table class="table users-table align-middle" id="cnxtable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Workday ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Project / Service</th>
                            <th>Fonction</th>
                            <th>Manager</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>

    <style>
        .users-page {
            padding: 28px;
        }

        .users-card {
            background: linear-gradient(145deg, #111, #1a1a1a);
            border: 1px solid rgba(255, 193, 7, 0.35);
            border-radius: 22px;
            padding: 28px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.45);
        }

        .users-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
        }

        .users-header h1 {
            font-family: 'Oswald', Arial, sans-serif;
            text-transform: uppercase;
            color: var(--wc-gold);
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
        }

        .users-header span {
            background: rgba(255, 193, 7, 0.12);
            color: var(--wc-gold);
            border: 1px solid rgba(255, 193, 7, 0.45);
            padding: 8px 14px;
            border-radius: 30px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .users-info {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.35);
            color: #f5f5f5;
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 18px;
            font-size: 15px;
        }

        .users-info strong {
            color: var(--wc-gold);
        }

        .excel-textarea {
            width: 100%;
            min-height: 220px;
            background: #0f0f0f;
            border: 1px solid rgba(255, 193, 7, 0.45);
            border-radius: 16px;
            padding: 16px;
            outline: none;
            font-family: Consolas, monospace;
            resize: vertical;
            color: #fff;
        }

        .excel-textarea:focus {
            border-color: var(--wc-gold);
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.18);
        }

        .btn-import {
            background: linear-gradient(135deg, #ffc107, #ff8c00);
            color: #000;
            border: none;
            border-radius: 14px;
            padding: 13px 22px;
            font-weight: 900;
            text-transform: uppercase;
            cursor: pointer;
        }

        .btn-import:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(255, 193, 7, 0.35);
        }

        .users-table {
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .users-table thead th {
            background: var(--wc-gold);
            color: #000;
            border: none;
            padding: 15px;
            text-transform: uppercase;
            text-align: center;
            font-weight: 900;
        }

        .users-table tbody tr {
            background: #111;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.35);
        }

        .users-table tbody td {
            border: none;
            padding: 16px;
            vertical-align: middle;
            text-align: center;
            font-weight: 600;
        }

        .alert-success {
            background: rgba(25, 135, 84, 0.15);
            color: #75ffb2;
            border: 1px solid #198754;
            border-radius: 14px;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.15);
            color: #ff8a95;
            border: 1px solid #dc3545;
            border-radius: 14px;
        }

        .dataTables_wrapper .dataTables_filter label,
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_info {
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            background: #0f0f0f;
            color: #fff;
            border: 1px solid rgba(255, 193, 7, 0.45);
            border-radius: 10px;
            padding: 6px 10px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #ffc107 !important;
            border-radius: 8px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #ffc107 !important;
            color: #000 !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_processing {
            background: #111 !important;
            color: #ffc107 !important;
            border: 1px solid rgba(255, 193, 7, 0.45);
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .users-page {
                padding: 12px;
            }

            .users-card {
                padding: 18px;
            }

            .users-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .users-header h1 {
                font-size: 24px;
            }
        }
    </style>


    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-warning">

                <div class="modal-header border-warning">
                    <h5 class="modal-title text-warning fw-bold">
                        Modifier utilisateur
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>
                </div>

                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Workday ID</label>

                                <input type="text" name="id_wd" id="edit_id_wd"
                                    class="form-control bg-black text-white border-warning" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nom</label>

                                <input type="text" name="name" id="edit_name"
                                    class="form-control bg-black text-white border-warning" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>

                                <input type="email" name="email" id="edit_email"
                                    class="form-control bg-black text-white border-warning" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Projet / Service</label>

                                <input type="text" name="projet_service" id="edit_projet_service"
                                    class="form-control bg-black text-white border-warning">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fonction</label>

                                <input type="text" name="fonction" id="edit_fonction"
                                    class="form-control bg-black text-white border-warning">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Manager</label>

                                <input type="text" name="manager" id="edit_manager"
                                    class="form-control bg-black text-white border-warning">
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer border-warning">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Fermer
                        </button>

                        <button type="submit" class="btn btn-warning fw-bold">
                            Sauvegarder
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <footer class="wc-footer">
        <div class="wc-footer-text">
            Concentrix · Game Changer · FIFA World Cup 2026™ ·
            <span>Developed by Lallene ACHI</span>
        </div>
    </footer>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#cnxtable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: "{{ route('users.index') }}",

                columns: [{
                        data: "id"
                    },
                    {
                        data: "id_wd"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "projet_service"
                    },
                    {
                        data: "fonction"
                    },
                    {
                        data: "manager"
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex justify-content-center gap-2">

                                <button
                                    type="button"
                                    class="btn btn-sm btn-warning fw-bold editBtn"
                                    data-id="${row.id}"
                                    data-id_wd="${row.id_wd ?? ''}"
                                    data-name="${row.name ?? ''}"
                                    data-email="${row.email ?? ''}"
                                    data-projet_service="${row.projet_service ?? ''}"
                                    data-fonction="${row.fonction ?? ''}"
                                    data-manager="${row.manager ?? ''}"
                                >
                                    Modifier
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-info fw-bold resetPasswordBtn"
                                    data-id="${row.id}"
                                >
                                    Reset MDP
                                </button>

                                <form action="{{ url('/admin/users') }}/${row.id}"
                                    method="POST"
                                    onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">

                                    <button type="submit" class="btn btn-sm btn-danger fw-bold">
                                        Supprimer
                                    </button>
                                </form>

                            </div>
                        `;
                        }
                    }
                ],

                order: [
                    [0, 'asc']
                ],
                responsive: true,

                language: {
                    processing: "Chargement...",
                    search: "Recherche :",
                    lengthMenu: "Afficher _MENU_ lignes",
                    info: "Affichage de _START_ à _END_ sur _TOTAL_ utilisateurs",
                    zeroRecords: "Aucun utilisateur trouvé",
                    paginate: {
                        next: "Suivant",
                        previous: "Précédent"
                    }
                }
            });

            $(document).on('click', '.editBtn', function() {
                let button = $(this);
                let id = button.data('id');

                $('#edit_id_wd').val(button.data('id_wd'));
                $('#edit_name').val(button.data('name'));
                $('#edit_email').val(button.data('email'));
                $('#edit_projet_service').val(button.data('projet_service'));
                $('#edit_fonction').val(button.data('fonction'));
                $('#edit_manager').val(button.data('manager'));

                $('#editUserForm').attr('action', "{{ url('/admin/users') }}/" + id);

                $('#editUserModal').modal('show');
            });

            $(document).on('click', '.resetPasswordBtn', function () {

                let id = $(this).data('id');

                if (!confirm('Réinitialiser le mot de passe utilisateur ?')) {
                    return;
                }

                $.ajax({

                    url: "{{ url('/admin/users/reset-password') }}/" + id,

                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function () {

                        alert('Mot de passe réinitialisé.');

                        $('#cnxtable').DataTable().ajax.reload(null, false);
                    },

                    error: function () {

                        alert('Erreur lors de la réinitialisation.');
                    }
                });
             });
        });
    </script>
@endpush
