<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title  ?? "Bina Tata Usaha" }}</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body>

    <nav class="navigation-user">
        <div class="left"><a href="{{ route('student.dashboard') }}"><img src="https://smkbinainformatika.sch.id/wp-content/uploads/2022/11/logo.png"></a></div>
        <div class="center">
            <div class="links">
                <a href="{{ route('student.dashboard') }}">HOME</a>
                <a href="{{ route('student.products') }}">PROFILE</a>
                <a href="{{ route('student.about') }}">MAJOR</a>
                <a href="{{ route('student.about') }}">PROGRAM</a>
                <a href="{{ route('student.about') }}">NEWS</a>
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
            <a href="{{ route('student.dashboard') }}">HOME</a>
            <a class="expandable">PROFILE <img src="{{ asset("icons/arrow-down.svg") }}" alt=""></a>
                <div class="branch">
                    <a href="">Tentang Kami</a>
                    <a href="">Department Kurikulum</a>
                    <a href="">Department Kesiswaan</a>
                    <a href="">Department Kewirausahaan dan Industri</a>
                </div>
                <a class="expandable">MAJOR <img src="{{ asset("icons/arrow-down.svg") }}" alt=""></a>
                <div class="branch">
                    <a href="">Animation</a>
                    <a href="">Broadcasting Film & TV</a>
                    <a href="">Game Development</a>
                    <a href="">Visual Communication Design</a>
                    <a href="">IT Network</a>
                    <a href="">IT Software</a>
                </div>
                <a class="expandable">PROGRAM <img src="{{ asset("icons/arrow-down.svg") }}" alt=""></a>
                <div class="branch">
                    <a href="">Extracurricular </a>
                    <a href="">Progsil</a>
                    <a href="">BTQ</a>
                    <a href="">USM</a>
                    <a href="">Bimbingan Konseling</a>
                    <a href="">Project Work</a>
                </div>
            <a href="{{ route('student.about') }}">NEWS</a>
            
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



    </script>

    <main class="wrapper-user">