@extends('layouts.admin')

@section('content')


    <style>
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

        .wc-stripe {
            height: 4px;
            background: linear-gradient(90deg,
                    var(--wc-red) 0%, var(--wc-gold) 33%,
                    var(--wc-green) 66%, var(--wc-red) 100%);
        }

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

        .wc-main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 28px;
            position: relative;
            z-index: 10;
        }

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
            background: rgba(201, 168, 76, .04) !important;
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


        .team-select {
            width: 100%;
            background: linear-gradient(145deg,
                    rgba(19, 32, 64, .95),
                    rgba(10, 22, 40, .95));
            border: 1px solid rgba(201, 168, 76, .35);
            color: var(--wc-white);
            border-radius: 14px;
            padding: 12px 16px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 15px;
            font-weight: 600;
            outline: none;
            transition: all .25s ease;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .03),
                0 4px 12px rgba(0, 0, 0, .25);

            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;

            background-image:
                linear-gradient(45deg, transparent 50%, var(--wc-gold) 50%),
                linear-gradient(135deg, var(--wc-gold) 50%, transparent 50%);
            background-position:
                calc(100% - 18px) calc(50% - 3px),
                calc(100% - 12px) calc(50% - 3px);
            background-size: 6px 6px;
            background-repeat: no-repeat;
        }

        .team-select:hover {
            border-color: rgba(201, 168, 76, .7);
            box-shadow:
                0 0 0 4px rgba(201, 168, 76, .08),
                0 8px 24px rgba(0, 0, 0, .35);
        }

        .team-select:focus {
            border-color: var(--wc-gold);
            box-shadow:
                0 0 0 4px rgba(201, 168, 76, .15),
                0 10px 30px rgba(0, 0, 0, .45);
        }

        .team-select option {
            background: #132040;
            color: white;
            font-weight: 600;
        }



        .wc-team-preview {
            margin-top: 14px;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            border-radius: 14px;
            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, .04),
                    rgba(255, 255, 255, .02));

            border: 1px solid rgba(201, 168, 76, .18);

            transition: all .25s ease;
            min-height: 72px;
        }

        .wc-team-preview:hover {
            border-color: rgba(201, 168, 76, .45);
            transform: translateY(-2px);
        }

        .wc-team-preview img {
            width: 64px;
            height: 48px;
            object-fit: contain;
            border-radius: 8px;
            background: rgba(255, 255, 255, .05);
            padding: 6px;
            border: 1px solid rgba(255, 255, 255, .08);

            box-shadow:
                0 4px 12px rgba(0, 0, 0, .35);
        }

        .wc-team-preview-name {
            font-family: 'Oswald', sans-serif;
            font-size: 17px;
            font-weight: 600;
            color: var(--wc-white);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Glow gold */
        .wc-team-preview::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 14px;
            pointer-events: none;
        }

        /* Responsive */
        @media(max-width:768px) {

            .team-select {
                font-size: 14px;
                padding: 11px 14px;
            }

            .wc-team-preview {
                padding: 10px;
                gap: 10px;
            }

            .wc-team-preview img {
                width: 52px;
                height: 40px;
            }

            .wc-team-preview-name {
                font-size: 15px;
            }
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
                <span class="wc-nav-badge">⚙ Administration</span>
                <a href="{{ route('resultat.index') }}" class="wc-nav-link">Resultats</a>
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
            <div class="wc-hero-stats">
                <div class="wc-hero-stat">
                    <span class="wc-hero-stat-val">{{ count($matches) }}</span>
                    <span class="wc-hero-stat-lbl">Matchs créés</span>
                </div>
                <div class="wc-hero-stat">
                    <span class="wc-hero-stat-val">{{ count($teams) }}</span>
                    <span class="wc-hero-stat-lbl">Équipes</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ MAIN ══ --}}
    <main class="wc-main">

        {{-- ALERTS --}}
        @if ($errors->any())
            <div class="wc-alert wc-alert-danger">
                ✗ Erreur(s) de validation :
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="wc-alert wc-alert-success">✓ {{ session('success') }}</div>
        @endif

        <div class="wc-layout">

            {{-- ══════════════════════
             FORM PANEL — CRÉER
        ══════════════════════ --}}
            <div class="wc-form-panel">
                <div class="wc-panel-header">
                    <span style="font-size:18px;">⚽</span>
                    <span class="wc-panel-title">Créer un match</span>
                </div>
                <div class="wc-panel-body">
                    <form id="createMatchForm" action="{{ route('matches.create') }}" method="POST">
                        @csrf

                        {{-- Équipe domicile --}}
                        <div class="wc-form-row">
                            <label class="wc-label" for="home_team">Équipe domicile</label>
                            <select id="home_team" name="home_team" class="team-select" required>
                                <option value="">-- Rechercher une équipe --</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->name }}" data-avatar="{{ asset($team->avatar) }}"
                                        {{ old('home_team') == $team->name ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="wc-team-preview" id="home-preview-wrap">
                                <img id="home_preview" src="" alt="">
                                <span class="wc-team-preview-name" id="home_preview_name"></span>
                            </div>
                        </div>

                        <div class="wc-vs-divider">
                            <div class="wc-vs-line"></div>
                            <span class="wc-vs-label">VS</span>
                            <div class="wc-vs-line"></div>
                        </div>

                        {{-- Équipe extérieure --}}
                        <div class="wc-form-row">
                            <label class="wc-label" for="away_team">Équipe extérieure</label>
                            <select id="away_team" name="away_team" class="team-select" required>
                                <option value="">-- Rechercher une équipe --</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->name }}" data-avatar="{{ asset($team->avatar) }}"
                                        {{ old('away_team') == $team->name ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="wc-team-preview" id="away-preview-wrap">
                                <img id="away_preview" src="" alt="">
                                <span class="wc-team-preview-name" id="away_preview_name"></span>
                            </div>
                        </div>

                        {{-- Date --}}
                        <div class="wc-form-row">
                            <label class="wc-label" for="match_date">Date &amp; heure du match</label>

                            <input type="datetime-local" id="match_date" name="match_date" class="wc-input"
                                min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ old('match_date') }}" required>
                        </div>

                        <div class="wc-form-row">
                            <label class="wc-label">
                                Coefficient du match
                            </label>

                            <select name="coefficient" class="wc-select-native">
                                <option value="1">x1 • Normal</option>
                                <option value="2">x2 • Match équilibré</option>
                                <option value="3">x3 • Gros choc</option>
                                <option value="5">x5 • Finale / Match légendaire</option>
                            </select>
                        </div>

                        {{-- Phase --}}
                        <div class="wc-form-row">
                            <label class="wc-label" for="phase">Phase de compétition</label>
                            <select id="phase" name="phase" class="wc-select-native" required>
                                <option value="">-- Sélectionnez une phase --</option>
                                <option value="Phase de groupes"
                                    {{ old('phase') == 'Phase de groupes' ? 'selected' : '' }}>Phase de groupes</option>
                                <option value="huitiemes" {{ old('phase') == 'huitiemes' ? 'selected' : '' }}>
                                    Huitièmes de finale</option>
                                <option value="quarts" {{ old('phase') == 'quarts' ? 'selected' : '' }}>Quarts
                                    de finale</option>
                                <option value="demi_finales" {{ old('phase') == 'demi_finales' ? 'selected' : '' }}>
                                    Demi-finales</option>
                                <option value="troisieme_place" {{ old('phase') == 'troisieme_place' ? 'selected' : '' }}>
                                    Match pour la 3e place
                                </option>
                                <option value="finale" {{ old('phase') == 'finale' ? 'selected' : '' }}>Finale
                                </option>
                            </select>
                        </div>

                        {{-- Groupe / Journée (Phase de groupes uniquement) --}}
                        <div class="wc-form-row" id="groupe-row" style="display:none;">
                            <label class="wc-label" for="groupe">Groupe</label>
                            <select id="groupe" name="groupe" class="wc-select-native">
                                <option value="">--</option>
                                @foreach (range('A', 'L') as $g)
                                    <option value="Groupe {{ $g }}"
                                        {{ old('groupe') == 'Groupe ' . $g ? 'selected' : '' }}>Groupe {{ $g }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="wc-form-row" id="journee-row" style="display:none;">
                            <label class="wc-label" for="journee">Journée</label>
                            <select id="journee" name="journee" class="wc-select-native">
                                <option value="">--</option>
                                <option value="Journée 1" {{ old('journee') == 'Journée 1' ? 'selected' : '' }}>Journée 1
                                </option>
                                <option value="Journée 2" {{ old('journee') == 'Journée 2' ? 'selected' : '' }}>Journée 2
                                </option>
                                <option value="Journée 3" {{ old('journee') == 'Journée 3' ? 'selected' : '' }}>Journée 3
                                </option>
                            </select>
                        </div>

                        <button type="button" id="createMatchBtn" class="wc-btn-submit">

                            ⚽ Créer le match
                        </button>
                    </form>
                </div>
            </div>

            {{-- ══════════════════════
             TABLE PANEL — LISTE
        ══════════════════════ --}}
            <div class="wc-table-panel">
                <div class="wc-table-header">
                    <span class="wc-table-title">🗓 Liste des matchs</span>
                    <span class="wc-match-count">{{ count($matches) }} match(s) enregistré(s)</span>
                </div>
                <div class="wc-table-body">
                    <table class="wc-matches" id="cnxtable">
                        <thead>
                            <tr>
                                <th>Match</th>
                                <th>Date / Phase</th>
                                <th style="width:160px;">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>{{-- /.wc-layout --}}
    </main>

    <footer class="wc-footer">
        <div class="wc-footer-text">
            Concentrix · Game Changer · FIFA World Cup 2026™ ·
            <span>Developed by Lallène ACHI</span>
        </div>
    </footer>


    {{-- ══ SCRIPTS ══ --}}
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            const table = $('#cnxtable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('matches.admin.data') }}",
                responsive: true,
                pageLength: 10,
                searching: true,
                ordering: false,
                columns: [{
                        data: 'match',
                        name: 'match'
                    },
                    {
                        data: 'date_phase',
                        name: 'date_phase'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
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

            function updateTeamPreview(selectId, imgId, nameId) {
                const selected = $('#' + selectId).find(':selected');
                const avatar = selected.data('avatar');
                const name = selected.val();

                if (avatar && name) {
                    $('#' + imgId).attr('src', avatar).show();
                    $('#' + nameId).text(name);
                } else {
                    $('#' + imgId).attr('src', '').hide();
                    $('#' + nameId).text('');
                }
            }

            function validateTeams() {
                const home = $('#home_team').val();
                const away = $('#away_team').val();

                if (home && away && home === away) {
                    alert("Les deux équipes doivent être différentes.");
                    $('#away_team').val('').trigger('change');
                    updateTeamPreview('away_team', 'away_preview', 'away_preview_name');
                    return false;
                }

                return true;
            }

            $('#home_team').on('change', function() {
                updateTeamPreview('home_team', 'home_preview', 'home_preview_name');
                validateTeams();
            });

            $('#away_team').on('change', function() {
                updateTeamPreview('away_team', 'away_preview', 'away_preview_name');
                validateTeams();
            });

            updateTeamPreview('home_team', 'home_preview', 'home_preview_name');
            updateTeamPreview('away_team', 'away_preview', 'away_preview_name');

            $('#createMatchBtn').on('click', function() {
                if (!validateTeams()) return;

                const matchDate = $('#match_date').val();
                const now = new Date();
                const selectedDate = new Date(matchDate);

                if (!matchDate || selectedDate < now) {
                    alert("La date du match ne peut pas être antérieure à aujourd'hui.");
                    return;
                }

                const btn = $(this);
                const form = $('#createMatchForm');

                btn.prop('disabled', true).html('⏳ Création...');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),

                    success: function() {
                        btn.html('✅ Match créé');

                        form[0].reset();

                        $('#home_team').val('').trigger('change');
                        $('#away_team').val('').trigger('change');

                        $('#home_preview').attr('src', '').hide();
                        $('#away_preview').attr('src', '').hide();
                        $('#home_preview_name').text('');
                        $('#away_preview_name').text('');

                        table.ajax.reload(null, false);

                        setTimeout(function() {
                            btn.prop('disabled', false).html('⚽ Créer le match');
                        }, 1200);
                    },

                    error: function(xhr) {
                        let message = 'Erreur lors de la création du match.';

                        if (xhr.responseJSON?.message) {
                            message = xhr.responseJSON.message;
                        }

                        alert(message);

                        btn.prop('disabled', false).html('⚽ Créer le match');
                    }
                });
            });

        });
    </script>

@endsection
