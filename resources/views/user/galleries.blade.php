@php
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
@endphp
@include('_components._header', ['title' => 'product'])

<div class="galleries no-fade">
    <h1>Gallery</h1>
    <div class="gallery-images no-fade">
        @for ($i = 0; $i < 20; $i++)
        <span class="gallery-image">
            <img src="{{$placeholder}}" alt="">
            <p>Ruangan 4</p>
        </span>
        @endfor
        <div class="gallery-full">
            <div class="button-wrapper">
                <p>Kamar Wildan</p>
                <img class="gallery-close" src="{{ asset("icons/Add_Plus.svg") }}" alt="">
            </div>
            <div class="img-wrapper">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="other-images">
                @for ($i = 0; $i < 10; $i++)
                    <img src="{{ $placeholder }}" alt="">
                @endfor
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

document.querySelectorAll(".gallery-image").forEach(el => {
    el.addEventListener("click", () => {
        document.querySelector(".gallery-full").classList.add("active")
        document.body.style.overflow = "hidden"
    })
})
document.querySelector(".gallery-close").addEventListener("click", () => {
    document.querySelector(".gallery-full").classList.remove("active")
    document.body.style.overflow = "auto"
})


</script>


@include('_components._footer')