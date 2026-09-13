@once
    <style>
        .listing-card {
            border: none;
            border-radius: 14px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .listing-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.14) !important;
        }

        .listing-card-image {
            position: relative;
            aspect-ratio: 16 / 10;
            background-color: #eef2f7;
            overflow: hidden;
        }

        .listing-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .listing-card-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.6rem;
            color: #b9c2d0;
            background: linear-gradient(135deg, #eef2f7, #dbe2ec);
        }

        .listing-card-status {
            position: absolute;
            top: 10px;
            right: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.18);
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
            font-size: 0.8rem;
            font-style: italic;
            color: #3490dc;
            min-height: 1.3em;
            margin-bottom: 0.5rem;
        }

        .listing-card-altname i {
            font-style: normal;
            margin-right: 3px;
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
            padding: 1.1rem 1.25rem;
        }

        .listing-card-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .listing-card-divider {
            border-top: 1px solid #eef1f5;
            margin: 0.7rem 0;
        }

        .listing-card-stat-label {
            color: #8a94a6;
            font-size: 0.78rem;
        }

        .listing-card-stat-value {
            font-weight: 700;
            color: #1f2937;
        }

        .listing-card-avatar {
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3490dc, #6574cd);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
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
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e9f9ef;
            color: #1cbb5c;
            font-size: 1.05rem;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .listing-card-whatsapp:hover {
            background: #1cbb5c;
            color: #fff;
            transform: scale(1.06);
        }

        .listing-card-actions {
            display: flex;
            gap: 0.5rem;
        }

        .listing-card-actions .btn {
            flex: 1;
        }
    </style>
@endonce
