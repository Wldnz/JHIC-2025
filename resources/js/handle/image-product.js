const maxImages = max_images ?? 3;
function setActionToImage() {
    document.querySelectorAll('.action-product').forEach(element => {
        const id = element.parentElement.children[0].getAttribute('alt').split('-')[1];

        const btn_choose = Array.from(element.children).filter(element => element.classList.contains('btn-choose'))[0];
        const btn_delete = Array.from(element.children).filter(element => element.classList.contains('btn-delete'))[0];
        const btn_thumbnail = Array.from(element.children).filter(element => element.classList.contains('btn-pin'))[0];

        btn_choose.addEventListener('change', (e) => changeImage(id, e.target.files[0]));

        if (btn_delete) {
            btn_delete.addEventListener('click', (e) => deleteImage(id));
        }

        if (btn_thumbnail) {
            btn_thumbnail.addEventListener('click', (e) => changeThumbnailTo(id));
        }
    })
}

function changeImage(id, file) {
    if (!file) return;
    id == "default_image" ? insertImage(file) : updateImage(id, file);
}

function insertImage(file) {
    if (file == null) return;
    if (image.length < maxImages) {
        image.push({
            id: `added_image_${new Date().getTime()}`,
            url: URL.createObjectURL(file),
            file: file,
            thumbnail: false
        });
    }
    randomThumbnailGiven();
    loadImage();
}

function deleteImage(id) {
    const image_length = image.length;
    const response = {
        message: 'Data image produk gagal di hapus',
        status: false,
    };
    if (image_length == 1) {
        response.message = 'Tambahkan data untuk menghapus image produk';
        return response;
    };
    image = image.filter(value => value.id != id);
    if (image_length != image.length) {
        response.message = 'Berhasil dalam menghapus image produk';
        response.status = true;
    }
    randomThumbnailGiven();
    loadImage();
    return response;
}

function updateImage(id, file) {
    const index = image.findIndex(value => value.id == id);
    if (index < 0) return;
    image[index].file = file;
    image[index].url = URL.createObjectURL(file);
    loadImage();
}

function randomThumbnailGiven() {
    const hasThumbnail = image.find(value => value.thumbnail);
    if (hasThumbnail) return;
    image = image.map(value => {
        value.thumbnail = false;
        return value;
    });
    image[0].thumbnail = true;
}


function changeThumbnailTo(id) {
    image = image.map(value => {
        value.thumbnail = value.id == id;
        return value;
    });
    loadImage();
}

function defaultImage(required = false) {
    return `<div class="image-product">
            <img src="/icons/default-image.png" alt="image-default_image">
                <div class="action-product" >
                    <button class="btn-choose" type="button">
                        <span class="">Pilih Gambar</span>
                        <input type="file" accept="image/jpeg, image/png" multiple name="default_image" ${required ? 'required' : ''}>
                    </button>
                </div>
                <div class="identifier">
                    <span class="">➕</span>
                </div>
            </div>`;
}

function loadImage() {
    let stringImage = '';
    const columns = ['id', 'file'];
    image.forEach((value, index) => {
        stringImage += ` <div class="image-product">
                                <img src="${value.url}" alt="image-${value.id}">
                                <div class="action-product" >
                                    ${!value.thumbnail ? '<button class="btn-pin" type="button">Jadikan Sebagai Thumbnail</button>' : ''}
                                    <button class="btn-choose" type="button">
                                        <span class="">Pilih Gambar</span>
                                        <input class='input_image_produk' id='input_image-${value.id}' type="file" accept="image/jpeg, image/png" multiple name="images[${value.id}][file]" required=${value.thumbnail}>
                                        <input type="hidden" name="images[${value.id}][thumbnail]" value=${value.thumbnail ? '1' : '0'}>
                                    </button>
                                    <button class="btn-delete" type="button">Hapus Gambar</button>
                                </div>
                                <div class="identifier">
                                    ${value.thumbnail ? '<span class="">📌</span>' : `<span>${index + 1}</span>`}
                                </div>
                            </div>`;

        if (index == image.length - 1 && image.length < maxImages) stringImage += defaultImage();
    });
    if (image.length == 0) stringImage += defaultImage(true);
    document.getElementById("image-picker").innerHTML = stringImage;
    setActionToImage();
    setInputImages();
}

function setInputImages() {
    Array.from(document.querySelectorAll('.input_image_produk')).forEach(element => {
        const id = element.id.split('-')[1];
        const file_image = image.filter(v => v.id == id);
        if (file_image.length == 0) return;
        if (file_image[0].file) {
            const dt = new DataTransfer();
            dt.items.add(file_image[0].file);
            element.files = dt.files;
        } else {
            element.removeAttribute('required');
        }
    });
}

loadImage();