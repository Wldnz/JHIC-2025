@vite(["resources/css/app.css", "resources/js/app.js"])
<main class="wrapper-user">
    <div class="dashboard no-fade">
        <div class="banner">
            <div class="trinkets star-group star-group-1 no-fade">
                <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
                <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
            </div>
            <span class="trinkets circle circle-auth no-fade"></span>
        </div>
        <form class="login self-center"
            method="POST"
            action="{{ route('admin.login') }}"
        >
            @csrf
            <div class="title">
                <h4>Welcome Back, Let’s Have A Look About Your Jounery!</h4>
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
                        LOGIN NOW! 
                    </button>
                </div>
                <div class="footers">
                    <div class="link">
                        <p>Belum Punya Akun?</p>
                        <a href="#">Register Disini</a>
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
