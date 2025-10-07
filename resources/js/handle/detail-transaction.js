function loadData(){
        document.querySelectorAll('tr').forEach((tr, index) => {
            if(index == 0) return;
            const id = tr.children[0].textContent;
            const received_field = tr.children[5];
            const order = orders.find(o => o.id == id);
            if(!order) return;
            received_field.textContent = `${order.received_quantity} Produk`;
        });
    }

    function handleEdit(){
        const received_product =  document.getElementById('received_product');
        const received_order_id = document.getElementById('id_received_order');
        document.querySelectorAll('.main-menu-table').forEach(menu => {
            const edit_btn = menu.children[0];
            const id = edit_btn.id.split('-')[1];
            edit_btn.addEventListener('click', (e) => {
                const order = orders.find(o => o.id == id);
                if(!order) return;
                received_product.min = Number(order.received_quantity);
                received_product.max = Number(order.quantity);
                received_product.value= order.received_quantity;
                received_order_id.value = id;
                handleOpenForm();
            });
        });
    }

    function updateOrder(id, qty){
        if(!id || !qty) return;
        orders = orders.map(order => {
            if(order.id == id){
                return {
                    ...order,
                    ...{
                        received_quantity : Number(qty  )
                    }
                }
            }
        });
    }

    function handleOpenForm(){
        alert_message.style.display = 'flex';
        form_quantity.style.display = 'flex';
    }

    function handleCloseForm(){
        alert_message.style.display = 'none';
        form_quantity.style.display = 'none';
    }

    form_quantity.addEventListener('submit', (e) => {
        e.preventDefault();
        updateOrder(
            e.target[2].value,
            e.target[1].value
        )
        handleCloseForm();
        loadData();
    });

    document.querySelector('.btn-close-anouncement-received').addEventListener('click', handleCloseForm); 

    loadData();
    handleEdit();