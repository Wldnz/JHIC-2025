<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login PSB</title>
</head>
<body>
    
@vite(["resources/css/candidate.css", "resources/js/app.js"])
<main class="wrapper-login">
        <form class="login"
            method="POST"
            action="{{ route('admin.login') }}"
        >
            @csrf
            <div class="title">
                <h4>Welcome Back,</h4>
                <p>Let’s Have A Look About Your Jounery!</p>
            </div>
            <div class="wrapper-field">
                <div class="wrapper-input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" 
                    minlength="8" value="{{ old('email') }}"
                    required
                >
                </div>
                 <div class="wrapper-input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="example@gmail.com" 
                    minlength="8" value="{{ old('password') }}"
                    required
                >
                </div>
                <div class="buttons">
                    <button type="submit" class="btn btn-submit w-full">
                        LOGIN
                    </button>
                </div>
                <div class="footers">
                    <div class="link">
                        <a href="#">Belum Punya Akun? Register Disini</a>
                    </div>
                    <div class="link">
                        <a href="#">Ada Kendala & Butuh Bantuan</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])


</body>
</html>