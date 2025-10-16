@php
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";

        $eskuls = 
        [
            "Basket" => ["title" => "Basket", "desc" => "Olahraga tim yang dimainkan oleh dua tim beranggotakan lima orang, yang tujuannya adalah mencetak poin dengan memasukkan bola ke keranjang lawan. Permainan ini dimainkan di lapangan persegi panjang, dan teknik dasarnya meliputi dribbling (memantulkan bola), mengoper, dan menembak. "],
            "Futsal" => ["title" => "Futsal", "desc" => "Permainan sepak bola dalam ruangan yang dimainkan oleh dua tim dengan masing-masing lima pemain. Tujuannya adalah mencetak gol ke gawang lawan, tetapi dimainkan di lapangan yang lebih kecil dengan bola yang lebih padat dan pantulan rendah. Futsal menekankan keterampilan teknis seperti dribbling, passing, dan shooting, dan secara internasional diakui oleh FIFA dan UEFA"],
            "Silat" => ["title" => "Silat", "desc" => "Seni bela diri tradisional yang berasal dari Asia Tenggara, terutama Indonesia, dan telah diakui UNESCO sebagai warisan budaya takbenda. Selain untuk pertarungan fisik, silat juga mengintegrasikan gerakan seni, spiritualitas, dan pengembangan mental, dengan teknik dasar seperti kuda-kuda, pukulan, tendangan, tangkisan, dan kuncian. "],
            "Bicoustic" => ["title" => "Bicoustic", "desc" => "Musik yang dihasilkan terutama menggunakan instrumen akustik, tanpa bantuan amplifikasi atau efek elektronik, seperti gitar akustik, piano, dan biola. Genre ini menekankan suara alami dan mentah dari instrumen, yang menciptakan pengalaman mendengarkan yang intim, tulus, dan personal."],
            "Tari Daerah" => ["title" => "Tari Daerah", "desc" => "Tarian tradisional yang berasal dari suatu daerah dan menjadi ciri khas kebudayaan masyarakat di sana, yang diwariskan secara turun-temurun. Tarian ini memiliki ciri khas tertentu seperti pakem gerakan, musik pengiring, kostum, dan filosofi yang diwariskan melalui tradisi lisan. Tari daerah memiliki berbagai fungsi, seperti untuk upacara adat, persembahan, penyambutan tamu, atau sebagai sarana hiburan. "],
            "Theater Club" => ["title" => "Theater Club", "desc" => "organisasi atau perkumpulan yang fokus pada seni drama, akting, dan kegiatan teater lainnya. Anggotanya bertemu untuk mengasah keterampilan, berlatih, dan menyajikan pertunjukan. Klub ini bisa berfokus pada aspek produksi, seperti audisi, gladi resik, dan manajemen panggung."],
            "English Club" => ["title" => "English Club", "desc" => "bertujuan untuk meningkatkan kemampuan berbahasa Inggris melalui berbagai kegiatan interaktif seperti diskusi, presentasi, debat, dan permainan. Kegiatan ini menjadi wadah bagi siswa untuk berlatih, mengasah kemampuan berbicara, memperluas kosakata, dan meningkatkan kepercayaan diri dalam berbahasa Inggris, sekaligus memperdalam wawasan tentang budaya lain."],
        ]
@endphp
@include('_components._header', ['title' => 'product'])
<div class="extrac no-fade">
    <div class="main">
        <h1>EXTRACURRICULARS</h1>
        <p>Check out the vast variety of Extracurriculars we offer for students to study their hobby</p>
    </div>

    @foreach ( $eskuls as $eskul )

    <div class="extracurricular">
        <div class="left">
            <img src="{{ asset('images/eskul/' . $eskul['title'] . '.png') }}" alt="">
        </div>
        <div class="right">
            <h2>{{ $eskul['title'] }}</h2>
            <p>{{ $eskul['desc'] }}</p>
            </div>
        </div>
    @endforeach   
    
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
    // dynamic mission

const year = new Date().getFullYear()
document.querySelector("#year").innerHTML = year + 6

</script>


@include('_components._footer')