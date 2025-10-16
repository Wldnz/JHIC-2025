@php
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
<main class="content">
    <div class="accessoris">
        <div class="rounded">
            <div class="round"></div>
        </div>
        <div class="stars">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
        </div>
    </div>
    <div class="greeting">
        <h2>Selamat Datang👋, {{ Auth::user()->fullname }}</h2>
        <p>Halaman ini adalah tampilan terkait pendaftaran calon peserta didik secara online</p>
    </div>
    <div class="wrapper-milestone">
        <div class="information">
            <h3 class="title">Milestone yang harus kamu selesaikan!</h3>
            <p>Berikut adalah tugas-tugas yang harus kamu lakukan untuk menyelesaikan tahap penerimaan calon peserta didik secara online!</p>
        </div>
        <div class="milestones">
            @foreach ($milestones as $milestone)
                <div class="milestone">
                    <div class="milestone-content">
                        <h4>{{ $milestone['title'] }}</h4>
                        <div class="center">
                            <img src="{{ asset('images/usm/step'. $loop->index + 1 .'.png') }}" alt="step{{ $loop->index }}">
                            <a class="btn-milestone">{{ $milestone['action-name'] ?? 'Lakukan Sekarang' }}</a>
                        </div>
                        <div class="detail-information" id="action-information">
                            <div class="action">
                                <h5>Detail Informasi</h5>
                                @include('_components._sprite-icons', ['name' => 'drop-down', 'size' => 15])
                        </div>
                            <p class="hidden" id="description">{{ $milestone['description'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>

<script defer>
    document.querySelectorAll('#action-information').forEach(e => {
        const description = e.parentElement.querySelector('#description');
        e.addEventListener('click', () => {
            description.classList.toggle('hidden');
        });
    });
</script>

@include('_components._footerCandidate')    