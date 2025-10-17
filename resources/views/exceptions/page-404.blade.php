@php
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAGE ERROR</title>
    <style>
        body
        {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        h1
        {
            font-size: 10vw;
            color: dimgray;
        }
        
        p
        {
            color: dimgray;

        }
        
        .icon
        {
            width: 10vw;
        }
    </style>
</head>
<body>
    <div>

        <img class="icon" src="{{ asset("icons/lag.svg") }}" alt="">
        <h1>Connection Error</h1>
        <p>Please Check Your Internet Connection</p>
    </div>
    <img class="logo" src="{{ asset("images/bi-full.png") }}" alt="">
    
</body>
</html>
