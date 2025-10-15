@php
  $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";

  $major = (object) [
    "name" => "Animation",
    "desc" => "Menciptakan kreator animasi yang berkarakter, kreatif, aktif, dan inovatif yang mampu bekerja dan berkarya di industri animasi.",
    "title" => "ONE OF THE BEST MAJOR!",
    "banner" => asset("images/majors images/anim.png"),
    "img" => asset("images/major/anim/banner.png"),
    "imgtext" => asset("images/major/anim/banner-text.png"),

    "subjects" =>
      [
        "Storyboard Artist" => "Membuat dan menuangkan naskah cerita film animasi, iklan, dan lainnya ke dalam bentuk storyboard",
        "2D & 3D Animator" => "Membuat animasi 2D dan 3D dengan mener-apkan 12 Prinsip Animasi",
        "3D Modeller & Rigging" => "Membuat objek 3D organik dan hardsurface dilengkapi dengan karakter Rigging.",
        "Character Design" => "Membuat desain karakter yang unik, mudah diingat dan memiliki ciri khas",
        "Background Artist" => " Membuat gambar digital untuk keperluan aset 2D dan background.",
        "3D Texturing, Lightning, Camera, dan Rendering" => "Membuat objek 3D yang dilengkapi dengan tekstur, pencahayaan, tata kamera hingga proses rendering.",
        "Editing & Visual Effects" => "Membuat Video Motion Graphic untuk keper-luan Opening Film, Iklan atau Sosial Media.",
        "Motion Graphic" => "Membuat Video Animation Motion (Tweening) untuk keperluan Opening Film, Infographic, Iklan, Konten Sosial Media dll.",
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
        "portfolio1" => ["Dalang Pelo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/anim/portfolio/portfolio1.png")],
        "portfolio2" => ["Palang Delo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/anim/portfolio/portfolio1.png")],
        "portfolio3" => ["Palang Pelo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/anim/portfolio/portfolio1.png")],
        "portfolio4" => ["Dalang Delo", "Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ", "Wildan Izhar Al-Haqq", asset("images/major/anim/portfolio/portfolio1.png")],
      ],

    "alumni" => (object) 
      [
        "alumni1" => ["Nur Alif Ramadhan", "Creator Dalang Pelo", "Alhamdulillah bisa ikut lomba dan menang LKS Animasi tingkat nasional 2018. Di sini aku banyak belajar animasi, sehingga bisa ngembangin bakat aku dan menciptakan animasi Dalang Pelo.", asset("images/major/anim/alumni/alumni1.png")],
        "alumni2" => ["Tami Lestari", "Alumni BI", "Sekolah ini memiliki value dan kualitias yang baik serta menyediakan program serta kegiatan untuk meningkatkan skill masing-masing siswa/i untuk siap terjun di dunia industri sesuai jurusan yang dipilih ", asset("images/major/anim/alumni/alumni2.png")],
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