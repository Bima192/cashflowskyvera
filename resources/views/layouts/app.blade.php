<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashFlow - Kas Usaha</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #eef2ff;
            --primary-hover: #4338ca;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-active-bg: #1e293b;
            --sidebar-active-text: #f8fafc;
        }

        * { box-sizing: border-box; }

        body {
            background-color: #f1f5f9;
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; bottom: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid #1e293b;
        }

        .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.1rem;
        }

        .brand-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: #f8fafc;
            letter-spacing: -0.3px;
        }

        .brand-sub {
            font-size: 0.7rem;
            color: var(--sidebar-text);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 16px 12px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .nav-section-title {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #475569;
            padding: 8px 8px 4px;
            font-weight: 600;
        }

        .nav-link-custom {
            color: var(--sidebar-text);
            padding: 10px 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .nav-link-custom i { font-size: 1rem; width: 18px; text-align: center; }

        .nav-link-custom:hover {
            background-color: var(--sidebar-active-bg);
            color: #f8fafc;
        }

        .nav-link-custom.active {
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            color: #fff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
        }

        /* ── Main ── */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Header ── */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 6px 14px;
            gap: 8px;
            max-width: 320px;
            width: 100%;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.875rem;
            color: #64748b;
            width: 100%;
        }

        .avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 0.9rem;
        }

        /* ── Cards ── */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 22px 24px;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.07); }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
        }

        .card-modern {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }

        /* ── Buttons ── */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            border: none;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-primary-custom:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4);
            color: white;
        }

        /* ── Table ── */
        .table > :not(caption) > * > * { padding: 14px 16px; }
        .table thead th { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; color: #94a3b8; background: #f8fafc; }

        /* ── Badge ── */
        .badge-masuk { background: #ecfdf5; color: #059669; border: 1px solid #6ee7b7; }
        .badge-keluar { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; }

        /* ── Form ── */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.875rem;
            padding: 10px 14px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .modal-content { border-radius: 20px; border: none; }
        .modal-header { border-bottom: 1px solid #f1f5f9; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand d-flex align-items-center gap-3" style="padding: 24px 20px 20px; border-bottom: 1px solid #1e293b;">
            <div class="brand-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);">
                <i class="bi bi-wallet2"></i>
            </div>
            <div>
                <div class="brand-name" style="font-size: 1.25rem; font-weight: 800; letter-spacing: -0.5px; color: #ffffff; line-height: 1.2;">SkyVera</div>
                <div class="brand-sub" style="font-size: 0.75rem; color: #93c5fd; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Cashflow</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Menu Utama</div>
            <a href="{{ route('kas.index') }}" class="nav-link-custom {{ request()->routeIs('kas.index') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="{{ route('kas.transaksi') }}" class="nav-link-custom {{ request()->routeIs('kas.transaksi') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i> Transaksi
            </a>

            <div class="nav-section-title mt-3">Pengaturan</div>
            <a href="{{ route('kas.kategori') }}" class="nav-link-custom {{ request()->routeIs('kas.kategori') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Kategori
            </a>
            <a href="{{ route('kas.rekening') }}" class="nav-link-custom {{ request()->routeIs('kas.rekening') ? 'active' : '' }}">
                <i class="bi bi-bank2"></i> Rekening
            </a>

            <div class="nav-section-title mt-3">Laporan</div>
            <a href="{{ route('kas.laporan') }}" class="nav-link-custom {{ request()->routeIs('kas.laporan') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Export Laporan
            </a>
        </nav>

        <div style="padding: 16px 20px; border-top: 1px solid #1e293b;">
            <div style="font-size: 0.7rem; color: #475569; text-align: center;">
                CashFlow &copy; {{ date('Y') }}
            </div>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="search-box">
                <i class="bi bi-search text-muted" style="font-size: 0.85rem;"></i>
                <input type="text" placeholder="Cari transaksi, kategori...">
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <div class="d-flex align-items-center gap-2" style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
                        <div class="d-none d-md-block">
                            <div style="font-size: 0.85rem; font-weight: 600; color: #0f172a; line-height: 1.2;">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div style="font-size: 0.72rem; color: #94a3b8;">Administrator <i class="bi bi-chevron-down ms-1" style="font-size: 0.6rem;"></i></div>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 12px; margin-top: 10px;">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2 fw-semibold" style="font-size: 0.85rem;">
                                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main style="padding: 28px; flex: 1;">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>