@include('_components._headerAdmin', ['title' => 'Detail Product - ' . $product->name])
<main class="content">
    @php
        logger("data-detail", [$product])
    @endphp
    <h2>Merubah Data Product {{ $product->name }}</h2>
    <form class="form-data">
        <div class="wrapper-field">
            <div class="wrapper-input">
                <label for="name">Nama Produk <span>*</span></label>
                <input type="text" name="" id="" placeholder="Masukkan nama produk" value="{{ $product->name }}"
                    required>
            </div>
            <div class="wrapper-input">
                <label for="description">Deskripsi Produk <span>*</span></label>
                <textarea name="description" id="description" placeholder="Masukkan Deskripsi" minlength="10"
                    maxlength="1000" required>{{ $product->description }}</textarea>
            </div>
            <div class="wrapper-input">
                <label for="category">Kategori Produk <span>*</span></label>
                <select name="category" id="category">
                    <option value="uniform" {{ $product->category == "uniform" ? 'selected' : '' }}>Seragam Sekolah
                    </option>
                    <option value="attribute" {{ $product->category == "attribute" ? 'selected' : '' }}>Attribut Sekolah
                    </option>
                </select>
            </div>
        </div>
        <div class="wrapper-image" id="image-picker">
        </div>
        <button class="button-submit-form">
            <span>Merubah Data Produk</span>
            @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
        </button>
    </form>
    <div class="management-table">
        <div class="title">
            <h3 class=''>Variant - Variant Product</h3>
            <a href="{{ route('admin.store-product') }}" class="btn">
                <span class="">Tambah Produk</span>
                @include('_components._sprite-icons', ['name' => 'add', 'size' => 15])
            </a>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Tipe / Size</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Dibuat Pada</th>
            </tr>
            @foreach($product->variants as $variant)
                <tr>
                    <td> {{ $variant->id }} </td>
                    <td> {{ $variant->name }} </td>
                    <td> {{ $variant->type }} </td>
                    <td> {{ $variant->price }} </td>
                    <td> {{ $variant->stock }} </td>
                    <td>
                        {{ $variant->created_at }}
                        <div class="profile">
                            @include('_components._sprite-icons', ['name' => 'tree-dots', 'size' => 20])
                            <ul class="main-menu">
                                <li>
                                    <a href="{{ route('admin.detail-product', ['product' => $product->id])}}">
                                        @include('_components._sprite-icons', ['name' => 'box-edit', 'size' => 20])
                                        Edit Variant
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route("admin.products") }}">
                                        @include('_components._sprite-icons', ['name' => 'trash', 'size' => 20])
                                        Hapus Variant
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

</main>

<script defer>
    let image = Array.from(@json($product->images));
    
    function setActionToImage() {
        document.querySelectorAll('.action-product').forEach(element => {
            const id = element.parentElement.children[0].getAttribute('alt').split('-')[1];
            
            const btn_choose = Array.from(element.children).filter(element => element.classList.contains('btn-choose'))[0];
            const btn_delete = Array.from(element.children).filter(element => element.classList.contains('btn-delete'))[0];
            const btn_thumbnail = Array.from(element.children).filter(element => element.classList.contains('btn-pin'))[0];

            btn_choose.addEventListener('change', (e) => changeImage(id, e.target.files[0]));

            if (btn_delete) {
                btn_delete.addEventListener('click', (e) =>  deleteImage(id));
            }

            if (btn_thumbnail) {
                btn_thumbnail.addEventListener('click', (e) => changeThumbnailTo(id));
            }
        })
    }

    function changeImage(id, file){
        if(!file) return;
        id == "default_image" ?  insertImage(file) : updateImage(id, file);
    }

    function insertImage(file) {
        if(file == null) return;
        if (image.length < 3) {
            image.push({
                "id": new Date().getTime(),
                "url": URL.createObjectURL(file),
                "thumbnail": false,
            });
        }
        loadImage();
    }

    function deleteImage(id) {
        if (image.length == 1) return;
        if (!confirm('Apakah anda yakin ingin menghapus gambar ini?')) return;
        image = image.filter(value => value.id != id);
        randomThumbnailGiven();
        loadImage();
    }

    function updateImage(id, file) {
        const index = image.findIndex(value => value.id == id);
        console.log(index);
        if(index < 0) return;
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

    function defaultImage() {
        return `<div class="image-product">
            <img src="{{ asset('icons/default-image.png') }}" alt="image-default_image">
                <div class="action-product" >
                    <button class="btn-choose" type="button">
                        <span class="">Pilih Gambar</span>
                        <input type="file" accept="image/jpeg, image/png" name="product_image_default_image">
                    </button>
                </div>
                <div class="identifier">
                    <span class="">➕</span>
                </div>
            </div>`;
    }

    function loadImage() {
        let stringImage = '';
        image.forEach((value, index) => {
            stringImage += ` <div class="image-product">
                                <img src="${value.url}" alt="image-${value.id}">
                                <div class="action-product" >
                                    ${!value.thumbnail ? '<button class="btn-pin" type="button">Jadikan Sebagai Thumbnail</button>' : ''}
                                    <button class="btn-choose" type="button">
                                        <span class="">Pilih Gambar</span>
                                        <input type="file" accept="image/jpeg, image/png" name="product_image_${value.id}" required="${value.thumbnail}">
                                    </button>
                                    <button class="btn-delete" type="button">Hapus Gambar</button>
                                </div>
                                <div class="identifier">
                                    ${value.thumbnail ? '<span class="">📌</span>' : `<span>${index + 1}</span>`}
                                </div>
                            </div>`;
            if (index == image.length - 1 && image.length < 3) stringImage += defaultImage();
        });
        document.getElementById("image-picker").innerHTML = stringImage;
        setActionToImage();
    }

    loadImage();

</script>

@include('_components._footerAdmin'):