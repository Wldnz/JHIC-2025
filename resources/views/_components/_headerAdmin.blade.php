<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title . ' | SMK BINA INFORMATIKA' ?? "SMK BINA INFORMATIKA" }}</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-bi.png') }}" type="image/png">
    @vite(["resources/css/admin.css" ,"resources/js/app.js"])
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

<script defer>
    const defaultSrc = "{{ asset('icons/loading-image.png') }}";
</script>
@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])
