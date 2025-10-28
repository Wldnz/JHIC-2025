@include('_components._headerCandidate',[
    'title' => 'Jadwal Ujian Saringan Masuk'
])
<main class="jadwal">
    <h1>Jadwal USM</h1>
    @foreach ($registrationPhases as $registrationPhase)
        <div class="gelombang">
            <h2>{{ $registrationPhase->name }}</h2>
            <h4>{{ date_format($registrationPhase->started_at, 'd M Y') }}  —  {{ date_format($registrationPhase->ended_at, 'd M Y') }}</h4>
        </div>
    @endforeach
</main>
@include('_components._footerCandidate')
