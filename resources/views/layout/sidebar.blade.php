{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PHBS</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Montserrat', sans-serif; }
        body { display: flex; background-color: #f4f6f9; }
        
        /* CSS STRUKTUR SIDEBAR */
        .sidebar { width: 260px; height: 100vh; background-color: #1e293b; color: white; padding: 20px; position: fixed; }
        .sidebar .brand { font-size: 20px; font-weight: 700; margin-bottom: 30px; text-align: center; color: #38bdf8; }
        .sidebar menu { list-style: none; }
        .sidebar menu li { margin-bottom: 15px; }
        .sidebar menu a { color: #cbd5e1; text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 8px; transition: 0.2s; }
        .sidebar menu a:hover, .sidebar menu a.active { background-color: #334155; color: white; }
        
        /* KONTEN UTAMA (DI SEBELAH SIDEBAR) */
        .main-content { margin-left: 260px; flex: 1; padding: 30px; min-height: 100vh; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand"><i class="fa-solid fa-hospital"></i> PHBS SYSTEM</div>
        <menu>
            <li><a href="/beranda" class="{{ Request::is('beranda') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Beranda</a></li>
            <li><a href="/dashboard-phbs" class="{{ Request::is('dashboard-phbs') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie"></i> Dashboard PHBS</a></li>
            <li><a href="/laporan" class="{{ Request::is('laporan*') ? 'active' : '' }}"><i class="fa-solid fa-file-medical"></i> Laporan</a></li>
        </menu>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

</body>
</html> --}}