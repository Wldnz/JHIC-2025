function initProject() {
    image.src = defaultImage;
    loadKeywords();
}

function loadKeywords() {
    let keywordsHTML = '';
    keywords.forEach(key => {
        keywordsHTML += createKeyword(key);
    });
    if (keywords.length < 10) keywordsHTML += createKeyword({});
    document.getElementById('tags-tag').innerHTML = keywordsHTML;
    handleFunctionKeywords();
    createTagsSender();
}

function createKeyword({ name = null, id = null }) {
    return `<div class="wrapper-tag">
                <div class="tag" id="${id ?? 'default'}" contenteditable="true">${name ?? "Tambahkan Keyword"}</div>
                <button class="btn-tag" type="button">X</button>
            </div>`;
}

function createTagsSender() {
    let keywordsHTML = '';
    keywords.forEach((key, index) => {
        keywordsHTML += `<input type="hidden" name="tags[${index}]" id="tags_sender_${index}" value="${key.name}" readonly">`;
    });
    document.getElementById('tags_sender').innerHTML = keywordsHTML;
}

function handleFunctionKeywords() {
    document.querySelectorAll('.wrapper-tag').forEach(wrapper => {
        wrapper.children[0].addEventListener('input', (e) => {
            const text = e.target.textContent;
            if (!text) return handleRemoveKeyword(e.target, true);
            if (e.inputType == "insertParagraph") return handleRemoveParagraph(e.target);
            if (e.target.id == "default") handleAddKeyword(e.target);
            handleUpdateKeyword(e.target);
        });
        wrapper.children[1].addEventListener('click', (e) => {
            if (confirm('apakah anda yakin ingin menghapus tag ini?')) {
                handleRemoveKeyword(wrapper.children[0]);
            }
        });
    });
}

function handleAddKeyword(keyword) {
    if (keyword.id != "default") return;
    const id = `added_keyword_${new Date().getTime()}`;
    keywords.push({
        id,
        name: "Keyword Baru"
    });
    loadKeywords();
}

function handleUpdateKeyword(keyword) {
    keywords = keywords.map(key => {
        if (key.id == keyword.id) {
            key = {
                ...key, ...{
                    name: keyword.textContent
                }
            }
        }
        return key;
    })
}

function handleRemoveKeyword(keyword) {
    const wrapper = keyword.parentElement;
    if (wrapper.children[0].id == "default") {
        keyword.textContent = "Tidak Bisa Dihapus!";
        setTimeout(() => {
            keyword.textContent = "Tambahkan Keyword!"
        }, 2000)
        return;
    };
    wrapper.remove();
    keywords = keywords.filter(key => key.id != keyword.id);
}

function handleRemoveParagraph(element) {
    const cleantInput = element.innerText.replace('\n', '');
    element.textContent = cleantInput;
}

initProject();
thumbnail.addEventListener('change', (e) => {
    let file = e.target.files[0];
    const isUpdated = document.getElementById('isUpdated');
    if (!file && !prev_filelist) {
        thumbnail.required = true;
        return;
    };
    if (file) isUpdated.value = 1;
    if (!file && prev_filelist) {
        e.target.files = prev_filelist;
        file = prev_filelist.item(0);
        isUpdated.value = 0;
        thumbnail.required = false;
    };
    image.src = URL.createObjectURL(file);
    prev_filelist = e.target.files;
});