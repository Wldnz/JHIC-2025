@php
  $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";

  $major = (object) [
    "name" => "IT Network",
    "desc" => "Mencetak administrator server dan jaringan yang handal, cermat, inovatif dan profesional di bidang teknologi informasi dan komunikasi.",
    "title" => "ONE OF THE BEST MAJOR!",
    "banner" => asset("images/majors images/tkj.png"),
    "img" => asset("images/major/tkj/banner.png"),
    "imgtext" => asset("images/major/tkj/banner-text.png"),

    "subjects" =>
      [
        "Routing Jaringan" => "Menganalisis, mengkonfigurasi dan memperbaiki routing statis dan Dinamis.",
        "Konfigurasi Jaringan Lokal (LAN)" => "Menganalisis, konfigurasi serta melakukan perbaikan pada jaringan LAN.",
        "Merakit PC, Installasi OS & Software" => "Menganalisis, merakit, Instalasi perangkat keras, software, Operating, Sistem dan jaringan.",
        "Perbaikan PC & Jaringan" => "Melakukan perawatan perangkat keras Komputer, software, Operating Sistem dan jaringan.",
        "Konfigurasi Proxy Server & VLAN" => "Menganalisis, mengkonfigurasi serta melakukan perbaikan pada Proxy Server dan VLAN.",
        "Administrasi Sistem Jaringan" => "Menganalisis, Melakukan instalasi dan Perbaikan pada sistem operasi jaringan seperi DHCP Server, FTP Server, Sistem Kontrol & Monitoring, dan Sistem Keamanan Jaringan.",
        "Fiber Optic" => "Mendesign, mengoperasikan, menyambungkan dan mengkonfigurasi jaringan berbasis luas Fiber Optic (FO).",
        "Konfigurasi Network Address Translation (NAT)" => "Menganalisis, mengkonfigurasi, dan memperbaiki jaringan berbasis NAT.",

      ],

    "icons" =>
      [
        asset("icons/major/tkj/app-icons/icon1.png"),
        asset("icons/major/tkj/app-icons/icon2.png"),
        asset("icons/major/tkj/app-icons/icon3.png"),
        asset("icons/major/tkj/app-icons/icon4.png"),
        asset("icons/major/tkj/app-icons/icon5.png"),
      ],

    "portfolio" => (object) 
      [
        "portfolio1" => ["Dalang Pelo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/tkj/portfolio/portfolio1.png")],
        "portfolio2" => ["Palang Delo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/tkj/portfolio/portfolio1.png")],
        "portfolio3" => ["Palang Pelo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/tkj/portfolio/portfolio1.png")],
        "portfolio4" => ["Dalang Delo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/tkj/portfolio/portfolio1.png")],
      ],

    "alumni" => (object) 
      [
        "alumni1" => ["Rino Pangestu", "Alumni BI", "Alhamdulillah pilihan saya tepat untuk melanjutkan pendidikan di SMK Bina Informatika jurusan TKJ, karena dari sistem pembelajaran, lebih banyak pembelajaran praktek. Jadi ketika lulus, sudah sangat siap untuk mengimplementasikan hasil belajar dan bersaing di dunia kerja.", asset("images/major/tkj/alumni/alumni1.png")],
        "alumni2" => ["Reynanda Al Ridwan", "Alumni BI", "Menurut saya, sekolah ini dapat memberikan kualitas dan kuantitas pembelajaran sangat baik seperti contohnya mendatangkan penguji UKK yang sangat kompeten dalam bidangnya sehingga dapat membuat siswa dapat bersaing di dunia revolusi industri 4.0", asset("images/major/tkj/alumni/alumni2.png")],
        "alumni3" => ["Fahri Ardian", "Alumni BI", "Sekolah ini menuntut anaknya untuk tidak hanya bisa dalam jurusan yang masing masing anak pilih tetapi dalam setiap semester akan di rolling pembelajaran lintas jurusan yang tentunya akan sangat berguna bagi saya nantinya.", asset("images/major/tkj/alumni/alumni3.png")],
      ]
  ]
@endphp
@include('_components._header', 
[
    'title' => 'IT Network | SMK Bina Informatika',
    'description' => 'SMK Bina informatika | Jurusan TKJ adalah singkatan dari Teknik Komputer dan Jaringan, sebuah program keahlian di Sekolah Menengah Kejuruan (SMK) yang berfokus pada bidang Teknologi Informasi dan Komunikasi (TIK). Siswa mempelajari cara merakit, mengelola, dan memperbaiki komputer, serta merancang, membangun, mengamankan, dan mengadministrasikan jaringan komputer (seperti LAN, WAN, dan Wi-Fi). ',
    'keywords' => 'jurusan TKJ, Teknik Komputer dan Jaringan, SMK Bina Informatika Bintaro, jaringan komputer, server, mikrotik, komputer, perakitan PC, administrator jaringan, SMK teknik komputer, SMK IT Bintaro, jurusan jaringan terbaik',
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