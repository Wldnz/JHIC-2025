<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bina Tata Usaha</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body>
    @if ($errors->any())
        @php
            echo var_dump($errors);
        @endphp
    @endif
    <div class="login">
        <div class="container">
            <img src="{{ asset('icons/default-logo.png') }}" alt="logo-bitu">
            <div class="headline">
                <h4>Selamat Datang</h4>
                <p>Silahkan Login Terlebih Dahulu</p>
            </div>
            <form method="post">
                @csrf
                <div class="wrapper-input">
                    <label for="nis">Nomor Induk Siswa <span>*</span></label>
                    <input type="text" inputmode="numeric" name="nis" id="nis" minlength="8" maxlength="16" value="{{ old("nis") ??  ""}}" required>
                </div>
                <div class="wrapper-input">
                    <label for="password">Password <span>*</span></label>
                    <input type="password" name="password" id="password" minlength="8" required>
                </div>
                <button class="btn btn-submit">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>
