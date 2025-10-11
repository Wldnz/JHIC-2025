@php
    $placeholder = "";
@endphp

@include("_components._header")
<div class="progsil">
    <h2>PROGRAM SILANG</h2>

    <div class="progsil-image">
        <img src="{{ asset('images/program-silang/Frame 348.png') }}" alt="Program Silang Image">
    </div>

    <div class="progsil-content">
        <h3>Apa itu Program Silang?</h3>

        <div class="progsil-text">
            <p>
                Program Silang SMK Bina Informatika adalah pembelajaran lintas jurusan yang bertujuan membekali siswa dengan kemampuan multiskill sesuai kebutuhan dunia usaha dan industri. Program ini mengintegrasikan bidang Teknologi Informasi dan Seni, sehingga siswa dapat mengembangkan kreativitas dan keterampilan di luar program keahlian utamanya.
                Program ini dilaksanakan setiap hari Sabtu untuk siswa kelas X dan XI, dengan pembelajaran langsung dari praktisi industri sesuai proyek masing-masing jurusan. Instruktur dipilih secara selektif dan diwajibkan menyusun lesson plan serta modul ajar yang terstruktur.
            </p>

            
            {{-- <p>
                <br>Departemen Kurikulum menyiapkan program ini dengan langkah strategis, seperti:<br>
                1. Menyesuaikan kompetensi setiap bidang keahlian,<br>
                2. Memilih instruktur sesuai keahlian,<br>
                3. Melakukan rapat koordinasi,<br>
                4. Menyusun jadwal dengan cermat.<br>
            </p>
            
            <p>
                <br>Program berjalan selama ±10 pertemuan, tiap tatap muka berdurasi 90 menit, dengan target pembelajaran spesifik. Contohnya, jurusan Rekayasa Perangkat Lunak (RPL) mengikuti program Broadcasting, membuat proyek jurnalistik bertema “Car Free Day di Bintaro” melalui tahapan pra-produksi hingga pasca-produksi.
                Selama pelaksanaan, Departemen Kurikulum melakukan kontrol dan supervisi aktif. Di akhir program, siswa mengikuti ujian akhir dan dinilai berdasarkan indikator kompetensi. Hasil ujian dan portofolio proyek menjadi bukti perkembangan dan prestasi siswa selama mengikuti Program Silang.
            </p> --}}
        </div>
    </div>

    <h3 class="artexample-text">Contoh Karya</h3>
    <div class="progsil-art">
        <div class="art"></div>
        <div class="art main"></div>
        <div class="art"></div>
    </div>
    <p style="text-align: center; margin-top: 10px;">POGRAM SILANG <br> {JURUSAN}</p>
</div>

@include("_components._footer")