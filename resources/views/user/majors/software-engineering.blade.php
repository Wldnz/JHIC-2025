@php
  $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";

  $major = (object) [
    "name" => "Software Engineer",
    "desc" => "Menghasilkan lulusan yang cerdas, disiplin, kreatif, inovatif dan sikap profesional dibidang Rekayasa Perangkat Lunak.",
    "title" => "ONE OF THE MOST POPULAR MAJOR!",
    "banner" => asset("images/majors images/rpl.png"),
    "img" => asset("images/major/rpl/banner.png"),
    "imgtext" => asset("images/major/rpl/banner-text.png"),

    "subjects" =>
      [
        "Basis Data" => "Merancang serta mengintegrasikan data base ke dalam Software Pengolah Database (DBMS) menggunakan Query.",
        "Pemrograman Web (PHP, HTML, CSS)" => "Membuat Sistem Informasi berbasis website (Framework CI, PHP, HTML, CSS) yang dalam kebutuhan industri.",
        "Dokumentasi Aplikasi" => "Mampu mendokumentasikan aplikasi seperti testing, membuat user manual, dan aktivitas lainnya.",
        "Pemodelan PL" => "Menentukan Software Development Life Cycle (SDLC) yang tepat dan dapat menganalisis serta merancang Activity Diagram, Use Case Diagram, Class Diagram, Sequence Diagram, dll.",
        "Pemrograman Mobile (ANDROID)" => "Membuat aplikasi perangkat bergerak (Android) yang dapat memenuhi tantangan dan peluang di pasar global.",
        "Pemrograman Desktop (Java)" => "Membuat Sistem Informasi berbasis Desktop (Java) sesuai dengan kebutuhan industri.",
        "Design Prototype (UI/UX)" => "Membuat design prototype (UI/UX) untuk memberikan visualisasi bagaimana produk final akan terlihat.",

      ],

    "icons" =>
      [
        asset("icons/major/rpl/app-icons/icon1.png"),
        asset("icons/major/rpl/app-icons/icon2.png"),
        asset("icons/major/rpl/app-icons/icon3.png"),
        asset("icons/major/rpl/app-icons/icon4.png"),
        asset("icons/major/rpl/app-icons/icon5.png"),
      ],

    "portfolio" => (object) 
      [
        "portfolio1" => ["Dalang Pelo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/rpl/portfolio/portfolio1.png")],
        "portfolio2" => ["Palang Delo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/rpl/portfolio/portfolio1.png")],
        "portfolio3" => ["Palang Pelo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/rpl/portfolio/portfolio1.png")],
        "portfolio4" => ["Dalang Delo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/rpl/portfolio/portfolio1.png")],
      ],

    "alumni" => (object) 
      [
        "alumni1" => ["Andrew Darma", "Alumni BI", "Sekolah ini memiliki value yang bagus, mempunyai banyak program yang mendukung skill dari masing-masing siswa, pengalaman pribadi yang saya dapatkan setelah memilih jurusan RPL dan lulus dari sekolah ini, sangat membantu pemahaman saat saya melanjutkan pembelajaran ke tingkat yang lebih tinggi di Universitas.", asset("images/major/rpl/alumni/alumni1.png")],
        "alumni2" => ["Ida Bagus Jordana", "Alumni BI", "Selama bersekolah di SMK Bina Informatika, banyak sekali pelajaran dan ilmu bermanfaat yang saya dapatkan. Peningkatan secara signifikan dibangun disini. Mulai dari Softskill serta Hardskill, hingga problem solving. Sehingga saya sebagai siswa merasa program yang diberikan dapat meningkatkan kemampuan siswanya untuk siap bersaing di dunia luar.", asset("images/major/rpl/alumni/alumni2.png")],
      ]
  ]
@endphp
@include('_components._header', 
[
    'title' => 'Software Engineer | SMK Bina Informatika',
    'description' => 'SMK Bina informatika | Jurusan RPL adalah Rekayasa Perangkat Lunak, yaitu jurusan di SMK yang berfokus pada pengembangan, perancangan, dan pembuatan perangkat lunak seperti aplikasi, software, dan game. Siswa akan mempelajari coding, desain, dan algoritma, serta konsep pemrograman seperti Java, Python, C++, HTML, dan CSS. Lulusannya memiliki prospek karier luas di bidang teknologi informasi, seperti software engineer, web developer, dan mobile app developer.',
    'keywords' => 'jurusan RPL, Rekayasa Perangkat Lunak, SMK Bina Informatika Bintaro, sekolah coding, sekolah IT, sekolah pemrograman, software development, web developer, aplikasi mobile, jurusan teknologi, SMK IT terbaik, RPL Bintaro',
    ])
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

  @if ($portfolios->count() > 0)
    <div class="portfolio">
      <h3>{{ $major->name }} Portfolio</h3>
      <div class="body-portfolio">
        <div class="main-portfolio">
          <img src="{{ $portfolios[0]->portfolioImages[0]->url }}" alt="">
          <h3>{{ $portfolios[0]->title }}</h3>
          <p>{{ $portfolios[0]->description }}</p>
          <h4>{{ $portfolios[0]->student_name }}</h4>
        </div>
        <div class="other-portfolio">
          @foreach ($portfolios as $portfolio)
            <div class="portfolios {{ $loop->first ? 'selected' : '' }}">
              <img src="{{ $portfolio->portfolioImages[0]['url'] }}" alt="{{ $portfolio->title }}">
              <h5>{{ $portfolio->title }}</h5>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif

  @if ($achievements->count() > 0)
    <div class="prestasi">
      <h3>Prestasi Murid {{ $major->name }}</h3>
      <div class="prestasi-slider">
        @foreach($achievements as $achievement)
          <div class="prestasi-content">
            <img src="{{ $achievement->thumbnail_url }}" alt="{{ $achievement->competition_name }}">
            <div class="info">
              <div class="img-wrapper">
                <!-- <img src="{{ asset("icons/medal.svg") }}" alt=""> -->
                @include('_components._sprite-icons', ['name' => 'rank-' . explode('_', $achievement->competition_position)[1] . '', 'size' => 50])
              </div>
              <div class="text">
                <h4>{{ $achievement->student_name }}</h4>
                <h5>{{ $achievement->competition_name }}</h5>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  <div class="alumni">
    <h2>Alumni's Story</h2>
    @foreach ($major->alumni as $alumni)
      <div class="alumni-tab">
        <div class="img-group">
          <img src="{{ $alumni[3] }}" alt="">
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