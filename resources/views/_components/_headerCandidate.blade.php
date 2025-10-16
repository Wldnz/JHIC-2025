<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title . ' | SMK BINA INFORMATIKA' ?? "SMK BINA INFORMATIKA" }}</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-bi.png') }}" type="image/png">
    @vite(["resources/css/candidate.css" ,"resources/js/app.js"])
</head>

<body>
    <main class="wrapper-candidate">

        <nav>
            <div class="img-wrapper logo">
                <img src="{{ asset("images/bi-full.png") }}" alt="">
            </div>
            <div class="img-wrapper burger-icon">
                <img class="open-btn" src="{{ asset("icons/burgur.svg") }}" alt="">
            </div>
        </nav>

        <div class="navbar-full">
            <div class="header">
                <div class="img-wrapper logo">
                    <img src="{{ asset("images/bi-full.png") }}" alt="">
                </div>
                <div class="img-wrapper close-icon">
                    <img class="close-btn" src="{{ asset("icons/Add_Plus.svg") }}" alt="">
                </div>
            </div>

            <div class="body">
                <a href="#" class="nav-menu">
                    <p><img src="{{ asset("icons/user.svg") }}">Dashboard</p>
                </a>
                <a href="#" class="nav-menu">
                    <p><img src="{{ asset("icons/email.svg") }}">Ujian Saringan Masuk</p>
                </a>
                <a href="#" class="nav-menu">
                    <p><img src="{{ asset("icons/telp.svg") }}">Contact</p>
                </a>
            </div>
        </div>

        <div class="navbar-filler"></div>



<script>
document.querySelector(".open-btn").addEventListener("click", () => { document.querySelector(".navbar-full").classList.add("active"); document.body.style.overflow = "hidden"})
document.querySelector(".close-btn").addEventListener("click", () => { document.querySelector(".navbar-full").classList.remove("active"); document.body.style.overflow = "auto"})
</script>

@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])
