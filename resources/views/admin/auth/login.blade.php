<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sebagai dministrasi | SMK BINA INFORMATIKA</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-bi.png') }}" type="image/png">
    @vite(["resources/css/candidate.css", "resources/js/app.js"])
</head>

<body>

    <main class="wrapper-login">

        <div class="star-group trinkets g1">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
        </div>
        <div class="star-group trinkets g2">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
        </div>

        <span class="circle trinkets"></span>


        <form class="login" method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="title">
                <h4>Welcome Back,</h4>
                <p>Let’s Have Take A Look</p>
            </div>
            <div class="wrapper-field">
                <div class="wrapper-input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" minlength="8"
                        value="{{ old('email') }}" required>
                </div>
                <div class="wrapper-input">
                    <label for="password">Password</label>
                    <div class="password">
                        <input type="password" name="password" id="password" placeholder="Masukkan Password Anda" minlength="8"
                            required>
                        <img src="{{ asset("icons/Show.svg") }}" class="show">
                        <img src="{{ asset("icons/Hide.svg") }}" class="hide">
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit" class="btn btn-submit w-full">
                        LOGIN
                    </button>
                </div>
                <div class="footers">
                    <div class="link">
                        <a href="#">Ada Kendala & Butuh Bantuan</a>
                    </div>
                </div>
            </div>
        </form>
    </main>

    @includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])

    <script>

        let pwinput = document.querySelector("#password")
        let hidebtn = document.querySelector(".hide")
        let showbtn = document.querySelector(".show")

        showbtn.addEventListener("click", () => {
            pwinput.type = "text"
            showbtn.style.display = "none"
            hidebtn.style.display = "flex"
        })

        hidebtn.addEventListener("click", () => {
            pwinput.type = "password"
            showbtn.style.display = "flex"
            hidebtn.style.display = "none"
        })


    </script>

</body>

</html>
@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])