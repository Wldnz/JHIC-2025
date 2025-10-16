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

        <div class="star-group trinkets g1">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
        </div>
        <div class="star-group trinkets g2">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
        </div>

        <span class="circle trinkets"></span>


    <form class="login" method="POST" action="{{ route('candidate.signup') }}">
    @csrf

        <div class="title">
            <h4>Welcome,</h4>
            <p>Let’s Start Your Journey!</p>
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
                <div class="password">
                    <input type="password" name="password" id="password" placeholder="admin123" minlength="8" value="{{ old('password') }}" required>
                    <img src="{{ asset("icons/Show.svg") }}" class="show">
                    <img src="{{ asset("icons/Hide.svg") }}" class="hide">
                </div>
            </div>

            <div class="wrapper-input">
                <label for="password">Password Confirmation</label>
                <div class="password">
                    <input type="password" name="password_confirmation" id="password-confirmation" placeholder="admin123" minlength="8" value="{{ old('password') }}" required>
                    <img src="{{ asset("icons/Show.svg") }}" class="show">
                    <img src="{{ asset("icons/Hide.svg") }}" class="hide">
                </div>
            </div>
            
            <div class="buttons">
                <button type="submit" class="btn btn-submit w-full">
                    SIGN UP
                </button>
                <a href="#" target="_blank"><img src="{{ asset("icons/google.svg") }}"><p>Sign Up with Google</p></a>
            </div>
            <div class="footers">
                <div class="link">
                    <a href="{{ route("candidate.login-page") }}">Sudah Punya Akun? Sign In Disini</a>
                </div>
                <div class="link">
                    <a href="#">Ada Kendala & Butuh Bantuan</a>
                </div>
            </div>
        </div>
    </form>
</main>

@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])


<script>

let pwInputs = document.querySelectorAll("#password, #password-confirmation");
let showBtns = document.querySelectorAll(".show");
let hideBtns = document.querySelectorAll(".hide");

showBtns.forEach((btn, i) => {
  btn.addEventListener("click", () => {
    pwInputs[i].type = "text";
    btn.style.display = "none";
    hideBtns[i].style.display = "flex";
  });
});

hideBtns.forEach((btn, i) => {
  btn.addEventListener("click", () => {
    pwInputs[i].type = "password";
    btn.style.display = "none";
    showBtns[i].style.display = "flex";
  });
});

let pw = document.querySelector("#password");
let pwConfirm = document.querySelector("#password-confirmation");
let form = document.querySelector("form");

form.addEventListener("submit", (e) => {
  if (pw.value !== pwConfirm.value) {
    e.preventDefault();
    alert("Passwords do not match.");
  }
});


</script>


</body>
</html>