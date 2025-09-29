@include('_components._headerAdmin', ['title' => 'Menambahkan Transaksi'])
@php
    $table_management = [
        'title' => 'Produk Yang Dibeli',
        'management' => ['title' => 'Tambahkan Produk'],
        'datas' => [],
        'columns' => [
            'id' => 'ID ORDER',
            'product' => 'Produk',
            'product_variant' => 'Variant Produk',
            'category' => 'Kategori',
            'quantity' => 'Jumlah',
            'price' => 'Total Harga'
        ],
        'column_relations' => [
            'product_variant' => 'name',
            'product' => [
                'parent' => 'product_variant',
                'name' => 'product',
                'column' => 'name'
            ],
            'category' => [
                'parent' => 'product_variant',
                'name' => 'product',
                'column' => 'category'
            ]
        ]
    ];
    logger('data', [$products, $students])
@endphp
<form class="content" method="post" enctype="application/x-www-form-urlencoded">
    @csrf
    <h2>Data Pembeli</h2>
    <div class="form-data" id="student-siswa-form">
        <div class="wrapper-field container">
            <div class="wrapper-input">
                <label for="nis">NIS</label>
                <input type="text" name="nis" id="nis" placeholder="Nis Siswa" readonly required>
            </div>
            <div class="wrapper-input">
                <label for="user_nis">Nama Pembeli<span> *</span></label>
                <select name="user_nis" id="user_nis" required>
                    <option value="">Pilih Nama Siswa</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->nis }}">{{ $student->fullname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="wrapper-input">
                <label for="email">Email Pembeli</label>
                <input type="text" name="email" id="email" placeholder="Masukkan email Pembeli" readonly required>
            </div>
            <div class="wrapper-input">
                <label for="created_at">Dibuat Pada</label>
                <input type="text" name="created_at" id="created_at" placeholder="Masukkan angka" readonly required>
            </div>
        </div>
    </div>

    <h2>Data Transaksi</h2>
    <div class="form-data" id="transaction-transaksi-form">
        <div class="wrapper-field container tree-row-grid">
            <div class="wrapper-input">
                <label for="received_email">Email Penerima <span>*</span></label>
                <input type="email" name="received_email" id="received_email" placeholder="Masukkan email penerima"
                    min="8" required>
            </div>
            <div class="wrapper-input">
                <label for="received_phone">No Telepon Penerima <span>*</span></label>
                <input type="text" inputmode="numeric" name="received_phone" id="received_phone"
                    placeholder="Masukkan email penerima" min="11" max="12" required>
            </div>
            <div class="wrapper-input">
                <label for="total_product">Total Produk</label>
                <input type="text" inputmode="numeric" name="total_product" id="total_product" placeholder="0" value="0"
                    min=0 required readonly>
            </div>
            <div class="wrapper-input">
                <label for="total_price">Total Harga</label>
                <input type="text" inputmode="numeric" name="total_price" id="total_price"
                    placeholder="Masukkan total harga" min="0" required readonly>
            </div>
            <div class="wrapper-input">
                <label for="note">Catatan</label>
                <textarea name="note" id="note" placeholder="masukakn catatan"></textarea>
            </div>
            <div class="wrapper-input">
                <label for="payment_method">Nama Pembeli</label>
                <select name="payment_method" id="payment_method">
                    <option value="gopay">Gopay</option>
                    <option value="dana">Dana</option>
                    <option value="ovo">Ovo</option>
                    <option value="virtual_bca">Virtual BCA</option>
                    <option value="virtual_mandiri">Virtual Mandiri</option>
                    <option value="virtual_bni">Virtual BNI</option>
                </select>
            </div>
        </div>
    </div>
    <div class="wrapper_order" id="wrapper_orders" style="display:none">

    </div>
    <button class="button-submit-form">
        <span>Tambahkan Transaksi</span>
        @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
    </button>
</form>

@include('_components._management-table', $table_management)

<div class="alert-message" id="form-order" style='display:none'>
    <form class="card-form" id="card-form-order" data-action='add' style='display:none'>
        @csrf
        <h4>Tambahkan Orderan</h4>
        <div class="wrapper-input">
            <label for="product_name">Nama Product</label>
            <select name="product_name" id="product_name" required>
                <option value=""></option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="wrapper-input">
            <label for="variant_name">Product Variant</label>
            <select name="variant_name" id="variant_name" required>
            </select>
        </div>
        <div class="wrapper-input">
            <label for="variant_type">Tipe / Size</label>
            <select name="variant_type" id="variant_type" required>
            </select>
        </div>
        <div class="wrapper-input">
            <label for="total_product">Jumlah Produk</label>
            <input type="numeric" name="total_product" id="total_product" min=1 value="1" required>
        </div>
        <div class="wrapper-input">
            <label for="total_price">Total Harga</label>
            <input type="text" inputmode="numeric" name="total_price" id="total_price" required readonly>
        </div>
        <input type="hidden" name='id_order' id="id-order" readonly>
        <button type="submit" class="btn-yes-anouncement btn-yes-anouncement-add" data-action="orderan">Tambahkan
            Orderan</button>
        <button type="button" class="btn-close-anouncement btn-close-anouncement-add">Tutup Pemberitahuan</button>
    </form>
</div>

<script defer>
    let orders = [];
    const products = @json($products);
    let currentProduct = [];

    const wrapper_order = document.getElementById('form-order');
    const form_order = wrapper_order.children[0];
    const select_product = form_order.querySelector('#product_name');
    const select_variant = form_order.querySelector('#variant_name');
    const variant_type = form_order.querySelector('#variant_type');
    const total_product = form_order.querySelector('#total_product');
    const total_price = form_order.querySelector('#total_price');

    const btn_add_order = document.getElementById('btn-add-management');
    const btn_submit = form_order.querySelector('.btn-yes-anouncement-add');

    function addOrder({
        product_id,
        variant_name,
        variant_type,
        quantity,
    }) {
        const product = products.find(p => p.id == product_id);
        const variant = product.variants.find(v => v.name == variant_name && v.type == variant_type);
        if (!variant || !product) {
            alert('cannot find product, fail adding transaction')
            return false;
        }
        if (handleSameOrder(product, variant, quantity)) return;
        orders.push({
            id: `added_order_${orders.length + 1}`,
            product_id: product.id,
            product_name: product.name,
            variant_id: variant.id,
            variant_name: variant.name,
            variant_type: variant.type,
            category: product.category,
            quantity,
            total_price: variant.price * quantity,
        });
        return true;
    }

    function handleSameOrder(product, variant, qty) {
        const order = orders.find(o => o.product_id == product.id && o.variant_id == variant.id && o.variant_type == variant.type);
        if (!order) return false;
        updateOrder(order.id, {
            ...order,
            ...{
                quantity: (Number(order.quantity) + Number(qty)) > variant.stock ? variant.stock : Number(order.quantity) + Number(qty)
            }
        });
        return true;
    }

    function updateOrder(id, {
        product_id,
        variant_name,
        quantity,
    }) {
        const product = products.find(p => p.id == product_id);
        const variant = product.variants.find(v => v.name == variant_name);
        if (!variant || !product) {
            alert('cannot find product, fail adding transaction')
            return false;
        }
        orders = orders.map(order => {
            if (order.id == id) {
                order = {
                    ...order, ...{
                        product_name: product.name,
                        variant_name: variant.name,
                        variant_type: variant.type,
                        category: product.category,
                        quantity: quantity,
                        total_price: variant.price * quantity
                    }
                }
            }
            return order;
        });
        return true;
    }

    function deleteOrder(id) {
        const before_length = orders.length;
        let data = {
            message: 'Tidak Bisa Menghapus Data Tunggal',
            success: false
        };
        if (before_length <= 1) {
            return data;
        }
        orders = orders.filter(order => order.id != id);
        data.success = before_length != orders.length;
        data.message = `${data.success ? 'Berhasil' : 'Gagal'} Dalam menghapus Orderan - ${id}`
        return data;
    }

    function openTheAddForm() {
        wrapper_order.style.display = 'flex';
        form_order.style.display = 'flex';
    }

    function closeTheAddForm() {
        wrapper_order.style.display = 'none';
        form_order.style.display = 'none';
        clearFormField();
    }

    function setProductVariantSelection(stringTag = '') {
        select_variant.innerHTML = stringTag;
    }

    function setProductVariantTypeSelection(stringTag = '') {
        variant_type.innerHTML = stringTag;
    }

    function setEditData(order_id) {
        if (form_order.dataset.action != 'update') return;
        const order = orders.find(o => o.id == order_id);
        const currentProduct = products.find(product => product.id == order.product_id);
        const variants = currentProduct.variants.find(v => v.id == order.variant_id && v.type == order.variant_type);
        const multipleTagOption = setMultipleOptionForSelection({
            name: currentProduct.variants,
            type: currentProduct.variants.filter(v => v.name == order.variant_name)
        });

        setSelectedSelection(product_name.children, (element) => {
            element.selected = false;
            if (element.value == currentProduct.id) element.selected = true;
        });

        setProductVariantSelection(multipleTagOption['name']);
        setProductVariantTypeSelection(multipleTagOption['type']);

        setSelectedSelection(variant_name.children, (element) => {
            element.selected = false;
            if (element.value == variants.name) element.selected = true;
        });

        setSelectedSelection(variant_type.children, (element) => {
            element.selected = false;
            if (element.value == variants.type) element.selected = true;
        });

        total_product.value = order.quantity;
        total_price.value = changeNumberToIDR(order.total_price);

        form_order.querySelector('#id-order').value = order_id;
    }

    function setSelectedSelection(targetChildren, handle) {
        Array.from(targetChildren).forEach((e) => handle(e));
    }

    function setMultipleOptionForSelection({
        name,
        type
    }) {
        let stringOption = {
            'name': '<option value=""></option>',
            'type': '<option value=""></option>'
        };
        name.forEach(variant => {
            stringOption['name'] += `<option value='${variant.name}'>${variant.name}</option>`;
        });
        type.forEach(variant => {
            stringOption['type'] += `<option value='${variant.type}'>${variant.type}</option>`;
        });
        return stringOption;
    }

    function handleSelectedProduct(e) {
        currentProduct = products.filter(product => product.id == e.target.value);
        const currentVariants = currentProduct[0]?.variants;
        let stringOption = {
            name: '<option value=""></option>',
        };
        if (currentVariants) {
            currentVariants.forEach(variant => {
                stringOption['name'] += `<option value='${variant.name}'>${variant.name}</option>`;
            });
        }
        setProductVariantSelection(stringOption['name']);
        clearAmountAndPrice();
    }

    function handleSelectedProductVariant(e) {
        const selectedVariant = currentProduct[0].variants.filter(variant => variant.name == e.target.value);
        let stringTag = '<option value=""></option>';
        if (selectedVariant) {
            selectedVariant.forEach(variant => {
                stringTag += `<option value='${variant.type}'>${variant.type}</option>`;
            });
        }
        setProductVariantTypeSelection(stringTag);
        clearAmountAndPrice();
    }

    function handleTotalProduct(e) {
        const data = getSelectedData();
        let qty = Number(e.target.value);
        if (!data.success || qty == 'NaN') {
            e.target.value = 1;
            return;
        }
        const currentVariant = currentProduct[0].variants.filter(variant => variant.name == data.variant_name && variant.type == data.variant_type);
        if (!currentVariant.length) clearAmountAndPrice();
        if (qty > currentVariant[0].stock) {
            e.target.value = currentVariant[0].stock;
            qty = Number(currentVariant[0].stock);
        }
        total_price.value = changeNumberToIDR(qty * currentVariant[0].price);
    }

    function getSelectedData() {
        const data = {
            success: true
        };
        Array.from(form_order.getElementsByTagName('select')).forEach(element => {
            if (!element.value) {
                data.success = false;
            }
            data[element.id] = element.value;
        });
        return data;
    }

    function getColumnTable() {
        const columns = @json($table_management['columns']);
        let stringTag = '<tr>';
        for (let column in columns) {
            stringTag += `<th>${columns[column]}</th>`;
        }
        stringTag += '</tr>';
        return stringTag;
    }

    function clearAmountAndPrice() {
        total_product.value = '';
        total_price.value = '';
    }

    function clearFormField() {
        Array.from(select_product.children).forEach((p, i) => i == 0 ? p.selected = true : p.selected = false);
        variant_name.innerHTML = '';
        variant_type.innerHTML = '';
        clearAmountAndPrice();
    }

    function changeNumberToIDR(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(number);
    }

    function loadOrder() {
        let stringTag = getColumnTable();
        let stringTagInput = '';
        orders.forEach((order, index) => {
            stringTag += `<tr>
                                <td> ${order.id} </td>
                                <td> ${order.product_name} </td>
                                <td> ${order.variant_name} </td>
                                <td> ${order.variant_type} </td>
                                <td> ${order.quantity} </td>
                                <td> 
                                    ${changeNumberToIDR(order.total_price)}
                                    <div class="profile">
                                        <svg id="tree-dots" width="20" height="20" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M30 51C33.3137 51 36 48.3137 36 45C36 41.6863 33.3137 39 30 39C26.6863 39 24 41.6863 24 45C24 48.3137 26.6863 51 30 51Z" fill="#273b98"></path>
                                            <path d="M30 36C33.3137 36 36 33.3137 36 30C36 26.6863 33.3137 24 30 24C26.6863 24 24 26.6863 24 30C24 33.3137 26.6863 36 30 36Z" fill="#273b98"></path>
                                            <path d="M30 21C33.3137 21 36 18.3137 36 15C36 11.6863 33.3137 9 30 9C26.6863 9 24 11.6863 24 15C24 18.3137 26.6863 21 30 21Z" fill="#273b98"></path>
                                        </svg>
                                        <ul class="main-menu main-menu-table">
                                            <li id="edit-${order.id}">
                                                <a>
                                                    <svg id="products" width="20" height="20" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M39.375 0.0585938L60 10.3711V33.3691L56.25 31.4941V14.5605L41.25 22.0605V29.6191L37.5 31.4941V22.0605L22.5 14.5605V21.2109L18.75 19.3359V10.3711L39.375 0.0585938ZM39.375 18.8086L44.5605 16.2012L30.9961 8.4375L24.8145 11.543L39.375 18.8086ZM48.6035 14.209L53.9355 11.543L39.375 4.24805L35.0098 6.44531L48.6035 14.209ZM33.75 33.3691L30 35.2441V35.2148L18.75 40.8398V54.1699L30 48.5156V52.7344L16.875 59.2969L0 50.8301V31.0254L16.875 22.5879L33.75 31.0254V33.3691ZM15 54.1699V40.8398L3.75 35.2148V48.5156L15 54.1699ZM16.875 37.5879L27.6855 32.1973L16.875 26.7773L6.06445 32.1973L16.875 37.5879ZM33.75 37.5586L46.875 30.9961L60 37.5586V52.998L46.875 59.5605L33.75 52.998V37.5586ZM45 54.4336V45.498L37.5 41.748V50.6836L45 54.4336ZM56.25 50.6836V41.748L48.75 45.498V54.4336L56.25 50.6836ZM46.875 42.2461L53.9355 38.7012L46.875 35.1855L39.8145 38.7012L46.875 42.2461Z" fill="#273b98"></path>
                                                    </svg>
                                                    Edit Variant
                                                </a>
                                            </li>
                                            <li id="delete-${order.id}">
                                                <a>
                                                    <svg id="trash" width="20" height="20" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M31.4849 58.145L31.4549 58.15L31.2774 58.2375L31.2274 58.2475L31.1924 58.2375L31.0149 58.1475C30.9883 58.1408 30.9683 58.1458 30.9549 58.1625L30.9449 58.1875L30.9024 59.2575L30.9149 59.3075L30.9399 59.34L31.1999 59.525L31.2374 59.535L31.2674 59.525L31.5274 59.34L31.5574 59.3L31.5674 59.2575L31.5249 58.19C31.5183 58.1633 31.5049 58.1483 31.4849 58.145ZM32.1449 57.8625L32.1099 57.8675L31.6499 58.1L31.6249 58.125L31.6174 58.1525L31.6624 59.2275L31.6749 59.2575L31.6949 59.2775L32.1974 59.5075C32.2291 59.5158 32.2533 59.5091 32.2699 59.4875L32.2799 59.4525L32.1949 57.9175C32.1866 57.8858 32.1699 57.8675 32.1449 57.8625ZM30.3574 57.8675C30.3464 57.8608 30.3333 57.8586 30.3207 57.8614C30.3081 57.8642 30.2971 57.8718 30.2899 57.8825L30.2749 57.9175L30.1899 59.4525C30.1916 59.4825 30.2058 59.5025 30.2324 59.5125L30.2699 59.5075L30.7724 59.275L30.7974 59.255L30.8049 59.2275L30.8499 58.1525L30.8424 58.1225L30.8174 58.0975L30.3574 57.8675Z" fill="#273b98"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5575 8.42C19.8892 7.42397 20.5261 6.55763 21.3777 5.94379C22.2294 5.32995 23.2527 4.99975 24.3025 5H35.6975C36.7473 4.99975 37.7706 5.32995 38.6223 5.94379C39.4739 6.55763 40.1108 7.42397 40.4425 8.42L41.8 12.5H50C50.663 12.5 51.2989 12.7634 51.7678 13.2322C52.2366 13.7011 52.5 14.337 52.5 15C52.5 15.663 52.2366 16.2989 51.7678 16.7678C51.2989 17.2366 50.663 17.5 50 17.5H47.5V47.5C47.5 49.4891 46.7098 51.3968 45.3033 52.8033C43.8968 54.2098 41.9891 55 40 55H20C18.0109 55 16.1032 54.2098 14.6967 52.8033C13.2902 51.3968 12.5 49.4891 12.5 47.5V17.5H10C9.33696 17.5 8.70107 17.2366 8.23223 16.7678C7.76339 16.2989 7.5 15.663 7.5 15C7.5 14.337 7.76339 13.7011 8.23223 13.2322C8.70107 12.7634 9.33696 12.5 10 12.5H18.2L19.5575 8.42ZM23.4675 12.5L24.3025 10H35.6975L36.5325 12.5H23.4675Z" fill="#273b98"></path>
                                                    </svg>
                                                    Delete Variant
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>`;
            stringTagInput += `
                <input type='hidden' name='orders[${index}][product_variant_id]' value='${order.variant_id}' readonly>
                <input type='hidden' name='orders[${index}][price]' value='${order.total_price}' readonly>
                <input type='hidden' name='orders[${index}][quantity]' value='${order.quantity}' readonly>
            `; wrapper_orders
        });
        document.querySelector('tbody').innerHTML = stringTag;
        document.getElementById('wrapper_orders').innerHTML = stringTagInput;
        loadActionTable();
        handleFormTransaction();
    }

    function handleFormTransaction() {
        const from_transaction = document.getElementById('transaction-transaksi-form');
        const transaction = {
            total_price: orders.reduce((price, order) => {
                return price + Number(order.total_price)
            }, 0),
            total_product: orders.reduce((product, order) => {
                return product + Number(order.quantity)
            }, 0)
        }
        console.log(transaction);
        from_transaction.querySelectorAll('input').forEach(element => {
            if (transaction.hasOwnProperty(element.id)) {
                if (element.id.includes('price')) {
                    element.value = changeNumberToIDR(transaction[element.id]);
                } else if (element.id.includes('product')) {
                    element.value = transaction[element.id] + ' Produk'
                }
            }
        });
    }

    function loadActionTable() {
        document.querySelectorAll('.main-menu-table').forEach(element => {
            const id = element.children[0].id.split('-')[1];
            const btn_update = element.children[0];
            const btn_delete = element.children[1];

            btn_update.addEventListener('click', (e) => {
                form_order.dataset.action = 'update';
                setEditData(id);
                openTheAddForm();
                btn_submit.textContent = 'Ubah Orderan';
            });
        });
        setActionDelete(false, {
            handleAction: handleDeleteOrder
        });
    }

    function handleDeleteOrder(id) {
        const { message, success } = deleteOrder(id);
        actionWhenSuccess(message);
        loadOrder();
    }

    form_order.addEventListener('submit', (e) => {
        e.preventDefault();
        const data = getSelectedData();
        if (!data.success) return;
        data.product_id = data.product_name;
        data.quantity = total_product.value;

        handleSubmitForm(data);
        closeTheAddForm();
        loadOrder();
        clearFormField();
    });

    function handleSubmitForm(data) {
        const action = form_order.dataset.action ?? 'add';
        if (action == 'add') {
            addOrder(data);
        } else if (action == 'update') {
            const id_order = form_order.querySelector('#id-order');
            updateOrder(id_order.value, data);
            id_order.value = '';
        }
    }

    select_product.addEventListener('change', handleSelectedProduct);

    select_variant.addEventListener('change', handleSelectedProductVariant);

    total_product.addEventListener('change', handleTotalProduct)

    form_order.querySelector('.btn-close-anouncement-add').addEventListener('click', closeTheAddForm);

    btn_add_order.addEventListener('click', (e) => {
        openTheAddForm();
        form_order.dataset.action = 'add';
        btn_submit.textContent = 'Tambahkan Orderan';
    });

    document.getElementById('user_nis').addEventListener('change', (e) => {
        const students = @json($students);
        const form_student = document.getElementById('student-siswa-form');
        form_student.querySelectorAll('input').forEach(element => {
            if (!e.target.value) {
                element.value = '';
            } else {
                const student = students.find(s => s.nis == e.target.value);
                if (student) {
                    element.value = element.id == 'created_at' ? student[element.id].split('T')[0] : student[element.id];
                }
            }
        });
    });

</script>