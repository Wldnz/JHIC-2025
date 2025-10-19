@php
    $countdown = false
@endphp
@include('_components._headerCandidate',[
    'title' => 'Hasil Ujian Saringan Masuk'   
])
<main class="result">
    <div class="header">
        <h1>Lihat hasil USM Anda!</h1>
    </div>
    <div class="body">
        @if ($countdown)
            <h2>Hasil USM anda akan ditampilkan dalam</h2>
            <h3>4D 23H 54M 23S</h3>
            <h4>(09/11/2001)</h4>
            
            @else
            <h2>Hasil USM anda adalah</h2>
            <div class="reveal">
                <h1>Anda <span>LULUS</span> Ujian!</h1>
                <h4>SELAMAT KAKAK!!!</h4>
            </div>
            
            
        @endif
    </div>
    
    <script>
        document.querySelector(".reveal").addEventListener("click", () => { document.querySelector(".reveal").classList.add("active") })
    </script>
</main>

@include('_components._footerCandidate')    