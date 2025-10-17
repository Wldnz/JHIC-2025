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

        <div class="navbar-full active">
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
                <a class="nav-menu expandable">
                    <p><img src="{{ asset("icons/usm.svg") }}">Ujian Saringan Masuk</p>
                    <img src="{{ asset("icons/arrow-down.svg") }}" alt="">

                </a>
                <div class="branch">
                    <a href="{{ route("candidate.schedule") }}"><img src="{{ asset("icons/Calendar.svg") }}" alt=""><p>Jadwal USM</p></a>
                    <a href="{{ route("candidate.learning-materials") }}"><img src="{{ asset("icons/book.svg") }}" alt=""><p>Modul Pembelajaran USM</p></a>
                </div>
            </div>

            <div class="footer">
                <a href="mailto:info@smkbinainformatika.sch.id" class="nav-menu">
                    <p><img src="{{ asset("icons/email.svg") }}">info@smkbinainformatika.sch.id</p>
                </a>
                <a href="https://wa.me/6281280063529" class="nav-menu">
                    <p><img src="{{ asset("icons/wa.svg") }}">(+62) 8128-0063-529</p>
                </a>
                <form action="{{ route('candidate.logout')  }}" method="POST" class="nav-menu logout">
                    <button type="submit">
                        <p><img src="{{ asset("icons/Log_Out.svg") }}">Logout</p>
                    </button>
                    @csrf

                </form>

            </div>
        </div>

        <div class="navbar-filler"></div>



<script>
document.querySelector(".open-btn").addEventListener("click", () => { document.querySelector(".navbar-full").classList.add("active"); document.body.style.overflow = "hidden"})
document.querySelector(".close-btn").addEventListener("click", () => { document.querySelector(".navbar-full").classList.remove("active"); document.body.style.overflow = "auto"})
</script>

@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])
