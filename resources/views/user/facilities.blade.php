@php
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
@endphp
@include('_components._header', ['title' => 'product'])
<div class="facility no-fade">
    <div class="main">
        <div class="unity"></div>

        <div class="info-facility">
            <hr>
            <p>ALL THE FACILITY<br> YOU NEED</p>
            <div class="rooms">
                <p>10+ Classes</p>
                <p>6+ Computer Lab</p>
            </div>
            <p>Complete With<br> AC, Fan, And Wifi</p>
            <hr>
        </div>

        <div class="gallery">
            <h1>Gallery</h1>
            <div class="gallery-images">
                @for ($i = 0; $i < 3; $i++)
                <span>
                    <img src="{{$placeholder}}" alt="">
                    <p>Ruangan 4</p>
                </span>
                @endfor
                <span><a href="{{ route("user.galleries") }}">Load More</a></span>
            </div>
        </div>

        <div class="location">
            
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
    // expandable

document.querySelectorAll(".expandable").forEach(button => {
    button.addEventListener("click", () => {
        button.nextElementSibling.classList.toggle("activated")
        button.children[0].classList.toggle("active")
    })
})

</script>


@include('_components._footer')