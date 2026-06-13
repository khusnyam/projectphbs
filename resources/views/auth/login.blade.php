<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login – SIP-PHBS</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<div class="wrap">
    <div class="bg-c1"></div>
    <div class="bg-c2"></div>
    <div class="bg-c3"></div>
    <div class="bg-c4"></div>

    {{-- KIRI --}}
    <div class="left">

        <div class="badge-top">
            <i class="fa-solid fa-shield-halved"></i>
            Sistem Informasi PHBS
        </div>

        <h1>
            Sistem <span>Pelaporan</span><br>
            PHBS Terpadu
        </h1>

        <p class="sub">
            Platform digital untuk memantau dan melaporkan
            Perilaku Hidup Bersih dan Sehat secara terintegrasi.
        </p>

        <div class="float-btns">
            <a class="float-btn">
                <i class="fa-solid fa-heart-pulse"></i>
                Monitoring PHBS
            </a>

            <a class="float-btn">
                <i class="fa-solid fa-chart-bar"></i>
                Rekap Laporan
            </a>
        </div>

        <div class="info-badge">
            <i class="fa-solid fa-hospital"></i>
            Puskesmas Kabupaten Sleman
        </div>

        <div class="stats">
            <div class="stat-box">
                <div class="num">13</div>
                <div class="lbl">Indikator</div>
            </div>

            <div class="stat-box">
                <div class="num">100%</div>
                <div class="lbl">Digital</div>
            </div>
        </div>

    </div>

    {{-- KANAN --}}
    <div class="right">

        <div class="right-card">

            <div class="right-header">

                <div class="logo-box">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>

                <div class="logo-text">
                    <h2>SIP-PHBS</h2>
                    <p>Sistem Informasi Pelaporan PHBS</p>
                </div>

            </div>

            <h3>Selamat Datang</h3>
            <p class="sub2">
                Masuk ke portal pelaporan PHBS
            </p>

            @if($errors->any())
            <div class="err-msg">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST"
                  action="{{ route('login') }}"
                  id="loginForm">

                @csrf

                <div class="form-group">

                    <label>Email</label>

                    <div class="input-wrap">

                        <i class="fa-solid fa-envelope icon-left"></i>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="contoh@email.com"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                            required
                            autofocus>

                    </div>

                    @error('email')
                    <div class="invalid-msg">
                        <i class="fa-solid fa-circle-xmark"></i>
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <div class="input-wrap">

                        <i class="fa-solid fa-lock icon-left"></i>

                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            placeholder="Masukkan password"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                            required>

                        <button
                            type="button"
                            class="toggle-pass"
                            onclick="togglePassword()">

                            <i class="fa-regular fa-eye" id="eyeIcon"></i>

                        </button>

                    </div>

                    @error('password')
                    <div class="invalid-msg">
                        <i class="fa-solid fa-circle-xmark"></i>
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div class="row-mid">

                    <label class="check-label">
                        <input type="checkbox" name="remember">
                        Ingat saya
                    </label>

                    <a href="#" class="lupa">
                        Lupa password?
                    </a>

                </div>

                <button type="submit"
                        class="btn-login"
                        id="submitBtn">

                    <i class="fa-solid fa-right-to-bracket"></i>
                    Masuk

                </button>

            </form>

            <div class="divider">
                layanan tersedia untuk
            </div>

            <div class="role-row">

                <div class="role-badge">
                    <i class="fa-solid fa-hospital"></i>
                    Puskesmas
                </div>

                <div class="role-badge">
                    <i class="fa-solid fa-building-columns"></i>
                    Dinkes
                </div>

            </div>

            <div class="foot">
                SIP-PHBS &copy; {{ date('Y') }}
            </div>

        </div>

    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('eyeIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

document.getElementById('loginForm')
.addEventListener('submit', function () {

    const btn = document.getElementById('submitBtn');

    btn.disabled = true;
    btn.innerHTML =
        '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
});
</script>

</body>
</html>