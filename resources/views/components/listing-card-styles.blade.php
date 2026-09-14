@once
    <style>
        .listing-card {
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .listing-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.12) !important;
            border-color: rgba(52, 144, 220, 0.18);
        }

        .listing-card-image {
            position: relative;
            aspect-ratio: 16 / 10;
            background: linear-gradient(135deg, #eef3f9, #dae5f1);
            overflow: hidden;
        }

        .listing-card-image::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.05), rgba(15, 23, 42, 0.18));
            pointer-events: none;
        }

        .listing-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .listing-card:hover .listing-card-image img {
            transform: scale(1.04);
        }

        .listing-card-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.8rem;
            color: #b7c4d8;
            background: linear-gradient(135deg, #edf4fb, #dfeaf7);
        }

        .listing-card-status {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 1;
            border-radius: 999px;
            padding: 0.42rem 0.7rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.12);
        }

        .listing-card-priority {
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            z-index: 2;
        }

        .listing-card-altname {
            font-size: 0.78rem;
            font-style: italic;
            color: #3a8bfd;
            min-height: 1.4em;
            margin-bottom: 0.55rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .listing-card-altname i {
            font-style: normal;
            opacity: 0.8;
        }

        .listing-card-altname .morphext {
            display: inline-block;
        }

        .listing-card-altname .morphext .animated {
            display: inline-block;
        }

        .listing-card .card-body {
            display: flex;
            flex-direction: column;
            padding: 1.15rem 1.2rem 1.1rem;
            background: linear-gradient(180deg, #fff 0%, #fcfdff 100%);
        }

        .listing-card .card-title {
            font-size: 1.05rem;
            line-height: 1.45;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.7rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .listing-card-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .listing-card-divider {
            border-top: 1px solid #edf1f6;
            margin: 0.75rem 0;
        }

        .listing-card-stat-label {
            color: #8b95a7;
            font-size: 0.78rem;
            letter-spacing: 0.01em;
        }

        .listing-card-stat-value {
            font-weight: 700;
            color: #1f2937;
            font-size: 0.92rem;
        }

        .listing-card-avatar {
            width: 40px;
            height: 40px;
            min-width: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #7c3aed);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 8px 18px rgba(59, 130, 246, 0.2);
        }

        .listing-card-user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1f2937;
            line-height: 1.2;
        }

        .listing-card-user-branch {
            font-size: 0.75rem;
            color: #8a94a6;
        }

        .listing-card-footer {
            margin-top: auto;
            padding-top: 0.75rem;
        }

        .listing-card-whatsapp {
            width: 34px;
            height: 34px;
            min-width: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #dff7ea, #c9f1d8);
            color: #1faa5a;
            font-size: 1.1rem;
            line-height: 1;
            text-decoration: none;
            border: 1px solid rgba(31, 170, 90, 0.14);
            box-shadow: 0 4px 10px rgba(31, 170, 90, 0.12);
            transition: all 0.2s ease;
            padding: 0;
        }

        .listing-card-whatsapp i {
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            font-size: 1.1rem;
        }

        .listing-card-whatsapp:hover {
            background: linear-gradient(135deg, #1faa5a, #168c4a);
            color: #fff;
            transform: scale(1.04);
            box-shadow: 0 8px 16px rgba(31, 170, 90, 0.18);
            text-decoration: none;
        }

        .listing-card-whatsapp:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(31, 170, 90, 0.16);
        }

        .listing-card-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.45rem;
            margin-bottom: 0.5rem;
        }

        .listing-card-komoditi {
            font-weight: 700;
            font-size: 0.9rem;
            color: #1f2937;
        }

        .listing-badge-tipe {
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 0.03em;
            padding: 0.38em 0.7em;
            border-radius: 8px;
            text-transform: uppercase;
        }

        .listing-badge-tipe-ekspor {
            background: #fff2e7;
            color: #d97706;
        }

        .listing-badge-tipe-lokal {
            background: #eafaf2;
            color: #199a5a;
        }

        .listing-badge-tipe-ekspor-lokal {
            background: #edf1ff;
            color: #4657d7;
        }

        .listing-card-actions {
            display: flex;
            gap: 0.5rem;
        }

        .listing-card-actions .btn {
            flex: 1;
            border-radius: 10px;
            font-weight: 600;
        }

        .listing-card-actions .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.2);
        }

        .listing-card-actions .btn-warning {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border: none;
            color: #fff;
        }
    </style>
@endonce
