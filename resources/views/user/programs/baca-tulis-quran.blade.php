@php
    $placeholder = "";
@endphp

@include('_components._header', 
[
    'title' => 'lorem | SMK Bina Informatika',
    'description' => '',
    'keywords' => 'SMK, SMK Bina Informatika, teknologi, informatika, sekolah',
    ])

<div class="btq">
    <h2>BACA TULIS QUR'AN</h2>

    <div class="btq-text">
        <p>Program Baca Tulis Al-Qur’an (BTQ) di SMK Bina Informatika merupakan kegiatan ekstrakurikuler yang bertujuan membangun karakter dan akhlak Islami bagi siswa kelas X dan XI. Program ini dilaksanakan setiap Kamis dan Jum’at sore. BTQ bertujuan meningkatkan kemampuan membaca, menulis, dan memahami Al-Qur’an dengan benar, karena setiap huruf memiliki makna yang penting. Selain menambah pahala dan keutamaan, program ini juga menumbuhkan kecintaan siswa terhadap Al-Qur’an sebagai pedoman hidup dan sumber nilai-nilai kebaikan.</p>
    </div>

    <div class="btq-method">
        <h3>Foto Foto Kegiatan</h3>
    </div>
    <div class="btq-content">
        <div class="btq-kotak"><img src="{{ asset('images/btq/btq-placeholder.jpg') }}"></div>
        <div class="btq-kotak"><img src="{{ asset('images/btq/btq-document.jpg') }}"></div>
        <div class="btq-kotak"><img src="{{ asset('images/btq/btq-document1.png') }}"></div>
        <div class="btq-kotak"><img src="{{ asset('images/btq/btq-placeholder.jpg') }}"></div>
    </div>

    <div class="btq-system">
        <h3>Sistem Kelompok Pembelajaran</h3>

        <div class="btq-system1">
            <div class="btq-kotak1">
                <h3>Kelompok Alif ا</h3>
                <p>Kelompok ini terdiri dari siswa yang baru memulai belajar membaca Al-Qur'an, fokus pada pengenalan huruf hijaiyah dan tajwid dasar.</p>
            </div>
            <div class="btq-kotak1">
                <div class="kelompok-ba">
                    <h3>Kelompok Ba ب</h3>
                    <p>Kelompok ini terdiri dari siswa yang sudah mengenal huruf hijaiyah dan mulai belajar membaca ayat-ayat pendek serta memahami tajwid dasar.</p>
                </div>
            </div>
            <div class="btq-kotak1">
                <h3>Kelompok Ta ت</h3>
                <p>Kelompok ini terdiri dari siswa yang sudah mampu membaca ayat-ayat pendek dan mulai belajar menulis huruf hijaiyah serta memahami tajwid lanjutan.</p>
            </div>
    </div>
</div>

@include("_components._footer")