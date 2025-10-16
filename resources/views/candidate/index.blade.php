@php
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";

        $cards = (object)
        [
            "online" => [
            ["id" => 1, "title" => "Membuat akun", "desc" => "Calon peserta didik membuat akun terlebih dahulu"],

            ["id" => 3, "title" => "Mengisi Data Diri Yang Diperlukan", "desc" => "Calon peserta didik mengisi data diri yang diperlukan untuk masuk tahap registrasi pertama"],

            ["id" => 4, "title" => "Membeli Formulir Ujian Saringan Masuk", "desc" => "Calon peserta didik membeli formulir dan akan mendapatkan formulir serta dokumen dokumen lainnya yang harus di isi."],

            ["id" => 5, "title" => "Mengisi Formulir & Dokumen Lainnya.", "desc" => "Calon peserta didik mengisi formulir dan dan dokumen pendukung lainnya."],

            ["id" => 6, "title" => "Menguploud Formulir & Dokumen Lainnya.", "desc" => "Calon peserta didik menguploud formulir dan dokumen lainnya. Serta peserta didik dapat memilih tanggal untuk melakukan ujian saringan masuk"],

            ["id" => 7, "title" => "Mengikuti Ujian Saringan Masuk", "desc" => "Calon peserta didik mengikuti ujian saringan masuk untuk, agar minat dan bakat dapat terarah dengan tepat "],

            ["id" => 8, "title" => "Melihat Hasil Ujian Saringan Masuk", "desc" => "Calon peserta didik dapat melihat hasil dari ujian saringan masuk dan jika dinyatakan lulus."],
            ],

            "offline" => [
            ["id" => 1, "title" => "Datang Langsung Ke Sekolah", "desc" => "Calon peserta didik langsung datang ke sekolah"],

            ["id" => 2, "title" => "Membeli Formulir Pendaftaran", "desc" => "Calon peserta didik membeli formulir pendaftaran"],

            ["id" => 3, "title" => "Mengisi Data Diri Yang Diperlukan", "desc" => "Calon peserta didik mengisi formulir pendaftaran"],

            ["id" => 4, "title" => "Mengembalikan Formulir Pendaftaran", "desc" => "Calon peserta didik mengembalikkan formulir pendaftarn yang sudah diisi."],

            ["id" => 5, "title" => "Mengikuti Ujian Saringan Masuk", "desc" => "Calon peserta didik mengikuti ujian saringan masuk untuk, agar minat dan bakat dapat terarah dengan tepat."],

            ["id" => 6, "title" => "Melihat Hasil Ujian Saringan Masuk", "desc" => "Calon peserta didik dapat melihat hasil dari ujian saringan masuk dan jika dinyatakan lulus."],

            ]
        ]
@endphp
@include('_components._header', ['title' => 'product'])

<div class="psb">
    <div class="main">
        <h1>Penerimaan Siswa Baru</h1>
        <p>Kami menerima siswa - siswa yang berkompoten untuk bergelut di industri, kami membuka penerimaan siswa baru yang bisa dilakukan secara online atau secara langsung.</p>
        <a class="button" href="{{ route("candidate.login-page") }}">DAFTAR SEKARANG SECARA ONLINE</a>
    </div>

    <div class="langkah no-fade">
        <h2>Langkah Langkah Pendaftaran</h2>

        <div class="radio">
            <p class="online-button active">Online</p>
            <p class="offline-button">Di Sekolah</p>
        </div>

        <div class="body">
            <div class="online active">
                @foreach ( $cards->online as $online)
                <div class="card">
                    <img src="{{ asset('images/usm/index/online/' . $online['id'] . '.svg') }}" alt="">
                    <h3>{{ $online['title'] }}</h3>
                    <p>{{ $online['desc'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="offline">
                @foreach ( $cards->offline as $offline)
                <div class="card">
                    <img src="{{ asset('images/usm/index/offline/' . $offline['id'] . '.svg') }}" alt="">
                    <h3>{{ $offline['title'] }}</h3>
                    <p>{{ $offline['desc'] }}</p>
                </div>
                @endforeach
            </div>
            <div class="offline"></div>
        </div>
    </div>
</div>


<script>
    // fade script

document.addEventListener("DOMContentLoaded", () => {
    const elements = [...document.querySelectorAll(
        "*:not(.no-fade):not(body):not(html):not(main):not(header):not(footer):not(nav):not(.container):not(.wrapper)"
    )]
    
    
    elements.forEach(el => {
    const computed = window.getComputedStyle(el)
    el.dataset.originalOpacity = computed.opacity || 1
})

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        const el = entry.target
        const original = parseFloat(el.dataset.originalOpacity)
        const faded = Math.max(original - 0.5, 0)
        
        if (entry.isIntersecting) {
            el.style.opacity = original
        } else {
            el.style.opacity = faded
        }
    })
}, { threshold: 0.1 })

elements.forEach(el => observer.observe(el))
})

// ===============================================================
    // navbar script

const nav = document.querySelector(".navigation-user")
let lastScroll = window.scrollY
let ticking = false

window.addEventListener("scroll", () => {
  if (!ticking) {
    window.requestAnimationFrame(() => {
        const currentScroll = window.scrollY
        
        if (Math.abs(currentScroll - lastScroll) > 50) {
        if (currentScroll > lastScroll && currentScroll > 20) {
          nav.style.top = "-200px"
        } else {
          nav.style.top = "0"
        }
        lastScroll = currentScroll
    }
    
    ticking = false
})

ticking = true
}
})



// ===============================================================
    // radio

document.querySelector(".online-button").addEventListener("click", () => {
    document.querySelector(".online-button").classList.add("active")
    document.querySelector(".online").classList.add("active")

    document.querySelector(".offline-button").classList.remove("active")
    document.querySelector(".offline").classList.remove("active")
})

document.querySelector(".offline-button").addEventListener("click", () => {
    document.querySelector(".offline-button").classList.add("active")
    document.querySelector(".offline").classList.add("active")

    document.querySelector(".online-button").classList.remove("active")
    document.querySelector(".online").classList.remove("active")
})


</script>


@include('_components._footer')