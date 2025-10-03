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
        <div class="left"><a href="{{ route('student.dashboard') }}"><img src="{{asset ('images/bitu.png')}}"></a></div>
        <div class="center">
            <div class="links">
                <a href="{{ route('student.dashboard') }}">HOME</a>
                <a href="{{ route('student.products') }}">PRODUCTS</a>
                <a href="{{ route('student.about') }}">ABOUT</a>
            </div>
        </div>

        <div class="right">
            <a href="{{ route("student.cart") }}"><button class="button button-circle"><img src="{{asset('icons/shop.svg')}}"></button></a>
            <button onclick="floating('.float','.backdrop')" class="button button-circle"><img src="{{asset('icons/user.svg')}}"></button>
            <div class="backdrop" onclick="floating('.float','.backdrop')"></div>
            <div class="float">
                <a href="{{ route('profile') }}"><div class="img-container"><img src="{{ asset('icons/user.svg') }}" alt=""></div><p>{{ Auth::user()->fullname }}</p></a>
                <a href="{{ route('logout') }}"><div class="img-container"><img src="{{ asset('icons/Log_Out.svg') }}" alt=""></div><p>Logout</p></a>
            </div>
        </div>
    </nav>
    <main class="wrapper-user">
</div>

<script>
    function floating(el1, el2)
    {
        const element = document.querySelector(el1);
        const backdrop = document.querySelector(el2);

        element.classList.toggle("show");
        backdrop.classList.toggle("show");

        document.addEventListener("scroll", () => {
            element.classList.remove("show");
            backdrop.classList.remove("show");
        })
    }
</script>
