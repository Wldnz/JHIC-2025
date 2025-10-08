    function handlerCompetitionName(){
        const competition_name = document.getElementById('_preview_competition_name');
        document.getElementById('competition_name').addEventListener('change', (e) => {
            competition_name.textContent = e.target.value;
        });
    }

    function handleClosePreview(){
        const preview_media = document.getElementById('preview-media');
        preview_media.addEventListener('click',(e) => {
           preview_media.parentElement.style.display = 'none';
           preview_media.style.display = 'none';
        });
    }

    function handleOpenPreview(){
        const preview_media = document.getElementById('preview-media');
        document.getElementById('preview-btn').addEventListener('click',(e) => {
            preview_media.parentElement.style.display = 'flex';
            preview_media.style.display = 'flex';
        });
    }
    handleClosePreview();
    handleOpenPreview();
    handlerCompetitionName();