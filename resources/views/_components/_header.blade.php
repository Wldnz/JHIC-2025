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
            <a href="http://wa.me/6281280063529" target="_blank" rel="noopener noreferrer"><button class="button button-circle"><img src="{{asset('icons/telp.svg')}}"></button></a>
            <a href="mailto:pefiye@gmail.com"><button class="button button-circle"><img src="{{asset('icons/email.svg')}}"></button></a>
        </div>

    </nav>
    <div class="mobile-nav no-fade">
        <div class="up">
            <img class="exit-burger" src="{{ asset("icons/Add_Plus.svg") }}" alt="">
            <a href="{{ route('student.dashboard') }}">HOME</a>
            <a href="{{ route('student.products') }}">PROFILE</a>
            <a href="{{ route('student.about') }}">MAJOR</a>
            <a href="{{ route('student.about') }}">PROGRAM</a>
            <a href="{{ route('student.about') }}">NEWS</a>
            
        </div>
        <div class="down">
            <a href="http://wa.me/6281280063529" target="_blank" rel="noopener noreferrer"><button class="button"><img src="{{asset('icons/telp.svg')}}"></button></a>
            <a href="mailto:pefiye@gmail.com"><button class="button"><img src="{{asset('icons/email.svg')}}"></button></a>

        </div>
    </div>

    <script>
    document.querySelector(".burger").addEventListener("click", () => {
            document.querySelector(".mobile-nav").classList.add("on")
        })
    document.querySelector(".exit-burger").addEventListener("click", () => {
            document.querySelector(".mobile-nav").classList.remove("on")
        })
    </script>

    <main class="wrapper-user">