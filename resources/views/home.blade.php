<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{  config('app.name') }}</title>
    <link rel="icon" href="{{ Vite::asset('resources/images/jekey-hijab.jpg') }}" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @font-face {
            font-family: 'tabler-icons';
            src: url({{ Vite::asset('resources/fonts/tabler-icons.woff2') }});
        }

        body {
            font-family: 'tabler-icons', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .hero-section {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 2;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 20%;
            animation-delay: 5s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 30%;
            left: 30%;
            animation-delay: 10s;
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.8;
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
                opacity: 0.3;
            }

            100% {
                transform: translateY(0px) rotate(360deg);
                opacity: 0.8;
            }
        }

        .content-wrapper {
            position: relative;
            z-index: 3;
            text-align: center;
            max-width: 1200px;
            padding: 2rem;
        }

        .glass-card {
            width: 100%;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            animation: slideUp 1s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        .logo {
            font-size: 3.5rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3), 0 0 20px rgba(255, 255, 255, 0.3);
            }

            to {
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3), 0 0 30px rgba(255, 255, 255, 0.6);
            }
        }

        .subtitle {
            font-size: 1.1rem;
            color: #f8f9fa;
            margin-bottom: 2rem;
            font-weight: 300;
            opacity: 0.9;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(200px, 1fr));
            grid-template-rows: repeat(2, minmax(150px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #ffffff;
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 1.1rem;
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .feature-desc {
            font-size: 0.9rem;
            color: #f8f9fa;
            opacity: 0.8;
        }

        .login-btn {
            display: inline-block;
            text-decoration: none;
            background: linear-gradient(135deg, #ff6b6b, #ffa726);
            border: none;
            color: white;
            padding: 1rem 3rem;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(255, 107, 107, 0.3);
            position: relative;
            overflow: hidden;
            margin-top: 2rem;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(255, 107, 107, 0.5);
            background: linear-gradient(135deg, #ff5252, #ff9800);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #ffffff;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #f8f9fa;
            opacity: 0.8;
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {
            .logo {
                font-size: 2.5rem;
            }

            .subtitle {
                font-size: 1.1rem;
            }

            .glass-card {
                padding: 2rem;
                margin: 1rem;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }
        }

        .floating-icon {
            position: absolute;
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.6);
            animation: floatIcon 6s ease-in-out infinite;
        }

        .floating-icon:nth-child(1) {
            top: 15%;
            left: 15%;
            animation-delay: 0s;
        }

        .floating-icon:nth-child(2) {
            top: 25%;
            right: 20%;
            animation-delay: 2s;
        }

        .floating-icon:nth-child(3) {
            bottom: 20%;
            left: 10%;
            animation-delay: 4s;
        }

        @keyframes floatIcon {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }
    </style>
</head>

<body>


    <div class="hero-section">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="floating-icon">
            <i class="fas fa-users-cog"></i>
        </div>
        <div class="floating-icon">
            <i class="fas fa-balance-scale"></i>
        </div>
        <div class="floating-icon">
            <i class="fas fa-chart-pie"></i>
        </div>

        <div class="content-wrapper">
            <div class="glass-card">
                <div class="logo pulse">
                    <i class="fas fa-gem"></i> Jekey Hijab
                </div>

                <div class="subtitle">
                    Sistem Manajemen Keuangan Terpadu untuk Jekey Hijab
                </div>

                <div class="feature-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <div class="feature-title">Manajemen Penjualan</div>
                        <div class="feature-desc">Input data penjualan dengan sistem persetujuan berlapis</div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div class="feature-title">Laporan Keuangan</div>
                        <div class="feature-desc">Jurnal transaksi, buku besar, L/R, neraca saldo lengkap</div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="feature-title">Piutang & Utang</div>
                        <div class="feature-desc">Kelola piutang pelanggan dan utang pemasok dengan mudah</div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div class="feature-title">Approval System</div>
                        <div class="feature-desc">Sistem persetujuan pengeluaran grosir multi-level</div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="feature-title">Dashboard Eksekutif</div>
                        <div class="feature-desc">Ringkasan laporan untuk pemimpin dan monitoring real-time</div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="feature-title">Export PDF</div>
                        <div class="feature-desc">Cetak invoice dan laporan keuangan dalam format PDF</div>
                    </div>
                </div>

                <div class="stats-container">
                    <div class="stat-item">
                        <span class="stat-number">3</span>
                        <span class="stat-label">Level Akses</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">15+</span>
                        <span class="stat-label">Fitur Lengkap</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Akurasi Data</span>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="btn login-btn" onclick="handleLogin()">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Login ke Sistem
                </a>
            </div>
        </div>
    </div>

    <script src="{{ Vite::asset('resources/js/fontawesome.min.js') }}"></script>
    <script>
        function handleLogin() {
            // Animasi loading pada button
            const btn = document.querySelector('.login-btn');
            const originalText = btn.innerHTML;

            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat...';
            btn.disabled = true;

        }

        // Animasi counter untuk statistik
        function animateCounter(element, target, duration = 2000) {
            const start = 0;
            const startTime = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

                const current = Math.floor(progress * (target - start) + start);
                element.textContent = current;

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                }
            }

            requestAnimationFrame(updateCounter);
        }

        // Jalankan animasi counter saat halaman dimuat
        window.addEventListener('load', () => {
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach((stat, index) => {
                const text = stat.textContent;
                const number = parseInt(text.replace(/\D/g, ''));
                if (number) {
                    stat.textContent = '0';
                    setTimeout(() => {
                        animateCounter(stat, number, 2000);
                    }, index * 200);
                }
            });
        });


        // Efek parallax untuk floating shapes
        window.addEventListener('mousemove', (e) => {
            const shapes = document.querySelectorAll('.shape');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            shapes.forEach((shape, index) => {
                const speed = (index + 1) * 0.5;
                const xMove = (x - 0.5) * speed * 20;
                const yMove = (y - 0.5) * speed * 20;

                shape.style.transform = `translate(${xMove}px, ${yMove}px)`;
            });
        });
    </script>
</body>

</html>