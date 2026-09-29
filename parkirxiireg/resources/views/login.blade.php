<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KABASA - Masuk</title>
</head>
<body>
    <div style="max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc;">
        <h2>Masuk ke akun parkirmu</h2>
        <p>Pantau slot, bayar tiket, dan kelola kendaraanmu di satu tempat.</p>

        <form action="{{ url('/login') }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" style="width: 100%; padding: 8px;">
                @error('email')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

                        <!-- KODE BARU UNTUK KATA SANDI (Ganti Baris 24-27 Anda dengan ini) -->
            <div style="margin-bottom: 20px; position: relative;">
                <label style="display: block; margin-bottom: 5px;">Kata sandi</label>
                <div style="display: flex; align-items: center; position: relative;">
                    <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi" style="width: 100%; padding: 8px; padding-right: 60px; box-sizing: border-box;">
                    <button type="button" id="togglePassword" style="position: absolute; right: 5px; background: none; border: none; color: #007bff; cursor: pointer; font-size: 14px;">Lihat</button>
                </div>
            </div>


            <button type="submit" style="width: 100%; padding: 10px; background-color: #2b3e50; color: white; border: none; cursor: pointer;">Masuk</button>
        </form>
    </div>
        <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        togglePasswordButton.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordButton.textContent = 'Sembunyikan';
            } else {
                passwordInput.type = 'password';
                togglePasswordButton.textContent = 'Lihat';
            }
        });
    </script>

</body>
</html>
