@php
    $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
@endphp
@include('_components._header', 
[
    'title' => 'Gallery | SMK Bina Informatika',
    'description' => '',
    'keywords' => 'smk, SMK Bina Informatika, teknologi, informatika, sekolah, gallery, images, facility, gambar fasilitas',
    ])

<div class="galleries no-fade">
    <h1>Gallery</h1>
    <div class="gallery-images no-fade">
        @foreach ($galleries as $gallery )
        <span class="gallery-image">
            <img class="gallery-image-url" src="{{$gallery->url}}" alt="{{ $gallery->name }}">
            <p class="gallery-name">{{ $gallery->name }}</p>
            <input type="hidden" class="gallery-type" value="{{ $gallery->gallery_type_name }}">
        </span>
        @endforeach
        <div class="gallery-full">
            <div class="button-wrapper">
                <p class="preview-gallery-name">Kamar Wildan</p>
                <img class="gallery-close" src="{{ asset("icons/Add_Plus.svg") }}" alt="">
            </div>
            <div class="img-wrapper">
                <img class="preview-gallery-url" src="" alt="">
            </div>
            <div class="other-images">
                <img src="" alt="">
            </div>
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
// gallery-img

const gallery_preview_name = document.querySelector('.preview-gallery-name');
const gallery_preview_image = document.querySelector('.preview-gallery-url');
const other_images = document.querySelector('.other-images');
const galleries = @json($galleries ?? []);

document.querySelectorAll(".gallery-image").forEach(el => {
    el.addEventListener("click", () => {
        gallery_preview_name.textContent = el.querySelector('.gallery-name').textContent;
        gallery_preview_image.src = el.querySelector('.gallery-image-url').src;
        document.querySelector(".gallery-full").classList.add("active")
        document.body.style.overflow = "hidden"

        const { name, gallery_type_name } = galleries.find(g => g.name == el.querySelector('.gallery-name').textContent);
        if(!name || !gallery_type_name) return;
        const gs = galleries.filter(g => {
            return g.name != name && g.gallery_type_name == gallery_type_name;
        });

        let string_images = '';
        gs.forEach(g => string_images += `<img src="${g.url}" alt="${g.name}">`);
        other_images.innerHTML = string_images;
    })
})
document.querySelector(".gallery-close").addEventListener("click", () => {
    document.querySelector(".gallery-full").classList.remove("active")
    document.body.style.overflow = "auto"
})


</script>


@include('_components._footer')