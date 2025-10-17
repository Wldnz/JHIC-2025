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
            font-size: 5vw;
            filter: brightness(0) saturate(100%) invert(17%) sepia(56%) saturate(3428%) hue-rotate(224deg) brightness(91%) contrast(90%);
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
        
        p
        {
            color: dimgray;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
        
        .icon
        {
            width: 10vw;
            filter: brightness(0) saturate(100%) invert(17%) sepia(56%) saturate(3428%) hue-rotate(224deg) brightness(91%) contrast(90%);
        }

        div
        {
           display: flex;
           flex-direction: column;
           align-items: center; 

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
