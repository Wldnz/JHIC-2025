@php
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";

        $major = (object) [
            "name" => "Broadcasting",
            "desc" => "Membentuk Sineas berkarakter yang kreatif, aktif, inovatif, berjiwa enterpreneur yang unggul di dunia pertelevisian.",
            "title" => "ONE OF THE BEST MAJOR!",
            "banner" => asset("images/majors images/bc.png"),
            "img" => asset("images/major/bc/banner.png"),
            "imgtext" => asset("images/major/bc/banner-text.png"),

            "subjects" => 
            [
            "Talent (Artis)" => "Mampu memerankan karakter Antagonis, Protagonis dan lainnya sesuai dengan tuntutan naskah.",
            "Presenter Acara" => "Mampu membawakan Acara berita, talkshow, feature, projek jurnalistik dan karya pertelevisian lainnya.",
            "Kameramen" => "Menguasai Teknik peng-ambilan gambar dengan shot dan angle yang sesuai dengan kebutu-han naskah.",
            "Manajemen Produksi" => "Melaksanakan manajemen produksi karya audio visual mulai dari: Planning, Organiz-ing, Actuating, dan Controlling.",
            "Naskah Cerita" => "Membuat naskah cerita film, dokumenter, iklan, produksi TV dan lainnya.",
            "Membuat Produk Audio Visual" => "Membuat Produk Audio Visual Program Drama maupun Non Drama seperti: Film, Video clip, Iklan, ILM, News/Jurnalisme, dan lainnya.", 
            "Penata Cahaya (Lighting)"=> "Mengatur kualitas pencahayaan yang baik dalam pembuatan karya audio visual.",
            "Editing Audio, Video & Visual Effects" => "Melakukan proses pasca produksi Editing Audio dan Video serta menambahkan Visual Effect pada karya audio visual."
            ],

            "icons" => 
            [
            asset("icons/major/anim/app-icons/icon1.png"),
            asset("icons/major/anim/app-icons/icon2.png"),
            asset("icons/major/anim/app-icons/icon3.png"),
            asset("icons/major/anim/app-icons/icon4.png"),
            asset("icons/major/anim/app-icons/icon5.png"),
            ],

            "portfolio" => (object)
            [
            "portfolio1" => ["Dalang Pelo","Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ","Wildan Izhar Al-Haqq",asset("images/major/anim/portfolio/portfolio1.png")],
            "portfolio2" => ["Palang Delo","Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ","Wildan Izhar Al-Haqq",asset("images/major/anim/portfolio/portfolio1.png")],
            "portfolio3" => ["Palang Pelo","Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ","Wildan Izhar Al-Haqq",asset("images/major/anim/portfolio/portfolio1.png")],
            "portfolio4" => ["Dalang Delo","Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ","Wildan Izhar Al-Haqq",asset("images/major/anim/portfolio/portfolio1.png")],
            ],

            "alumni" => (object)
            [
            "alumni1" => ["Wildan Izhar Al-Haqq","CEO Growtopia","pesan yang panjang karena sekolah ini hebat banget oh my god", asset("images/major/anim/alumni/alumni1/person.png"), asset("images/major/anim/alumni/alumni1/company.png")],
            "alumni2" => ["Rizky Sugiharto","Pembuat Python","pesan yang panjang karena sekolah ini hebat banget oh my god", asset("images/major/anim/alumni/alumni2/person.png"), asset("images/major/anim/alumni/alumni2/company.png")],
            "alumni3" => ["Raditya Putra Hidayat","CEO SEGA","pesan yang panjang karena sekolah ini hebat banget oh my god", asset("images/major/anim/alumni/alumni3/person.png"), asset("images/major/anim/alumni/alumni3/company.png")],
            ]
        ]
@endphp
@include('_components._header', ['title' => 'product'])
<div class="majors no-fade">
      <div class="main">
        <img src="{{ $major->banner }}" alt="">
        <h1>{{ $major->name }}</h1>
        <h3>{{ $major->title }}</h3>
        <h4>{{ $major->desc }}</h4>
        <h2>Subjects of {{ $major->name }}</h2>
        <img src="{{ $major->img }}" alt="" class="img-no-text">
        <img src="{{ $major->imgtext }}" alt="" class="img-text">
      </div>
      <div class="major-subjects">
        <div class="subject-change left"><img src="{{ asset("icons/arrow-down.svg") }}" alt=""></div>
        <div class="subject-slider no-fade">
            @forEach($major->subjects as $title => $content)
            <div class="subject no-fade">
                <h3>{{ $title }}</h3>
                <p>{{ $content }}</p>
            </div>
            @endforeach
        </div>
        <div class="subject-change right"><img src="{{ asset("icons/arrow-down.svg") }}" alt=""></div>
    </div>

    <div class="apps">
        <h3>SOFTWARES THAT <span>YOU</span>&nbsp;WILL&nbsp;LEARN!</h3>
        <div class="app-icons">
            <img src="{{ $major->icons[0] }}" alt="">
            <img src="{{ $major->icons[1] }}" alt="">
            <img src="{{ $major->icons[2] }}" alt="">
            <img src="{{ $major->icons[3] }}" alt="">
            <img src="{{ $major->icons[4] }}" alt="">
        </div>
        <h4>AND MUCH MORE!!</h4>
    </div>

    <div class="portfolio">
        <h3>{{ $major->name }} Portfolio</h3>
        <div class="body-portfolio">

          <div class="main-portfolio">
            <img src="{{ $major->portfolio->portfolio1[3] }}" alt="">
            <h3>{{ $major->portfolio->portfolio1[0] }}</h3>
            <p>{{ $major->portfolio->portfolio1[1] }}</p>
            <h4>{{ $major->portfolio->portfolio1[2] }}</h4>
          </div>
          <div class="other-portfolio">
            @foreach ($major->portfolio as $portfolio )
            <div class="portfolios {{ $loop->first ? 'selected' : '' }}">
              <img src="{{ $portfolio[3] }}" alt="">
              <h5>{{ $portfolio[0] }}</h5>
            </div>
            @endforeach
          </div>
        </div>
    </div>

    <div class="alumni">
        <h2>Alumni Success Story</h2>
        @foreach ($major->alumni as $alumni)
        <div class="alumni-tab">
            <div class="img-group">
                <img src="{{ $alumni[3] }}" alt="">
                <img src="{{ $alumni[4] }}" alt="">
            </div>
            <h2>{{ $alumni[0] }}</h2>
            <h4>{{ $alumni[1] }}</h4>
            <p>{{ $alumni[2] }}</p>
        </div>
        @endforeach
    </div>
</div>

<script>
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

document.addEventListener("DOMContentLoaded", () => {
  const slider = document.querySelector(".subject-slider")
  const leftBtn = document.querySelector(".subject-change.left")
  const rightBtn = document.querySelector(".subject-change.right")

  let subjects = Array.from(document.querySelectorAll(".subject"))

  const firstClone = subjects[0].cloneNode(true)
  const lastClone = subjects[subjects.length - 1].cloneNode(true)

  slider.appendChild(firstClone)
  slider.insertBefore(lastClone, subjects[0])

  subjects = Array.from(document.querySelectorAll(".subject"))
  const itemWidth = subjects[0].offsetWidth

  slider.scrollLeft = itemWidth

  let isTransitioning = false

  const loopCheck = () => {
    if (isTransitioning) return
    if (slider.scrollLeft >= (subjects.length - 1) * itemWidth) {
      isTransitioning = true
      slider.scrollLeft = itemWidth
      setTimeout(() => (isTransitioning = false), 50)
    } else if (slider.scrollLeft <= 0) {
      isTransitioning = true
      slider.scrollLeft = (subjects.length - 2) * itemWidth
      setTimeout(() => (isTransitioning = false), 50)
    }
  }

  slider.addEventListener("scroll", loopCheck)

  rightBtn.addEventListener("click", () => {
    slider.scrollTo({
      left: slider.scrollLeft + itemWidth,
      behavior: "smooth",
    })
  })

  leftBtn.addEventListener("click", () => {
    slider.scrollTo({
      left: slider.scrollLeft - itemWidth,
      behavior: "smooth",
    })
  })
})


</script>


@include('_components._footer')