<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title  ?? "SMK BINA INFORMATIKA" }}</title>
    <meta content="{{ $title  ?? "SMK BINA INFORMATIKA"  }}" name="{{ $description ?? 'Smk Bina Informatika Bintaro, adalah sebuah sekolah kejuruaan yang memiliki 6 jurusan' }}">
    <meta content="{{ $title  ?? "SMK BINA INFORMATIKA"  }}" name="{{ $keywords ?? 'SMK BINA INFORMATIKA BINTARO, SEKOLAH SMK BINTARO, SMK JURUSAN, (RPL, TKJ, ANIMASI, DKV, BC, GAMEDEV), Pendaftaran Online SMK' }}">
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <link rel="shortcut icon" href="{{ asset('images/logo-bi.png') }}" type="image/png">
</head>
<body>
    <nav class="navigation-user">
        <div class="left"><a href="{{ route('user.index') }}"><img src="https://smkbinainformatika.sch.id/wp-content/uploads/2022/11/logo.png"></a></div>
        <div class="center">
            <div class="links">
                <div class="expandable-wrapper">
                    <a href="{{ route('user.index') }}">HOME</a>
                </div>
                <div class="expandable-wrapper">
                    <a class="expandable-pc">ABOUT</a>
                    <div class="branch">
                        <a href="{{ route("user.profile") }}">Profile</a>
                        <a href="{{ route("user.visi-misi") }}">Vision and Mission</a>
                        <a href="{{ route("user.facilities") }}">Facility</a>
                        <a href="{{ route("user.galleries") }}">Gallery</a>
                    </div>
                </div>
                <div class="expandable-wrapper">
                <a class="expandable-pc">MAJOR</a>
                    <div class="branch">
                        <a href="{{ route("user.majors.animation") }}">Animation</a>
                        <a href="{{ route("user.majors.broadcasting") }}">Broadcasting Film & TV</a>
                        <a href="{{ route("user.majors.game-development") }}">Game Development</a>
                        <a href="{{ route("user.majors.visual-communication-design") }}">Visual Communication Design</a>
                        <a href="{{ route("user.majors.network-engineering") }}">IT Network</a>
                        <a href="{{ route("user.majors.software-engineering") }}">Software Engineer</a>
                    </div>
                </div>
                <div class="expandable-wrapper">
                <a class="expandable-pc">PROGRAM</a>
                    <div class="branch">
                        <a href="{{ route("user.programs.extracurriculars") }}">Extracurricular </a>
                        <a href="{{ route("user.programs.program-silang") }}">Progsil</a>
                        <a href="{{ route("user.programs.baca-tulis-quran") }}">BTQ</a>
                        <a href="{{ route("candidate.index") }}">PSB</a>
                    </div>
                </div>
                <div class="expandable-wrapper">
                    <a href="{{ route('user.news') }}">NEWS</a>
                </div>
            </div>
        </div>

        <div class="right">
            <img src="{{asset('icons/burgur.svg')}}" class="burger">
            <a href="https://wa.me/6281280063529" target="_blank" rel="noopener noreferrer"><button class="button button-circle"><img src="{{asset('icons/telp.svg')}}"></button></a>
            <a href="mailto:info@smkbinainformatika.sch.id"><button class="button button-circle"><img src="{{asset('icons/email.svg')}}"></button></a>
        </div>

    </nav>
    <div class="mobile-nav no-fade">
        <div class="up">
            <img class="exit-burger" src="{{ asset("icons/Add_Plus.svg") }}" alt="">
            <a href="{{ route('user.index') }}">HOME <img src="{{ asset("icons/majors icons/non.png") }}" alt=""></a>
            <a class="expandable">PROFILE <img src="{{ asset("icons/arrow-down.svg") }}" alt=""></a>
            <div class="branch">
                <a href="{{ route("user.profile") }}">Profile</a>
                <a href="{{ route("user.visi-misi") }}">Vision and Mission</a>
                <a href="{{ route("user.facilities") }}">Facility</a>
                <a href="{{ route("user.galleries") }}">Gallery</a>
            </div>
            <a class="expandable">MAJOR <img src="{{ asset("icons/arrow-down.svg") }}" alt=""></a>
            <div class="branch">
                <a href="{{ route("user.majors.animation") }}">Animation</a>
                <a href="{{ route("user.majors.broadcasting") }}">Broadcasting Film & TV</a>
                <a href="{{ route("user.majors.game-development") }}">Game Development</a>
                <a href="{{ route("user.majors.visual-communication-design") }}">Visual Communication Design</a>
                <a href="{{ route("user.majors.network-engineering") }}">IT Network</a>
                <a href="{{ route("user.majors.software-engineering") }}">Software Engineer</a>
            </div>
            <a class="expandable">PROGRAM <img src="{{ asset("icons/arrow-down.svg") }}" alt=""></a>
            <div class="branch">
                <a href="{{ route("user.programs.extracurriculars") }}">Extracurricular </a>
                <a href="{{ route("user.programs.program-silang") }}">Progsil</a>
                <a href="{{ route("user.programs.baca-tulis-quran") }}">BTQ</a>
                <a href="{{ route("candidate.index") }}">PSB</a>
            </div>
            <a href="{{ route('user.news') }}">NEWS <img src="{{ asset("icons/majors icons/non.png") }}" alt=""></a>

        </div>
        <div class="down">
            <a href="https://wa.me/6281280063529" target="_blank" rel="noopener noreferrer"><img src="{{asset('icons/telp.svg')}}"> +62 812-8006-3529</a>
            <a href="mailto:info@smkbinainformatika.sch.id"><img src="{{asset('icons/email.svg')}}">info@smkbinainformatika.sch.id</a>

        </div>
    </div>

    <script>
    document.querySelector(".burger").addEventListener("click", () => {
            document.querySelector(".mobile-nav").classList.add("on")
        })
    document.querySelector(".exit-burger").addEventListener("click", () => {
            document.querySelector(".mobile-nav").classList.remove("on")
        })

    document.querySelectorAll(".expandable").forEach(expand => {
        let rotated = false
        expand.addEventListener("click", () => {
            rotated = !rotated
            expand.children[0].style.rotate = rotated ? "180deg" : "0deg"
            expand.nextElementSibling.classList.toggle("active")
        })
    })
    document.querySelectorAll(".expandable-pc").forEach(expand => {
    const target = expand.nextElementSibling
    let timeoutId

    const show = () => {
        clearTimeout(timeoutId)
        target.classList.add("active")
    }

    const hide = () => {
        clearTimeout(timeoutId)
        timeoutId = setTimeout(() => {
            target.classList.remove("active")
        }, 100)
    }

    expand.addEventListener("mouseenter", show)
    target.addEventListener("mouseenter", show)
    expand.addEventListener("mouseleave", hide)
    target.addEventListener("mouseleave", hide)
})
    </script>

    <main class="wrapper-user">
