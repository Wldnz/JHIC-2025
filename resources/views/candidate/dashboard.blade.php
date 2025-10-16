@php
    $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";

    $milestones = [
        [
            'title' => 'Mengisi Formulir Data Diri',
            'description' => 'Calon peserta didik diharapkan dapat mengisi formulir dengan sesuai dan benar',
        ],
        [
            
            'title' => 'Memilih Jadwal Ujian Saringan Masuk',
            'description' => 'Calon peserta didik memilih jadwal untuk mengikuti kegiatan ujian saringan masuk',
        ],
        [
            
            'title' => 'Melakukan Pembayaran Biaya Sandang & Ujian Saringan Masuk',
            'description' => 'Calon peserta didik memilih jadwal untuk mengikuti kegiatan ujian saringan masuk',
        ],
        [
            
            'title' => 'Memilih Jadwal Ujian Saringan Masuk',
            'description' => 'Calon peserta didik memilih jadwal untuk mengikuti kegiatan ujian saringan masuk',
        ],
        [
            
            'title' => 'Memilih Jadwal Ujian Saringan Masuk',
            'description' => 'Calon peserta didik memilih jadwal untuk mengikuti kegiatan ujian saringan masuk',
        ],
        [
            
            'title' => 'Memilih Jadwal Ujian Saringan Masuk',
            'description' => 'Calon peserta didik memilih jadwal untuk mengikuti kegiatan ujian saringan masuk',
        ],
        [
            
            'title' => 'Memilih Jadwal Ujian Saringan Masuk',
            'description' => 'Calon peserta didik memilih jadwal untuk mengikuti kegiatan ujian saringan masuk',
        ],
        [
            
            'title' => 'Memilih Jadwal Ujian Saringan Masuk',
            'description' => 'Calon peserta didik memilih jadwal untuk mengikuti kegiatan ujian saringan masuk',
        ],
        
    ];
@endphp

@include('_components._headerCandidate', [
    'title' => 'Dashboard Calon Peserta Didik'
])
<div class="dashboard">
    <p id="page-id">1</p>
    
    <div class="header">
        <h1>Selamat Datang Athvi, </h1>
        <p>Halaman ini adalah tampilan terkait pendaftaran calon peserta didik secara online</p>
    </div>
    <div class="body">
        <h2>Tahap - Tahap Pendaftaran Yang&nbsp;Harus&nbsp;Kamu&nbsp;Selesaikan</h2>
        <p>Berikut adalah tahap-tahap yang harus kamu lakukan untuk menyelesaikan penerimaan calon pesera didik secara online!</p>

        <div class="cards-wrapper">
            @foreach ( $milestones as $step)
                <div class="card {{ $loop->first ? "enabled" : "" }}">
                    <h2>{{$step['title']}}</h2>
                    <img src="{{ $placeholder }}" alt="">
                    <div class="wrapper-border">
                        <a href="">Lakukan Sekarang</a>

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