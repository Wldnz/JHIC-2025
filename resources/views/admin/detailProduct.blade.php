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

    @include('_components._management-table', [
        'management' => [ 'title' => 'Tambahkan Variant' ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nama',
            'type' => 'Tipe',
            'price' => 'Harga',
            'stock' => 'Stok',
            'created_at' => 'Dibuat Pada'
        ],
        'datas' => $product->variants,
        'actions' => [
            'Edit Variant' => [
                'action-name' => 'edit',
                'icon-name' => 'product',
            ],
            'Hapus Variant' => [
                'action-name' => 'delete',
                'icon-name' => 'trash',
            ]
        ],
    ]) 
</main>

<div class="alert-message">
    @include('_components._card-form', [
        'title' => 'Tambah Variant Produk',
        'name' => 'variant',
        'action_button' => 'Tambahkan Variant',
        'columns' => [
            'name_variant' => [
                'label-text' => 'Nama Variant', 
                'placeholder' => 'Masukkan nama variant product',
                'min' => 3,
                'required' => true
            ],
            'type_variant' => [
                'label-text' => 'Tipe / Size Variant',
                'placeholder' => 'Masukkan tipe / size variant product',
                'min' => 1,
                'required' => true
            ],
            'price_variant' => [
                'label-text' => 'Harga Variant',
                'placeholder' => 'Masukkan harga variant product',
                'min' => 1000,
                'type' => 'number',
                'required' => true
            ],
            'stock_variant' => [
                'label-text' => 'Stok Variant',
                'placeholder' => 'Masukkan stok variant product',
                'min' => 1,
                'type' => 'number',
                'required' => true
            ],
        ]   
    ])
    @include('_components._card-form', [
        'title' => 'Edit Variant Produk',
        'name' => 'edit-variant',
        'action' => 'update',
        'action_button' => 'Ubah Variant',
        'columns' => [
            'id_variant' => [
                'label-text' => 'ID Variant', 
                'placeholder' => 'ID Variant tidak boleh kosong',
                'min' => 1,
                'type' => 'hidden',
                'required' => true
            ],
            'name_variant' => [
                'label-text' => 'Nama Variant', 
                'placeholder' => 'Masukkan nama variant product',
                'min' => 3,
                'required' => true
            ],
            'type_variant' => [
                'label-text' => 'Tipe / Size Variant',
                'placeholder' => 'Masukkan tipe / size variant product',
                'min' => 1,
                'required' => true
            ],
            'price_variant' => [
                'label-text' => 'Harga Variant',
                'placeholder' => 'Masukkan harga variant product',
                'min' => 1000,
                'type' => 'number',
                'required' => true
            ],
            'stock_variant' => [
                'label-text' => 'Stok Variant',
                'placeholder' => 'Masukkan stok variant product',
                'min' => 1,
                'type' => 'number',
                'required' => true
            ],
        ]   
    ])
</div>

<!-- script untuk handle image -->
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

<!-- script untuk handle variant product  -->
<script defer>

    let variants = Array.from(@json($product->variants));

    function addVariant({ name, type, price, stock }){
        variants.push({
            id : new Date().getTime(),
            name,
            type,
            price,
            stock,
            created_at : new Date()
        });
    }

    function updateVariant({ id, name, type, price, stock }){
        variants = variants.map(value => {
            if(value.id == id){
                value.name = name;
                value.type = type;
                value.price = price;
                value.stock= stock;
            }
            return value;
        })
    }

    function deleteVariant(id){
        if(variants.length == 1) return;
        if(!confirm('Apakah anda yakin ingin menghapus variant ini?')) return;
        variants = variants.filter(value => value.id != id);
        loadVariant();
    }

    function getColumn(){
        let stringColumn = '<tr>';
        Array.from(document.querySelector('tbody').children[0].children).forEach(element => {
            stringColumn += `<td> ${element.textContent} </td>\n`;
        });
        stringColumn += '</tr>';
        return stringColumn;
    }

    function loadVariant(){
        let stringVariant = getColumn();
        variants.forEach((value, index) => {
            stringVariant += `<tr>
                                <td> ${value.id} </td>
                                <td> ${value.name} </td>
                                <td> ${value.type} </td>
                                <td> ${value.price} </td>
                                <td> ${value.stock} </td>
                                <td> 
                                    ${value.created_at}
                                    <div class="profile">
                                        @include('_components._sprite-icons', ['name' => 'tree-dots', 'size' => 20])
                                        <ul class="main-menu main-menu-table">
                                            <li id="edit-${value.id}">
                                                <a>
                                                    @include('_components._sprite-icons', ['name'=> 'box-edit' , 'size' => 20])
                                                    Edit Variant
                                                </a>
                                            </li>
                                            <li id="delete-${value.id}">
                                                <a>
                                                    @include('_components._sprite-icons', ['name'=> 'trash' , 'size' => 20])
                                                    Delete Variant
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>`;
        });
        document.querySelector('tbody').innerHTML = stringVariant;
        setActionVariant();
    }

    function setActionVariant(){
        [ "variant", "edit-variant" ].forEach(value => {
            document.getElementById(`card-form-${value}`).addEventListener('submit', (e) => {
                e.preventDefault();
                const action = e.target.querySelector('.btn-yes-anouncement').dataset.action; 
                switch(action){
                    case 'add':
                        addVariant({
                            name : e.target[1].value,
                            type : e.target[2].value,
                            price : e.target[3].value,
                            stock : e.target[4].value
                        });
                        break;
                    case 'update':
                        updateVariant({
                            id : e.target[1].value,
                            name : e.target[2].value,
                            type : e.target[3].value,
                            price : e.target[4].value,
                            stock : e.target[5].value
                        });
                        break;
                }
                closeFormVariant(action == 'update' ? 'edit-variant' : 'variant');
                loadVariant();
            });
        });
        // close button 
        const varianForm = [ 'variant', 'edit-variant' ];
        document.querySelectorAll('.btn-close-anouncement').forEach((value, index) => value.addEventListener('click', () => closeFormVariant(varianForm[index]) ));
        // add button
        document.querySelector('.management-table').children[0].children[1].addEventListener('click', () => openFormVariant());
        
        // edit & delete button
        document.querySelectorAll('.main-menu-table').forEach(main_menu => {
                Array.from(main_menu.children).forEach(button => {
                const action = button.id.split('-')[0];
                const id = button.id.split('-')[1];
                switch(action){
                    case "edit":
                        const variant = variants.filter(variant => variant.id == id)[0];
                        const column = [ 'id', 'name', 'type', 'price', 'stock' ];
                        
                        button.addEventListener('click', () => {
                            Array.from(document.getElementById('card-form-edit-variant').children)
                            .filter(element => element.classList.contains('wrapper-input'))
                            .forEach((wrapper,index) => {
                                wrapper.children[wrapper.children.length - 1].value = variant[column[index]]; 
                            });
                            openFormVariant('edit-variant')
                        });
                        break;
                    case "delete":
                        button.addEventListener('click', () => deleteVariant(id))
                        break;
                }
            });
        });
    }

    function openFormVariant(card_name = 'variant'){
        document.querySelector('.alert-message').style.display = "flex";
        document.getElementById(`card-form-${card_name}`).style.display = "flex";
    }
    
    function closeFormVariant(card_name = 'variant'){
        document.querySelector('.alert-message').style.display = "none";
        document.getElementById(`card-form-${card_name}`).style.display = "none";
    }

    setActionVariant();


</script>


{{-- <div class="alert-message" style='display:flex'>
    <div class="card-message delete-message">
        <h4>Apakah anda yakin ingin menghapus variant unique?</h4>
        @include('_components._sprite-icons', ['name' => 'product', 'color' => 'red', 'size' => 50])
        <span>Selamat!, Produk berhasil ditambahkan,<br>Nikmati keuntungannya</span>
        <div class="wrapper-button">
            <button class="btn-delete-anouncement cooldown">9 Detik</button>
            <button class="btn-close-anouncement">Tutup Pemberitahuan</button>
        </div>
    </div>
</div> --}}

@include('_components._delete-message', [ 'title' => 'sure want to delete this', 'description' => 'bla bla', 'cooldown' => true ])

@include('_components._footerAdmin')