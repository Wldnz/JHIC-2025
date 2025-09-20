

<div class="alert-message" id="delete-message" style='display:flex'>
   @if(isset($cooldown) && $cooldown)
     <div class="card-message delete-message">
        <h4>{{ $title?? 'data yang dihapus, tidak dapat dikembalikan lagi!' }}</h4>
        @include('_components._sprite-icons', ['name' => 'product', 'color' => 'red', 'size' => 50])
        <span>{{ $description }}</span>
        <div class="wrapper-button">
            <button class="btn-delete-anouncement cooldown">10 Detik</button>
            <button class="btn-close-anouncement">Tutup Pemberitahuan</button>
        </div>
    </div>
    @else
        <div class="card-message delete-message">
        <h4>{{ $title?? 'data yang dihapus, tidak dapat dikembalikan lagi!' }}</h4>
        @include('_components._sprite-icons', ['name' => 'product', 'color' => 'red', 'size' => 50])
        <span>{{ $description }}</span>
        <div class="wrapper-button">
            <button class="btn-delete-anouncement">{{ $action_name ?? "Hapus Data" }}</button>
            <button class="btn-close-anouncement">Tutup Pemberitahuan</button>
        </div>
    </div>
   @endif
</div>

<script defer>
    const wrapper_button = document.querySelector('.wrapper-button');

    function cooldown(cooldown = 10){
        wrapper_button.children[0].classList.add('cooldown');
        const intervalId = setInterval(() => {
            wrapper_button.children[0].textContent = cooldown + " Detik";
            cooldown--;
        } ,1000);
        setTimeout(() => { 
            clearInterval(intervalId);
            wrapper_button.children[0].textContent = "Hapus Data";
             wrapper_button.children[0].classList.remove('cooldown');
        } ,cooldown * 1000);
    }

    // function setActionDeleteMessage(deleteHandle){
    //     Array.from(wrapper_button.children).forEach(element => {
    //         if(element.classList[0].contains('delete')){
    //             element.addEventListener('click', deleteHandle);
    //         }else if(element.classList[0].contains('close')){
    //             element.addEventListener('click', closeActionDeleteMessage);
    //         }
    //     });
    // }

    // function closeActionDeleteMessage(){
    //     document.getElementById('delete-message').style.display = "none";
    // }
    
    // function destroyctionDeleteMessage(){
    //     document.getElementById('delete-message').remove();
    // }
</script>

@if (isset($cooldown) && $cooldown)
    <script defer>
        cooldown();
    </script>
@endif