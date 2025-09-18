</main>

<footer>
    <div class="links">
        <h4>BiTU</h4>
        <a href="{{ route('student.dashboard') }}"><p>Home</p></a>
        <a href="{{ route('student.products') }}"><p>Products</p></a>
        <a href="{{ route('student.about') }}"><p>About Us</p></a>
        <a href="{{ route('student.cart') }}"><p>Your Cart</p></a>
    </div>
    <div class="links">
        <h4>SMK Bina Informatika</h4>
        <a href="https://www.smkbinainformatika.sch.id"><p>Website</p></a>
        <a href="https://www.youtube.com/@officialsmkbi"><p>Youtube</p></a>
        <a href="https://www.instagram.com/officialsmkbi/"><p>Instagram</p></a>
        <a href="https://www.tiktok.com/@official.smkbi"><p>Tiktok</p></a>
        <a href="https://www.linkedin.com/company/smk-bina-informatika"><p>LinkedIn</p></a>
    </div>
    <div class="links">
        <h4>Contact</h4>
        <a href="https://maps.app.goo.gl/vfUXsErkEc6igeDe8"><p>Ciputat, Jl Cendrawasih Raya 9A</p></a><br>
        <p onclick="copy(this)">info@smkbinainformatika.sch.id</p></a><br>
        <a onclick="copy(this)"><p>(021) - 745 3048</p></a>
        <a onclick="copy(this)"><p>62 812-8006-3529</p></a><br>
    </div>
    <span id="pop-up-copy"><p>Copied!</p></span>
</footer>

<script>
    function copy(el)
    {
        const text = el.innerText;

        navigator.clipboard.writeText(text);

        const popup = document.querySelector("#pop-up-copy");
        popup.style.visibility = "visible";
        popup.style.opacity = 1;

        setTimeout(() => {
            popup.style.opacity = 0;
        }, 1000);
        setTimeout(() => {
            popup.style.visibility = "hidden";
        }, 1500);
    }
</script>
</body>
</html>