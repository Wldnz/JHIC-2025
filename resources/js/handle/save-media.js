function handleMedia() {
    const btn_close_media = document.getElementById('btn-close-media');
    const btn_open_media = document.getElementById('btn-open-media');
    const wrapper_save_media = document.getElementById('wrapper-save-media');
    const card_media = document.getElementById('card-save-media');
    btn_close_media.addEventListener('click', () => {
        wrapper_save_media.classList.add('close-sidebar');
        wrapper_save_media.classList.remove('open-sidebar');
        Array.from(card_media.children)
            .filter((_, index) => index != 0)
            .forEach(c => c.style.display = 'none');
        btn_close_media.style.display = 'none';
        btn_open_media.style.display = 'flex';
    });

    btn_open_media.addEventListener('click', () => {
        wrapper_save_media.classList.remove('close-sidebar');
        wrapper_save_media.classList.add('open-sidebar');
        Array.from(card_media.children)
            .filter((_, index) => index != 0)
            .forEach(c => c.style.display = 'flex');
        btn_close_media.style.display = 'flex';
        btn_open_media.style.display = 'none';
    });
}

handleMedia();