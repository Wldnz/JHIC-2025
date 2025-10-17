@php
    $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";

    $milestones = [
        [
            'title' => 'Melakukan Pembelian Formulir',
            'description' => 'Calon peserta didik diharapkan dapat mengisi formulir dengan sesuai dan benar',
            'image' => asset('images/candidates/tahap/1.png')
        ],
        [

            'title' => 'Mengisi Formulir Pendaftaran & Melakukan Uploud',
            'description' => 'Calon peserta didik mengisi formulir pendaftaran',
            'image' => asset('images/candidates/tahap/2.png')
        ],
        [

            'title' => 'Tentukan Jadwal Kegiatan Ujian Saringan Masuk',
            'description' => 'Calon peserta didik memilih jadwal untuk mengikuti kegiatan ujian saringan masuk',
            'image' => asset('images/candidates/tahap/3.png')
        ],
        [

            'title' => 'Melakukan Pembyara Biaya Sandang',
            'description' => 'Calon Peserta Didik Membayar Biaya Sandang Untuk Bisa Mengikuti Kegiatan USM',
            'image' => asset('images/candidates/tahap/4.png')
        ],
        [

            'title' => 'Mengisi Dokumen-Dokumen Pendukung',
            'description' => 'Calon Peserta Didik Mengisi Formulir Fomulir Yang Dibutuhkan Untuk Administrasi',
            'image' => asset('images/candidates/tahap/5.png')
        ],
        [

            'title' => 'Mengakses Modul-Modul Ujian Saringan Masuk',
            'description' => 'Calon Peserta Didik Membaca & Mempelajari Materi - Materi Untuk Persiapan Kegiatan Ujian Saringan Masuk',
            'image' => asset('images/candidates/tahap/6.png')
        ],
        [

            'title' => 'Mengikuti Kegiatan Ujian Saringan Masuk',
            'description' => 'Calon Peserta Didik Mengikuti Kegiatan Ujian Saringan Masuk',
            'image' => asset('images/candidates/tahap/7.png')
        ],
        [

            'title' => 'Melihat Hasil Ujian Saringan Masuk',
            'description' => 'Calon Peserta Didik Melihat Hasil Dari Ujian Saringan Masuk',
            'image' => asset('images/candidates/tahap/8.png')
        ],

    ];
@endphp

@include('_components._headerCandidate', [
    'title' => 'Dashboard Calon Peserta Didik'
])
<div class="dashboard">
    <p id="page-id">1</p>

    <div class="header">
        <h1>Selamat Datang, {{ Auth::user()->fullname }} </h1>
        <p>Halaman ini adalah tampilan terkait pendaftaran calon peserta didik secara online</p>
    </div>
    <div class="body">
        <h2>Tahap - Tahap Pendaftaran Yang&nbsp;Harus&nbsp;Kamu&nbsp;Selesaikan</h2>
        <p>Berikut adalah tahap-tahap yang harus kamu lakukan untuk menyelesaikan penerimaan calon pesera didik secara online!</p>

        <div class="cards-wrapper">
            @foreach ( $milestones as $stepIndex => $step)
                <div class="card {{ ($stepIndex + 1) <= $currentStage ? "enabled" : "" }}">
                    <h2>{{$step['title']}}</h2>
                    <img src="{{ asset('images/candidates/tahap/'. $loop->index + 1 .'.png') ?? $placeholder }}" alt="">
                    <div class="wrapper-border">
                        <a href="{{ $stepIndex < 5 ? route("candidate.stage.stage" . ($stepIndex+1)) : '' }}">{{ $step['action'] ?? 'Lakukan Sekarang' }}</a>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
</div>
<script defer>

let pageID = document.querySelector("#page-id").innerHTML
let navID = document.querySelectorAll(".nav-menu")

if (pageID === "1")
{
    navID[0].classList.add("active")
}
</script>

@include('_components._footerCandidate')
