@include('_components._header', ['title' => 'product'])

<?php 
$placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg"

?>

<img src="<?= $placeholder?>" alt="" class="hugeimg">


<div class="categories">
    <h3>PILIH SERAGAM SESUAI KEBUTUHAN MU!</h3>
    <a href="">
    <div class="section1">
        <div class="category-tab">
            <img src="<?=$placeholder?>" alt="">
            <p>Seragam <br>Laki-Laki</p>
        </div>
    </a>
    <a href="{{ route('student.products') }}">
        <div class="category-tab">
            <img src="<?=$placeholder?>" alt="">
            <p>Seragam <br>Perempuan</p>
        </div>
    </div>
    </a>
    <div class="section2">

    </div>
</div>

@include('_components._footer')