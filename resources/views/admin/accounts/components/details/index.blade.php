<div class="selection" id="selection">
    <a href="#candidate-self-form" class="menu menu-selected" id="selection-self">
        <span>Data Pribadi</span>
    </a>
    <a href="#candidate-guard-form" class="menu" id="selection-guard">
        <span>Data Orang Tua</span>
    </a>
    <a href="#candidate-document-form" class="menu" id="selection-document">
        <span>Dokumen Pendukung</span>
    </a>
    <a href="#candidate-transaction-form" class="menu" id="selection-transaction">
        <span>Data Transaksi</span>
    </a>
</div>

@include('admin.accounts.components.details.self')
@include('admin.accounts.components.details.guard')
@include('admin.accounts.components.details.document')
@include('admin.accounts.components.details.transaction')
@foreach ($candidate->transactions ?? [] as $transaction)
    @if ($transaction->status == 'settlement' || $transaction->status == 'success')
        @include('admin.accounts.components.details.result')
        @break
    @endif
@endforeach

<script defer>
    const major = {
        data : @json($majors),
        selected : @json($candidate->candidateMajors ?? []),
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
        selected : @json($candidate->registrationPhase ?? []),
        idElement : 'phase-card',
        changeSelected : (element) => {
            const name = element.children[0].innerText;
            const currentSelected = phase.data.find(p => p.name == name);
            if(!currentSelected) return;
            if(currentSelected.quota < 1) return;
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
    // handlerSections();

</script>