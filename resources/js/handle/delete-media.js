document.querySelectorAll('.wrapper-card-media')?.forEach(element => {
    const floating = element.querySelector('.floating-action');
    element.addEventListener('contextmenu', (e) => {
        setHiddenCardMedia();
        e.preventDefault();
        floating.style.display = 'flex';
        floating.classList.add('open-media-menu');
        setTimeout(() => {
            floating.style.display = 'none';
        },3000)
    });
});

document.querySelectorAll('.wrapper-card-media-achievement')?.forEach(element => {
    const floating = element.querySelector('.floating-action');
    element.addEventListener('contextmenu', (e) => {
        setHiddenCardMedia2();
        e.preventDefault();
        floating.style.display = 'flex';
        floating.classList.add('open-media-menu');
        setTimeout(() => {
            floating.style.display = 'none';
        },3000)
    });
});

document.querySelectorAll('.floating-action')?.
    forEach(floatinAction => {
        const form = floatinAction.children.namedItem('action-delete');
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                if(confirm('apakah anda yakin ingin menghapus data ini')){
                    form.submit();
                    setHiddenCardMedia();
                }
            }
        );
    }
);

function setHiddenCardMedia(){
    document.querySelectorAll('.wrapper-card-media').forEach(element => {
        const floating = element.querySelector('.floating-action');
        floating.style.display = 'none';
    });
}

function setHiddenCardMedia2(){
    document.querySelectorAll('.wrapper-card-media-achievement').forEach(element => {
        const floating = element.querySelector('.floating-action');
        floating.style.display = 'none';
    });
}