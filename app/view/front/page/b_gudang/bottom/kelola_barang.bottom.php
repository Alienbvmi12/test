<script>
    const requestCreateUrl = '<?= base_url() ?>/gudang/barang/create';
    const requestReadUrl = '<?= base_url() ?>/gudang/barang/read';
    const requestUpdateUrl = '<?= base_url() ?>/gudang/barang/update';
    const requestDeleteUrl = '<?= base_url() ?>/gudang/barang/delete';
    const userDetailUrl = '<?= base_url() ?>/gudang/barang/detail';
    const dataForEditUrl = '<?= base_url() ?>/gudang/barang/dataForEdit';
    const tambahStokUrl = '<?= base_url() ?>/gudang/barang/addStock';
    const logTable = $('#table_log').DataTable({
        serverSide: true,
        dom: 'B<"mt-2"l>frti<"d-flex justify-content-end actions mb-2">p',
        ajax: {
            url: requestReadUrl,
            dataSrc: 'data'
        },
        columns: [{
                data: 'id',
                title: 'ID'
            },
            {
                data: 'kode_barang',
                title: 'Kode Barang'
            },
            {
                data: 'nama_barang',
                title: 'Nama Barang'
            },
            {
                data: 'kategori',
                title: 'Kategori'
            },
            {
                data: 'satuan',
                title: 'Satuan'
            },
            {
                data: 'sisa_stok',
                render: function(data, type, row) {
                    return data.jumlah_barang + "/" + data.stok;
                },
                title: 'Stok'
            },
            {
                data: 'harga_satuan',
                render: function(data, type, row) {
                    return parseInt(data).toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                },
                title: 'Harga Per Unit'
            },
            {
                data: 'expired_date',
                title: 'Tanggal Kadaluarsa'
            },
            {
                defaultContent: `
                    <button class="btn btn-primary btn-sm mb-1" onclick="userDetail(this)">Detail</button>
                    <button class="btn btn-info btn-sm mb-1" onclick="modalStok(this)" data-bs-toggle="modal" data-bs-target="#modalStok">Stok</button>
                    <button class="btn btn-warning btn-sm mb-1" onclick="modal(this, 'edit')" data-bs-toggle="modal" data-bs-target="#editm">Edit</button>
                    <button class="btn btn-danger btn-sm mb-1" onclick="deleteUser(this)">Hapus</button>
                `,
                title: 'Action'
            }
        ],
        columnDefs: [{
            targets: 1,
            createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                if (colIndex !== 0) {
                    $(cell).addClass('barcode'); // Add a CSS class to the cells except the column title
                }
            }
        }],
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

    function createUser() {
        $.ajax({
            url: requestCreateUrl,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                kode_barang: $('#kode_barang').val(),
                nama_barang: $('#nama_barang').val(),
                id_kategori: $('#kategori').val(),
                id_satuan: $('#satuan').val(),
                jumlah_barang: $('#jumlah_barang').val(),
                stok: $('#stok').val(),
                harga_satuan: $('#harga_satuan').val(),
                id_supplier: $('#supplier').val(),
                tanggal_masuk: $('#tanggal_masuk').val(),
                expired_date: $('#expired_date').val()
            }),
            contentType: 'application/json',
            success: function(response) {
                if (response.type) {
                    Swal.fire(
                        'Success',
                        'Berhasil tambah data',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        response.message,
                        'error'
                    );
                }
                readUser();
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                Swal.fire(
                    'Error',
                    'An error occured: ' + error,
                    'error'
                );
            }
        });
    }

    function readUser() {
        console.log(logTable.ajax);
        logTable.ajax.reload(null, false);
    }

    function updateUser() {
        confirmAndExec(function() {
            $.ajax({
                url: requestUpdateUrl,
                type: 'PUT',
                dataType: 'json',
                data: JSON.stringify({
                    id: $('#id').val(),
                    kode_barang: $('#kode_barang').val(),
                    nama_barang: $('#nama_barang').val(),
                    id_kategori: $('#kategori').val(),
                    id_satuan: $('#satuan').val(),
                    jumlah_barang: $('#jumlah_barang').val(),
                    stok: $('#stok').val(),
                    harga_satuan: $('#harga_satuan').val(),
                    id_supplier: $('#supplier').val(),
                    tanggal_masuk: $('#tanggal_masuk').val(),
                    expired_date: $('#expired_date').val()
                }),
                contentType: 'application/json',
                success: function(response) {
                    if (response.type) {
                        Swal.fire(
                            'Success',
                            'Berhasil edit data',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Error',
                            response.message,
                            'error'
                        );
                    }
                    readUser();
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error',
                        'An error occured: ' + xhr.error,
                        'error'
                    );
                }
            });
        });
    }

    //Request delete ke server

    function deleteUser(context) {
        let id = context.parentNode.parentNode.childNodes[0].innerHTML;
        confirmAndExec(function() {
            $.ajax({
                url: requestDeleteUrl,
                type: 'DELETE',
                dataType: 'json',
                data: JSON.stringify({
                    id: id
                }),
                contentType: 'application/json',
                success: function(response) {
                    Swal.fire(
                        'Success',
                        'Berhasil delete data',
                        'success'
                    );
                    readUser();
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error',
                        'An error occured: ' + error,
                        'error'
                    );
                }
            });
        });
    }

    function modal(context, type) {
        let row = context.parentNode.parentNode;

        if (type === "edit") {
            $('#modal-title').html('Edit');
            document.getElementById("submit").setAttribute("onclick", "updateUser()");
        } else {
            $('#modal-title').html('Tambah Barang Baru');
            document.getElementById("submit").setAttribute("onclick", "createUser()");
        }

        //Kosongkan value

        $('#id').val('');
        $('#kode_barang').val('');
        $('#nama_barang').val('');
        $('#kategori').val('');
        $('#satuan').val('');
        $('#jumlah_barang').val('');
        $('#stok').val('');
        $('#harga_satuan').val('');
        $('#supplier').val('');
        $('#tanggal_masuk').val('');
        $('#expired_date').val('');

        //Isi value

        if (type === "edit") {
            $.ajax({
                url: dataForEditUrl + "/" + row.childNodes[0].innerHTML,
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json',
                success: function(response) {
                    $('#id').val(response.id);
                    $('#kode_barang').val(response.kode_barang);
                    $('#nama_barang').val(response.nama_barang);
                    $('#kategori').val(response.id_kategori);
                    $('#satuan').val(response.id_satuan);
                    $('#jumlah_barang').val(response.jumlah_barang);
                    $('#stok').val(response.stok);
                    $('#harga_satuan').val(response.harga_satuan);
                    $('#supplier').val(response.id_supplier);
                    $('#tanggal_masuk').val(response.tanggal_masuk);
                    $('#expired_date').val(response.expired_date);
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error',
                        'An error occured: ' + error,
                        'error'
                    );
                }
            });
        }
    }

    function modalStok(context) {
        const row = context.parentNode.parentNode.childNodes;
        document.getElementById("submit2").setAttribute("onclick", "stock(" + row[0].innerHTML + ")");
        $("#kadaluarsa").val(row[7].innerHTML);
    }

    function stock(id) {
        $.ajax({
            url: tambahStokUrl,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                id: id,
                stok: $('#tambah_stok').val(),
                expired_date: $('#kadaluarsa').val()
            }),
            contentType: 'application/json',
            success: function(response) {
                readUser();
            },
            error: function(xhr, status, error) {
                Swal.fire(
                    'Error',
                    'An error occured: ' + error,
                    'error'
                );
            }
        });
    }

    function confirmAndExec(func, conBtn = 'btn btn-danger', canBtn = 'btn btn-success', txt = "You won't be able to revert this!") {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: conBtn,
                cancelButton: canBtn
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: txt,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                func();
            }
        });
    }

    function userDetail(ctx) {
        const id = ctx.parentNode.parentNode.childNodes[0].innerHTML;
        window.location.href = userDetailUrl + "/" + id;
    }

    document.getElementsByClassName('actions')[0].innerHTML += `
        <button class="btn btn-success text-white" onclick="modal(this, 'add')"  data-bs-toggle="modal" data-bs-target="#editm">Tambahkan Barang</button>`;

    const uluk = document.getElementById("uluk").childNodes;
    uluk.forEach(function(child) {
        if (child.nodeName === "#text") {

        } else {
            console.log(child);
        }
    });
</script>