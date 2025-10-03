<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "Bina Tata Usaha" }}</title>
    <!-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> -->
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>

<body>
    @php
    if(empty($title)) $title = "Bina Tata Usaha";
    $currentPath = explode('/admin/', url()->current())[1];
    @endphp
    <main class="wrapper-admin">
        @include('_components._navigation-side', [ "title" => "Products" ])
        <aside class="right">
            @include('_components._bar-top-admin', ["title" => $title])


@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])
