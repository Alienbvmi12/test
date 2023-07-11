<script>
    let deleteList = [];
    const requestUrl = '<?= base_url() ?>/gudang/stok/getStokByBarang/' + $('#barang').val();
    const requestDeleteUrl = '<?= base_url() ?>/gudang/stok/delete';
    const logTable = $('#table_log').DataTable({
        serverSide: true,
        dom: 'B<"mt-2"l>frti<"d-flex justify-content-end actions mb-2">p',
        ajax: {
            url: requestUrl,
            dataSrc: 'data'
        },
        order: [
            [0, 'desc']
        ],
        columns: [{
                data: 'id',
                title: 'ID'
            },
            {
                data: 'barang',
                title: 'Barang'
            },
            {
                data: 'stok',
                title: 'Stok'
            },
            {
                data: 'harga_beli',
                render: function(data, type, row) {
                    return parseInt(data).toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                },
                title: 'Harga Beli Per Unit'
            },
            {
                data: 'status',
                render: function(data, type, row) {
                    if(data == 0){
                        return "Stok Kosong"
                    }
                    else if(data == 1){
                        return "<i class=\"bg-success text-white p-1\">Di Gudang</i>"
                    }
                    else if(data == 2){
                        return "<i class=\"bg-danger text-white p-1\">Di Display</i>"
                    }
                },
                title: 'Status'
            },
            {
                data: 'expired_date',
                title: 'Kadaluarsa'
            },
            {
                data: 'created_at',
                title: 'Ditambahkan pada'
            }
        ],
        buttons: [{
                extend: 'print',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude last column from print
                }
            },
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude last column from print
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude last column from print
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude last column from print
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude last column from print
                }
            }
        ]
    });

    //Menambahkan list id untuk di delete

    function addToDeleteList(context) {
        let id = context.parentNode.parentNode.childNodes[0].innerHTML;
        console.log(id);
        if (context.checked) {
            deleteList.push(id)
        } else {
            for (i = 0; i < deleteList.length; i++) {
                if (deleteList[i] == id) {
                    deleteList.splice(i, 1);
                }
            }
        }
        console.log(deleteList);
    }

    //Request delete ke server

    function deleteLogList(type) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You can't revert this",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: requestDeleteUrl,
                    type: 'DELETE',
                    dataType: 'json',
                    data: JSON.stringify({
                        data: deleteList,
                        type: type,
                        id_barang: $('#barang').val()
                    }),
                    contentType: 'application/json',
                    success: function(response) {
                        reloadTable();
                    },
                    error: function(xhr, status, error) {
                        swalWithBootstrapButtons.fire(
                            'Error',
                            'An error occured: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    }

    function reloadTable() {
        const newUrl = '<?= base_url() ?>/gudang/stok/getStokByBarang/' + $('#barang').val();
        deleteList = [];
        console.log(logTable.ajax);
        logTable.ajax.url(newUrl);
        logTable.ajax.reload(null, false);
    }

    document.getElementById('barang').addEventListener('change', reloadTable);
</script>