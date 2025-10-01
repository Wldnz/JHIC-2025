@include('_components._headerAdmin', ['title' => 'Menambahkan Produk'])
<main class="content">
    <h2>Menambahkan Data Produk</h2>
    <form action="{{ route('admin.store-product') }}" class="form-data" method="POST" id=""
        enctype="multipart/form-data">
        @csrf
        <div class="wrapper-field">
            <div class="wrapper-input">
                <label for="name">Nama Produk <span>*</span></label>
                <input type="text" name="name" id="name" placeholder="Masukkan nama produk" value="" required>
            </div>
            <div class="wrapper-input">
                <label for="description">Deskripsi Produk <span>*</span></label>
                <textarea name="description" id="description" placeholder="Masukkan Deskripsi" minlength="10"
                    maxlength="1000" required></textarea>
            </div>
            <div class="wrapper-input">
                <label for="category">Kategori Produk <span>*</span></label>
                <select name="category" id="category">
                    <option value="uniform">Seragam Sekolah
                    </option>
                    <option value="attribute">Attribut Sekolah
                    </option>
                </select>
            </div>
        </div>
        <div class="wrapper-image" id="image-picker"></div>
        <div class="wrapper_variant_product" id="wrapper_variant_product" style="display:none"></div>
        <button class="button-submit-form">
            <span>Merubah Data Produk</span>
            @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
        </button>
    </form>

    @include('_components._management-table', [
        'management' => ['title' => 'Tambahkan Variant'],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nama',
            'type' => 'Tipe',
            'price' => 'Harga',
            'stock' => 'Stok',
            'created_at' => 'Dibuat Pada'
        ],
        'datas' => [],
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

<div class="alert-message" id="form-variant">
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
@vite(['resources/js/handle/image-product.js', 'resources/js/handle/variant-product.js'])

<script defer>
    let variants = [];
    let image = [];
</script>
    

@include('_components._footerAdmin')