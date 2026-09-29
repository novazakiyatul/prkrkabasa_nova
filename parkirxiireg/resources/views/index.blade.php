<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<style>
  :root{
    --sky: #A9C4DE;
    --sky-light: #DCE9F2;
    --navy: #24405C;
    --navy-deep: #1B2F44;
    --yellow: #E8B93C;
    --ivory: #FBFAF6;
    --ink: #23303B;
    --muted: #8695A0;
  }

  *{ box-sizing: border-box; margin:0; padding:0; }

  body{
    min-height:100vh;
    background:
      radial-gradient(ellipse at 12% 8%, rgba(255,255,255,0.55), transparent 55%),
      radial-gradient(ellipse at 90% 92%, rgba(232,185,60,0.10), transparent 50%),
      linear-gradient(160deg, var(--sky-light) 0%, var(--sky) 60%, #8FB0CE 100%);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:32px;
    font-family:'Inter', sans-serif;
    position:relative;
    overflow:hidden;
  }

  /* garis marka jalan tipis di latar — jejak subjek parkir, sangat halus */
  .road-marks{
    position:absolute;
    inset:0;
    background-image: repeating-linear-gradient(
      100deg,
      transparent 0px,
      transparent 46px,
      rgba(255,255,255,0.35) 46px,
      rgba(255,255,255,0.35) 78px
    );
    opacity:0.5;
    pointer-events:none;
  }

  .ticket{
    position:relative;
    z-index:1;
    width:100%;
    max-width:400px;
    opacity:0;
    transform:translateY(14px);
    animation:rise 0.7s cubic-bezier(.2,.7,.2,1) forwards;
  }
  @keyframes rise{ to{ opacity:1; transform:translateY(0); } }

  .card{
    background:var(--ivory);
    border-radius:3px 3px 0 0;
    padding:40px 40px 32px;
    box-shadow: 0 40px 80px -24px rgba(27,47,68,0.4);
  }

  .brand{
    display:flex;
    align-items:center;
    gap:11px;
    margin-bottom:30px;
  }

  .p-badge{
    width:36px;
    height:36px;
    border-radius:50%;
    background:var(--navy);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'Fraunces', serif;
    font-weight:600;
    font-size:18px;
    flex-shrink:0;
    border:2px solid var(--yellow);
  }

  .brand-name{
    font-family:'Fraunces', serif;
    font-size:15px;
    letter-spacing:0.02em;
    color:var(--navy-deep);
  }

  h1{
    font-family:'Fraunces', serif;
    font-weight:500;
    font-size:29px;
    line-height:1.2;
    color:var(--ink);
    margin-bottom:8px;
  }

  .sub{
    color:var(--muted);
    font-size:14.5px;
    margin-bottom:30px;
    line-height:1.5;
  }

  .field{ margin-bottom:18px; }

  label{
    display:block;
    font-size:13px;
    color:var(--ink);
    margin-bottom:7px;
    font-weight:500;
  }

  .input-wrap{ position:relative; }

  input[type="email"],
  input[type="password"],
  input[type="text"]{
    width:100%;
    padding:13px 14px;
    border:1.5px solid #DCE3E9;
    background:#FEFEFD;
    border-radius:2px;
    font-family:'Inter', sans-serif;
    font-size:15px;
    color:var(--ink);
    outline:none;
    transition: border-color 0.15s ease;
  }

  input::placeholder{ color:#AFBAC4; }
  input:focus{ border-color:var(--navy); }

  .toggle-pass{
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);
    background:none;
    border:none;
    font-size:12.5px;
    color:var(--muted);
    cursor:pointer;
    font-family:'Inter', sans-serif;
  }
  .toggle-pass:hover{ color:var(--navy); }
  .toggle-pass:focus-visible{ outline:2px solid var(--navy); outline-offset:2px; border-radius:2px; }

  .row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:26px;
    font-size:13.5px;
  }

  .remember{
    display:flex;
    align-items:center;
    gap:7px;
    color:var(--ink);
  }
  .remember input{ accent-color: var(--navy); width:14px; height:14px; }

  .row a{
    color:var(--navy);
    text-decoration:none;
    border-bottom:1px solid transparent;
  }
  .row a:hover{ border-bottom-color: var(--navy); }

  button[type="submit"]{
    width:100%;
    padding:14px;
    background:var(--navy);
    color:#FFFFFF;
    border:none;
    border-radius:2px;
    font-family:'Inter', sans-serif;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition: background 0.18s ease, transform 0.05s ease;
    letter-spacing:0.01em;
  }
  button[type="submit"]:hover{ background: var(--navy-deep); }
  button[type="submit"]:active{ transform: scale(0.99); }
  button[type="submit"]:focus-visible{ outline:2px solid var(--yellow); outline-offset:3px; }

  .footer-text{
    text-align:center;
    font-size:14px;
    color:var(--muted);
    margin-top:22px;
  }
  .footer-text a{
    color:var(--navy);
    text-decoration:none;
    font-weight:500;
  }
  .footer-text a:hover{ text-decoration:underline; }

  .error{
    display:none;
    background:#FBF0DA;
    border:1px solid #EBCE8C;
    color:#8A6416;
    font-size:13px;
    padding:10px 12px;
    border-radius:2px;
    margin-bottom:18px;
  }
  .error.show{ display:block; }

  /* sobekan tiket & barcode — elemen khas: kartu login berbentuk tiket parkir */
  .perforation{
    height:20px;
    background:var(--ivory);
    position:relative;
    overflow:visible;
  }
  .perforation::before{
    content:'';
    position:absolute;
    top:-10px;
    left:0; right:0;
    height:20px;
    background:
      radial-gradient(circle 10px at 0 0, transparent 10px, var(--ivory) 10.5px) 0 0,
      repeating-linear-gradient(90deg, transparent 0 6px, var(--ivory) 6px 22px);
    -webkit-mask: repeating-radial-gradient(circle at 11px 0, transparent 0 9px, black 9.5px 22px);
    mask: repeating-radial-gradient(circle at 11px 0, transparent 0 9px, black 9.5px 22px);
    background:var(--sky);
  }

  .barcode-strip{
    background:var(--ivory);
    padding:14px 40px 22px;
    border-radius:0 0 3px 3px;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:8px;
  }

  .bars{
    display:flex;
    align-items:stretch;
    gap:2px;
    height:30px;
    width:100%;
  }
  .bars span{
    background:var(--navy);
    flex:0 0 auto;
  }

  .ticket-code{
    font-family:'Inter', sans-serif;
    font-size:11px;
    letter-spacing:0.15em;
    color:var(--muted);
  }

  @media (prefers-reduced-motion: reduce){
    .ticket{ animation:none; opacity:1; transform:none; }
  }
</style>
<body>
    
   <div class="road-marks"></div>

<div class="ticket">
  <div class="card">
    <div class="brand">
      <div class="p-badge">P</div>
      <div class="brand-name">KABASA</div>
    </div>

    <h1>Masuk ke akun parkirmu</h1>
    <p class="sub">Pantau slot, bayar tiket, dan kelola kendaraanmu di satu tempat.</p>

    <div class="error" id="errorBox">Email atau kata sandi belum diisi.</div>

    <form id="loginForm" novalidate>
      <div class="field">
        <label for="email">Email</label>
        <div class="input-wrap">
          <input type="email" id="email" name="email" placeholder="nama@email.com" autocomplete="email">
        </div>
      </div>

      <div class="field">
        <label for="password">Kata sandi</label>
        <div class="input-wrap">
          <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" autocomplete="current-password">
          <button type="button" class="toggle-pass" id="togglePass">Lihat</button>
        </div>
      </div>

      <div class="row">
        <label class="remember">
          <input type="checkbox" id="remember">
          Ingat saya
        </label>
        <a href="#">Lupa kata sandi?</a>
      </div>

      <button type="submit">Masuk</button>
    </form>

    <p class="footer-text">Belum punya akun? <a href="#">Daftar di sini</a></p>
  </div>

  <div class="perforation"></div>

  <div class="barcode-strip">
    <div class="bars" id="bars"></div>
    <div class="ticket-code">KBS · AKSES PARKIR TERKELOLA</div>
  </div>
</div>

<script>
  const toggleBtn = document.getElementById('togglePass');
  const passInput = document.getElementById('password');
  toggleBtn.addEventListener('click', () => {
    const isHidden = passInput.type === 'password';
    passInput.type = isHidden ? 'text' : 'password';
    toggleBtn.textContent = isHidden ? 'Sembunyikan' : 'Lihat';
  });

  const form = document.getElementById('loginForm');
  const errorBox = document.getElementById('errorBox');
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const email = document.getElementById('email').value.trim();
    const pass = passInput.value.trim();
    if(!email || !pass){
      errorBox.classList.add('show');
    } else {
      errorBox.classList.remove('show');
      alert('Form siap dihubungkan ke proses autentikasi kamu.');
    }
  });

  // bangkitkan pola barcode acak tapi konsisten (visual saja)
  const bars = document.getElementById('bars');
  const widths = [3,1,2,1,4,1,2,3,1,1,2,4,1,3,2,1,1,4,2,1,3,1,2,1,4,1,1,2,3,1];
  widths.forEach(w => {
    const el = document.createElement('span');
    el.style.width = (w*2) + 'px';
    bars.appendChild(el);
  });
</script>

</body>
</html>