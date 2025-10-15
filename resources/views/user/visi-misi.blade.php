@php
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
@endphp
@include('_components._header', ['title' => 'product'])
<div class="vimi no-fade">
    <div class="wrapper no-fade">
        <img src="{{asset("images/profile/bg.png")}}" alt="" class="bg no-fade">
        <div class="text">
            <h1>Misi SMK&nbsp;Bina&nbsp;Informatika</h1>
            <p>Mencetak generasi berkarakter yang perofesional di bidang Teknologi Informasi dan Komunikasi berstandar Nasional dan Internasional pada tahun <span id="year"></span>.</p>
        </div>
        <div class="image">
            <img src="{{ asset("images/profile/bu sinta.png") }}" alt="">
        </div>
    </div>
    
    <div class="wrapper w2">
        <div class="image">
            <img src="{{ asset("images/profile/pa budi.png") }}" alt="">
        </div>
        <div class="text">
            <h1>Visi SMK&nbsp;Bina&nbsp;Informatika</h1>
            <p>1. Membudayakan program sekolah yang berkaitan dengan keunggulan budi pekerti akhlak mulia dan keunggulan prestasi  
            <br><br>
            2. Meningkatkan kualitas pendidikan dan kuantitas kelulusan yang relevan dengan kebutuhan dunia usaha dan industri.  
            <br><br>
            3. Membimbing generasi yang mampu menguasai ilmu pengetahuan dan teknologi dalam memenuhi pasar global.</p>
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
    // dynamic mission

const year = new Date().getFullYear()
document.querySelector("#year").innerHTML = year + 6

</script>


@include('_components._footer')