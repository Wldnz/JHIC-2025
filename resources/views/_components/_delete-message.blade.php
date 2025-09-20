<div class="alert-message" id="delete-message">

</div>

<script defer>
    const delete_message = document.getElementById('delete-message');
    let wrapper_button = ''

    function setInterface() {
        delete_message.innerHTML = `
            <div class="card-message delete-message">
                <h4>{{ $title ?? 'data yang dihapus, tidak dapat dikembalikan lagi!' }}</h4>
                @include('_components._sprite-icons', ['name' => $icon_name ?? 'trash', 'color' => 'red', 'size' => 50])
                <span>{{ $description ?? "Data yang akan dihapus tidak dapat dikembalikan, berhati - hatilah" }}</span>
                <div class="wrapper-button">
                    <button class="btn-delete-anouncement">{{ $action_name ?? "Hapus Data" }}</button>
                    <button class="btn-close-anouncement">Tutup Pemberitahuan</button>
                </div>
            </div>`;
        wrapper_button = delete_message.querySelector('.wrapper-button');
    }

    function destroyInterface() {
        closeActionDeleteMessage();
        delete_message.innerHTML = '';
    }

    function setCooldown(handle, cooldown = 10) {
        wrapper_button.children[0].classList.add('cooldown');
        const intervalId = setInterval(() => {
            wrapper_button.children[0].textContent = cooldown + " Detik";
            cooldown--;
        }, 1000);
        setTimeout(() => {
            clearInterval(intervalId);
            wrapper_button.children[0].textContent = "Hapus Data";
            wrapper_button.children[0].classList.remove('cooldown');
            wrapper_button.children[0].addEventListener('click', handle)
        }, cooldown * 1000);
    }

    function openDeleteMessage({ handle, cooldown = false }) {
        setInterface();
        if (cooldown) {
            setCooldown(handle);
        } else {
            wrapper_button.children[0].addEventListener('click', handle);
        }
        delete_message.style.display = 'flex';
        wrapper_button.children[1].addEventListener('click', destroyInterface);
    }

    function closeActionDeleteMessage() {
        delete_message.style.display = "none";
    }

    function actionWhenSuccess(title = 'Berhasil Dalam Menghapus Data') {
        delete_message.children[0].children[0].textContent = title;
        wrapper_button.children[0].remove();
    }

</script>