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
                <input type="text" name="" id="" placeholder="Masukkan nama produk" value="{{ $product->name }}" required>
            </div>
            <div class="wrapper-input">
                <label for="description">Deskripsi Produk <span>*</span></label>
                <textarea name="description" id="description" placeholder="Masukkan Deskripsi" minlength="10"
                    maxlength="1000" required>{{ $product->description }}</textarea>
            </div>
            <div class="wrapper-input">
                <label for="category">Kategori Produk <span>*</span></label>
                <select name="category" id="category">
                    <option value="uniform" {{ $product->category == "uniform" ? 'selected' : '' }}>Seragam Sekolah</option>
                    <option value="attribute" {{ $product->category == "attribute" ? 'selected' : '' }}>Attribut Sekolah</option>
                </select>
            </div>
        </div>
        <div class="wrapper-image">
           @if(isset($product->images) && count($product->images))
                @foreach($product->images as $key=>$image)
                    <div class="image-product">
                        <img src="{{ $image->url ?? asset('icons/default-image.png') }}" alt="{{ $image->url != null? 'image-' . $image->id : "default-image-product" }}">
                        <div class="action-product">
                            @if(!$image->thumbnail)
                                <button class="btn-pin" type="button">Jadikan Sebagai Thumbnail</button>
                            @endif
                            <button class="btn-choose" type="button">
                                <span class="">Pilih Gambar</span>
                                <input type="file" accept="image/jpeg, image/png" name="product_image_{{ $key }}" {{ $image->thumbnail? "required" : "" }}>
                            </button>
                            <button class="btn-delete" type="button">Hapus Gambar</button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <button class="button-submit-form">
            <span>Add Product</span>
            @include('_components._sprite-icons',['name' => 'add', 'size' => 18])
        </button>
    </form>
    <h2>Varian - Varian Produk - {{ $product->name }}</h2>
</main>

<script>
    
    function setActionToImage(){
        document.querySelectorAll('.action-product').forEach(element => {
            if(element.children[].classList.contains('btn-choose')){
                element.children[1].addEventListener('change', (e) => {
                    const file = e.target.file[0];
                    console.log(e.target)
                    if(file){
                        element.parentElement.children[0].src = URL.createObjectURL(file)
                    }
                });
            }
        })
    }

    setActionToImage();

    // function 
</script>

@include('_components._footerAdmin'):