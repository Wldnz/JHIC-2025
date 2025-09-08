<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title  ?? "Bina Tata Usaha" }}</title>
    <!-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> -->
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body>

    <nav>
        <div class="left"><a href="#"><img src="https://smkbinainformatika.sch.id/wp-content/uploads/2022/11/logo.png"></a></div>
        <div class="center">
            <div class="links">
                <a href="{{ route('student.dashboard') }}">Home</a>
                <a href="{{ route('student.products') }}">Products</a>
                <a href="{{ route('student.about') }}">About</a>
            </div>
        </div>
        
        <div class="right"><a href="login.blade.php"><button class="button">Sign in</button></a></div>
    </nav>
    <main class="wrapper-user">
</div>