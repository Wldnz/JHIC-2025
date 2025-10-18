@php
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";

        $major = (object) [
            "name" => "Visual Communication Design",
            "desc" => "Mencetak Seniman Digital yang kreatif, aktif, dan inovatif yang mampu bekerja dan bersaing di industri kreatif.",
            "title" => "ONE OF THE MOST POPULAR MAJOR!",
            "banner" => asset("images/majors images/dkv.png"),
            "img" => asset("images/major/dkv/banner.png"),
            "imgtext" => asset("images/major/dkv/banner-text.png"),

            "subjects" => 
            [
            "Design Brief" => "Membuat dan melaksanakan perintah panduan tertulis (design brief), yang terdiri dari: Latar belakang, Tujuan, Ruang lingkup, Sasaran, Media, Strategi kreatif dan konsep.",
            "Fotografi" => "Menerapkan prinsip, estetika, dan prosedur yang digunakan dalam pemotretan.",
            "Motion Graphic" => "Mampu mengoperasikan berbagai perangkat kamera video dan dilengkapi dengan kemampuan sinematography yang handal.",
            "Dasar Desain Komunikasi" => "Menerapkan prinsip dasar desain dalam merancang visual: kesatuan, keseimbangan, komposisi, proposi, irama, penekanan, kesederhanaan, kejelasan, dan ruang.",
            "Digital Imaging" => "Mengolah gambar dokumen asli menjadi file digital untuk keperluan Desain Komunikasi.",
            "Print Design" => "Menyampaikan informasi kepada audiens melalui desain cetak pada permukaan yang nyata. (Poster, Banner, Desain Kemasan Produk, dll).",
            "Unsur-Unsur Design Grafis" => "Silahkan memilih untuk.",
            "Sketsa dan Ilustrasi" => "Penguasaan teknik keterampilan sketsa dan ilustrasi untuk kebutuhan dasar rancangan desain.",
            "3D Software" => "Melakukan pengolahan obyek 3D untuk keperluan komunikasi visual berbasis obyek 3D.",
            "Web & App Design (UI & UX)" => "Menerapkan komunikasi desain dalam situs web, mobile apps, dan aplikasi desktop yang berfokus pada pengalaman pengguna dan interaksi.",
            ],

            "icons" => 
            [
            asset("icons/major/dkv/app-icons/icon1.png"),
            asset("icons/major/dkv/app-icons/icon2.png"),
            asset("icons/major/dkv/app-icons/icon3.png"),
            asset("icons/major/dkv/app-icons/icon4.png"),
            asset("icons/major/dkv/app-icons/icon5.png"),
            ],

            "portfolio" => (object)
            [
            "portfolio1" => ["Dalang Pelo","Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ","Wildan Izhar Al-Haqq",asset("images/major/dkv/portfolio/portfolio1.png")],
            "portfolio2" => ["Palang Delo","Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ","Wildan Izhar Al-Haqq",asset("images/major/dkv/portfolio/portfolio1.png")],
            "portfolio3" => ["Palang Pelo","Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ","Wildan Izhar Al-Haqq",asset("images/major/dkv/portfolio/portfolio1.png")],
            "portfolio4" => ["Dalang Delo","Animasi Hybrid 2D dan 3D bertema persahabatan melawan kejahatan yang sering memberi kutukan kepada hewan hewan dan tanaman di dunia ini dengan sihirnya ","Wildan Izhar Al-Haqq",asset("images/major/dkv/portfolio/portfolio1.png")],
            ],

            "alumni" => (object)
            [
            "alumni1" => ["Asilanisa Wijayanti","Alumni BI","Alhamdulillah.. bersyukur banget bisa dipertemukan sama SMK Bina Informatika. Aku dapet banyak ilmu yang bener-bener bermanfaat dan kepake selama kuliah apalagi di dunia kerja. Seperti di lembaga pemerintahan, perusahaan terbuka Indonesia, dan menjadi seorang freelancer.", asset("images/major/dkv/alumni/alumni1.png")],
            "alumni2" => ["Aisyah Khairunnisa","Alumni BI","Menurutku SMK BI adalah sekolah yang tepat untuk anak – anak yang berminat dalam bidang IT. Dan juga mempunyai kesempatan yang besar untuk terjun langsung ke dunia industri, yang mana sebelumnya SMK BI sudah mempersiapkan anak didiknya dalm praktik kerja lapangan atau PKL pada tahun ke 2 sekolah.", asset("images/major/dkv/alumni/alumni2.png")],
            ]
        ]
@endphp
@include('_components._header', 
[
    'title' => 'Design Communication Visual | SMK Bina Informatika',
    'description' => 'SMK Bina informatika | Jurusan DKV adalah singkatan dari Desain Komunikasi Visual, sebuah program studi yang fokus pada penyampaian pesan melalui elemen visual seperti gambar, warna, tipografi, dan animasi. Jurusan ini mempelajari cara mengolah ide menjadi visual yang efektif, informatif, dan komunikatif untuk berbagai media, baik cetak maupun digital. Lulusannya memiliki peluang karier yang luas di industri kreatif, seperti menjadi desainer grafis, animator, ilustrator, atau desainer UI/UX.',
    'keywords' => 'jurusan DKV, Desain Komunikasi Visual, SMK Bina Informatika Bintaro, desain grafis, komunikasi visual, periklanan, branding, visual identity, desain kreatif, seni digital, sekolah DKV Bintaro, jurusan desain terbaik',
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
                <img src="{{  asset('icons/medals/'. explode('_',$achievement->competition_position)[1] .'.svg') }}" alt="">
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