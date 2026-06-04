<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login – SIP-PHBS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',sans-serif;min-height:100vh;display:flex}
.wrap{
  width:100%;min-height:100vh;
  background:linear-gradient(160deg,#0a1628 0%,#0d2137 40%,#0a3d2e 100%);
  display:flex;align-items:stretch;position:relative;overflow:hidden;
}
.bg-c1{position:absolute;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(0,51,153,0.3) 0%,transparent 70%);top:-150px;left:-150px;pointer-events:none}
.bg-c2{position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(10,80,60,0.25) 0%,transparent 70%);bottom:-100px;right:-100px;pointer-events:none}
.bg-c3{position:absolute;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(0,51,153,0.15) 0%,transparent 70%);bottom:5%;left:30%;pointer-events:none}
/* .bg-c4{position:absolute;width:600px;border-radius:50%;background-image: @assets('image/logo-phbs.jpg',,transparent 70%);bottom:5%;left:30%;pointer-events:none} */

/* ── KIRI ── */
.left{width:55%;display:flex;flex-direction:column;justify-content:center;padding:60px 64px;position:relative;z-index:1}
.badge-top{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);color:rgba(255,255,255,0.7);font-size:12px;font-weight:600;padding:6px 14px;border-radius:20px;margin-bottom:48px;width:fit-content}
.badge-top i{font-size:11px;color:#FFCC00}
.left h1{font-size:40px;font-weight:800;color:#fff;line-height:1.2;margin-bottom:16px}
.left h1 span{color:#FFCC00}
.left p.sub{font-size:14px;color:rgba(255,255,255,0.5);line-height:1.7;max-width:400px;margin-bottom:48px}
.float-btns{display:flex;flex-direction:column;gap:12px;margin-bottom:48px}
.float-btn{display:inline-flex;align-items:center;gap:10px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.75);font-size:13px;font-weight:500;padding:10px 20px;border-radius:10px;width:fit-content;text-decoration:none}
.float-btn i{color:#FFCC00;font-size:13px}
.info-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.6);font-size:12px;padding:8px 16px;border-radius:10px;width:fit-content;margin-bottom:32px}
.info-badge i{color:#FFCC00}
.stats{display:flex;gap:16px}
.stat-box{background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:14px 20px;text-align:center;min-width:90px}
.stat-box .num{font-size:22px;font-weight:800;color:#FFCC00}
.stat-box .lbl{font-size:11px;color:rgba(255,255,255,0.4);margin-top:2px}

/* ── KANAN ── */
.right{width:45%;display:flex;flex-direction:column;justify-content:center;padding:40px 48px;position:relative;z-index:1}
.right-card{background:#fff;border-radius:20px;padding:36px 32px;box-shadow:0 25px 60px rgba(0,0,0,0.4)}
.right-header{display:flex;align-items:center;gap:12px;margin-bottom:32px}
.logo-box{width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#002277,#003399);display:flex;align-items:center;justify-content:center}
.logo-box i{color:#fff;font-size:18px}
.logo-text h2{font-size:15px;font-weight:800;color:#003399;line-height:1.2}
.logo-text p{font-size:11px;color:#888}
.right-card h3{font-size:22px;font-weight:800;color:#0a1628;margin-bottom:4px}
.right-card .sub2{font-size:12px;color:#888;margin-bottom:24px}
.form-group{margin-bottom:16px}
.form-group label{display:block;font-size:11px;font-weight:700;color:#555;margin-bottom:6px;letter-spacing:.05em}
.input-wrap{position:relative}
.input-wrap i.icon-left{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:13px}
.input-wrap input{width:100%;padding:11px 14px 11px 38px;background:#fff;border:1.5px solid #e5e7eb;border-radius:10px;font-size:13px;color:#111;font-family:'Segoe UI',sans-serif;outline:none;transition:border .2s,box-shadow .2s}
.input-wrap input::placeholder{color:#c4c4c4}
.input-wrap input:focus{border-color:#003399;box-shadow:0 0 0 3px rgba(0,51,153,0.1)}
.input-wrap input.is-invalid{border-color:#dc2626;background:#fff8f8}
.toggle-pass{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9ca3af;font-size:13px;padding:0}
.err-msg{background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:10px 14px;font-size:12px;color:#dc2626;margin-bottom:16px;display:flex;align-items:center;gap:8px}
.invalid-feedback{font-size:11px;color:#dc2626;margin-top:4px;display:flex;align-items:center;gap:4px}
.row-mid{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
.check-label{display:flex;align-items:center;gap:7px;font-size:12px;color:#555;cursor:pointer}
.check-label input{accent-color:#003399}
.lupa{font-size:12px;color:#003399;font-weight:600;text-decoration:none}
.lupa:hover{text-decoration:underline}
.btn-login{width:100%;padding:13px;background:linear-gradient(135deg,#002277,#003399);color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:opacity .2s,transform .2s;font-family:'Segoe UI',sans-serif;margin-bottom:20px}
.btn-login:hover{opacity:.9;transform:translateY(-1px)}
.btn-login:disabled{opacity:.7;cursor:not-allowed}
.divider{text-align:center;font-size:11px;color:#aaa;margin-bottom:16px;position:relative}
.divider::before,.divider::after{content:'';position:absolute;top:50%;width:35%;height:1px;background:#e5e7eb}
.divider::before{left:0}.divider::after{right:0}
.role-row{display:flex;gap:8px}
.role-badge{flex:1;display:flex;flex-direction:column;align-items:center;gap:5px;padding:9px 6px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:10px;color:#555;font-weight:600;cursor:pointer;transition:border .2s,background .2s;background:#fff}
.role-badge i{font-size:16px;color:#003399}
.role-badge:hover{border-color:#003399;background:#eef2ff}
.foot{text-align:center;font-size:10px;color:#bbb;margin-top:16px}

@media(max-width:768px){
  .wrap{flex-direction:column}
  .left{width:100%;padding:40px 28px}
  .right{width:100%;padding:24px 20px}
  .left h1{font-size:28px}
  .float-btns{display:none}
}
</style>
</head>
<body>
<div class="wrap">
  <div class="bg-c4"></div>
  <div class="bg-c1"></div>
  <div class="bg-c2"></div>
  <div class="bg-c3"></div>
  

  {{-- KIRI --}}
  <div class="left">
    <div class="badge-top">
      <i class="fa-solid fa-shield-halved"></i> Sistem Informasi PHBS
    </div>
    <h1>Sistem <span>Pelaporan</span><br>PHBS Terpadu</h1>
    <p class="sub">Platform digital untuk memantau dan melaporkan Perilaku Hidup Bersih dan Sehat secara terintegrasi.</p>
    <div class="float-btns">
      <a class="float-btn"><i class="fa-solid fa-heart-pulse"></i> Monitoring PHBS</a>
      <a class="float-btn"><i class="fa-solid fa-chart-bar"></i> Rekap Laporan</a>
    </div>
    <div class="info-badge">
      <i class="fa-solid fa-hospital"></i> 25 Puskesmas
    </div>
    <div class="stats">
      <div class="stat-box"><div class="num">25</div><div class="lbl">Puskesmas</div></div>
      <div class="stat-box"><div class="num">13</div><div class="lbl">Indikator</div></div>
      <div class="stat-box"><div class="num">100%</div><div class="lbl">Digital</div></div>
    </div>
  </div>

  {{-- KANAN --}}
  <div class="right">
    <div class="right-card">
      <div class="right-header">
        <div class="logo-box"><i class="fa-solid fa-heart-pulse"></i></div>
        <div class="logo-text">
          <h2>SIP-PHBS</h2>
          <p>Sistem Informasi Pelaporan PHBS</p>
        </div>
      </div>
      <h3>Selamat Datang</h3>
      <p class="sub2">Masuk ke portal pelaporan PHBS</p>

      {{-- Error --}}
      @if($errors->any())
        <div class="err-msg">
          <i class="fa-solid fa-circle-exclamation"></i>
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        {{-- Email --}}
        <div class="form-group">
          <label>EMAIL</label>
          <div class="input-wrap">
            <i class="fa-solid fa-envelope icon-left"></i>
            <input type="email" name="email"
              placeholder="contoh@email.com"
              value="{{ old('email') }}"
              class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
              required autofocus>
          </div>
          @error('email')
            <div class="invalid-feedback">
              <i class="fa-solid fa-circle-xmark"></i> {{ $message }}
            </div>
          @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
          <label>PASSWORD</label>
          <div class="input-wrap">
            <i class="fa-solid fa-lock icon-left"></i>
            <input type="password" name="password"
              id="passwordInput"
              placeholder="Masukkan password"
              class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
              required>
            <button type="button" class="toggle-pass" onclick="togglePassword()">
              <i class="fa-regular fa-eye" id="eyeIcon"></i>
            </button>
          </div>
          @error('password')
            <div class="invalid-feedback">
              <i class="fa-solid fa-circle-xmark"></i> {{ $message }}
            </div>
          @enderror
        </div>

        {{-- Ingat & Lupa --}}
        <div class="row-mid">
          <label class="check-label">
            <input type="checkbox" name="remember"> Ingat saya
          </label>
          <a href="#" class="lupa">Lupa password?</a>
        </div>

        {{-- Tombol --}}
        <button type="submit" class="btn-login" id="submitBtn">
          <i class="fa-solid fa-right-to-bracket"></i> Masuk
        </button>
      </form>

      <div class="divider">layanan tersedia untuk</div>
      <div class="role-row">
        <div class="role-badge"><i class="fa-solid fa-hospital"></i>Puskesmas</div>
        <div class="role-badge"><i class="fa-solid fa-building-columns"></i>Dinkes</div>
        <div class="role-badge"><i class="fa-solid fa-user-shield"></i>Admin</div>
      </div>
      <div class="foot">SIP-PHBS &copy; {{ date('Y') }}</div>
    </div>
  </div>
</div>

<script>
function togglePassword(){
  const input = document.getElementById('passwordInput');
  const icon  = document.getElementById('eyeIcon');
  if(input.type === 'password'){
    input.type = 'text';
    icon.classList.replace('fa-eye','fa-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.replace('fa-eye-slash','fa-eye');
  }
}
document.getElementById('loginForm').addEventListener('submit', function(){
  const btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
});
</script>
</body>
</html>