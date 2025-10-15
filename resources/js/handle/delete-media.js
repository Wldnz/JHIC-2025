document.querySelectorAll('.wrapper-card-media').forEach(element => {
    const floating = element.querySelector('.floating-action');
    element.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        floating.style.display = 'flex';
        setTimeout(() => {
            floating.style.display = 'none';
        }, 2000);
    });
});

document.querySelectorAll('.floating-action').forEach(form => {
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        if(confirm('apakah anda yakin ingin menghapus data ini')){
            form.submit();
        }
    });
});