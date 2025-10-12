@include('_components._headerAdmin', ['title' => 'Detail Account'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$account, $candidate]);
    $status_families = [
        'biological_child' => 'Anak Kandung',
        'step_child' => 'Anak Angkat',
        'adopted_child' => 'Anak Adopsi',
        'foster_child' => 'Anak Asuh',
    ];

    $religions = [
        'islam' => 'Islam',
        'confucion' => "Konghucu",
        'protestant' => "Protestan",
        'catholic' => "Katolik",
        'hindu' => "Hindu",
        'buddha' => "Buddha",
        'other' => "Lainnya",
    ];
@endphp
<form class="content" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="profile-container">
        <div class="wrapper-profile-image">
            <img src="{{ asset('images/default.png') }}" alt="profile-{nama}">
            <span class="name">{{ $account->fullname }}</span>
            <span class="sub-name">{{ strtoupper($account->role[0]) . substr($account->role, 1) }}</span>
        </div>
        <div class="form-data-profile" id="student-siswa-form">
            <div class="container">
                @if ($account->role == 'candidate' && $candidate)
                    <div class="wrapper-input wrapper-input-full">
                        <label for="candidate_nisn">Nomor Induk Nasional</label>
                        <input type="text" name="candidate_nisn" id="candidate_nisn" placeholder="Nisn Calon Peserta Didik"
                            value="{{ old('candidate_nisn', $candidate->nisn) }}" aria-describedby="nisn" required>
                    </div>
                @endif
                <div class="wrapper-input">
                    <label for="candidate_fullname">Nama Lengkap</label>
                    <input type="text" name="candidate_fullname" id="candidate_fullname"
                        placeholder="Nama Lengkap Calon Peserta Didik"
                        value="{{ old('candidate_fullname', $account->fullname) }}" aria-describedby="fullname"
                        required>
                </div>
                @if($account->role == 'candidate' && $candidate)
                    <div class="wrapper-input">
                        <label for="candidate_short_name">Nama Panggilan</label>
                        <input type="text" name="candidate_short_name" id="candidate_short_name"
                            placeholder="Nama Panggilan Calon Peserta Didik"
                            value="{{ old('candidate_short_name', $candidate->short_name) }}" aria-describedby="shortname"
                            required>
                    </div>
                    <div class="wrapper-input">
                        <label for="candidate_birth_place">Tempat Lahir</label>
                        <input type="text" name="candidate_birth_place" id="candidate_birth_place"
                            placeholder="Tempat Lahir Calon Peserta Didik"
                            value="{{ old('candidate_birth_place', $candidate->birthplace) }}" aria-describedby="birthplace"
                            required>
                    </div>
                    <div class="wrapper-input">
                        <label for="candidate_birth_date">Tanggal Lahir</label>
                        <input type="date" inputmode="numeric" name="candidate_birth_date" id="candidate_birth_date"
                            placeholder="Tanggal Lahir Calon Peserta Didik"
                            value="{{ old('candidate_birth_date', substr($candidate->birthdate, 0, 10)) }}"
                            aria-describedby="birthdate" required>
                    </div>
                @endif
            </div>
        </div>
    </div>
   <div class="wrapper-content">
        @includeWhen($account->role == 'candidate' && $candidate,'admin.accounts.components.details.index')
    </div>
    <div class="wrapper-button">
        <button class="btn" type="submit">Simpan Perubahan</button>
        <button class="btn btn-back" type="submit">Kembali</button>
    </div>
</form>

<script defer>
    const major = {
        data : @json($majors),
        selected : @json($candidate->candidateMajors),
        idElement : 'major-card',
        changeSelected : ({ id, long_name, short_name }, element) => {
            const maximum = 2;
            if(major.selected.length >= maximum) major.selected.shift();
            major.selected.push({
                id : `added_major_${new Date().getTime()}`,
                major_id : id,
                major_long_name : long_name,
                major_short_name : short_name
            });
            major.renderSelected();
        },
        removeSelected : (currentMajor, element) => {
            major.selected = major.selected.filter(s => s.major_id != currentMajor.id);
            element.classList.remove('choose-card-selected');
        },
        renderSelected : () => {
            const elements =  document.querySelectorAll(`#${major.idElement}`);
            let stringElement = '';
            elements.forEach(e => e.classList.remove('choose-card-selected'));
            elements.forEach(element => {
                major.selected.forEach(m => {
                    if(element.children[0].innerText === m.major_long_name){
                        element.classList.add('choose-card-selected')
                        for(const key in m){
                            stringElement += `<input type="hidden" name="majors[][${key}]" value="${m[key]}" readonly>`;
                        }
                    }
                });
            });
            document.getElementById('choosen-majors').innerHTML = stringElement;
        },
    };
    const phase = {
        data : @json($phases),
        selected : @json($candidate->registrationPhase),
        idElement : 'phase-card',
        changeSelected : (element) => {
            const name = element.children[0].innerText;
            const currentSelected = phase.data.find(p => p.name == name);
            if(!currentSelected) return;
            phase.selected = {
                ...phase.selected,
                ...currentSelected
            }
            phase.renderSelected();
        },
        renderSelected : () => {
            const elements =  document.querySelectorAll(`#${phase.idElement}`);
            let stringElement = '';
            elements.forEach(e => e.classList.remove('phase-card-selected'));
            elements.forEach(element => {
                if(phase.selected['name'] == element.children[0].innerText){
                    element.classList.add('phase-card-selected')
                    for(const key in phase.selected){
                        stringElement += `<input type="hidden" name="phase[][${key}]" value="${phase.selected[key]}" readonly>`;
                    }
               }
            });
            document.getElementById('choosen-phase').innerHTML = stringElement;
        },
    };
    const sections = {
        sections : [ 'self', 'guard', 'document', 'transaction' ],
        currentSection : 'self'
    };

    function handlerSections(){
        clearSections();
        handlerSelectSection(document.getElementById(`selection-${sections.currentSection}`));
        Array.from(document.getElementById('selection').children).forEach(menu => {
            if(menu.id == `selection-${sections.currentSection}-self`) handlerSelectSection(menu);
            menu.addEventListener('click', () => {
                sections.currentSection = menu.id.split('-')[1];
                clearSections();
                handlerSelectSection(menu);
            });
        });
    }
    
    function clearSections(){
        Array.from(document.getElementById('selection').children).forEach(menu => menu.classList.remove('menu-selected'));
        sections.sections.forEach(section => {
            const form = document.getElementById(`candidate-${section}-form`);
            form.style.display='none';
            form.querySelectorAll('select').forEach(e => e.required = false);
            form.querySelectorAll('textarea').forEach(e => e.required = false);
            form.querySelectorAll('input').forEach(e => e.required = false);
        });
    }

    function handlerSelectSection(element){
        const form = document.getElementById(`candidate-${sections.currentSection}-form`);
        form.style.display ='flex';
        form.querySelectorAll('select').forEach(e => e.required = true);
        form.querySelectorAll('textarea').forEach(e => e.required = true);
        form.querySelectorAll('input').forEach(e => e.required = true);
        element.classList.add('menu-selected');
    }

    function handlerSelectionMajor(selection){
        selection.renderSelected();
        const elements = document.querySelectorAll(`#${selection.idElement}`);
        elements.forEach(element => {
            element.addEventListener('click', (e) => {
                const currentSelection = selection.data.find(m => m.long_name === element.children[0].textContent);
                if(currentSelection && element.classList.contains('choose-card-selected') && selection.selected.length > 1) return selection.removeSelected(currentSelection, element);
                if(currentSelection) return selection.changeSelected(currentSelection);
            });
        });
    }

    function handlerSelectionPhase(selection){
        selection.renderSelected();
        const elements = document.querySelectorAll(`#${selection.idElement}`);
        elements.forEach(element => {
            element.addEventListener('click', () => selection.changeSelected(element));
        });
    }

    handlerSelectionMajor(major);
    handlerSelectionPhase(phase);
    handlerSections();

</script>

@include('_components._footerAdmin')