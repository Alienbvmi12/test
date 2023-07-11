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
        order: [
            [0, 'desc']
        ],
        columns: [{
                data: 'id_barang',
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
                render: function(data, type, row) {
                    if (data == null || data == '') {
                        return "-";
                    } else {
                        return data
                    }
                },
                title: 'Kategori'
            },
            {
                data: 'satuan',
                render: function(data, type, row) {
                    if (data == null || data == '') {
                        return "-";
                    } else {
                        return data
                    }
                },
                title: 'Satuan'
            },
            {
                data: 'stok',
                render: function(data, type, row) {
                    if (data == null || data == '') {
                        return 0;
                    } else {
                        return data
                    }
                },
                title: 'Stok'
            },
            {
                data: 'harga_jual_satuan',
                render: function(data, type, row) {
                    return parseInt(data).toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                },
                title: 'Harga Jual Per Satuan'
            },
            {
                data: 'supplier',
                render: function(data, type, row) {
                    if (data == null || data == '') {
                        return "-";
                    } else {
                        return data
                    }
                },
                title: 'Supplier'
            },
            {
                defaultContent: `
                    <button class="btn btn-primary btn-sm mb-1" onclick="userDetail(this)">Detail</button>
                    <button class="btn btn-warning btn-sm mb-1" onclick="modal(this, 'edit')" data-bs-toggle="modal" data-bs-target="#editm">Edit</button>
                    <button class="btn btn-danger btn-sm mb-1" onclick="deleteUser(this)">Hapus</button>
                `,
                title: 'Action'
            }
        ],
        rowCallback: function(row, data) {

        },
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
                harga_jual_satuan: $('#harga_jual_satuan').val(),
                id_supplier: $('#supplier').val()
            }),
            contentType: 'application/json',
            success: function(response) {
                if (response.type) {
                    toastr.success("<b>Berhasil</b> tambah data!!");
                } else {
                    toastr.error("<b>Galat : </b>" + response.message);
                }
                readUser();
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                toastr.error("<b>An error occured: </b>" + error);
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
                    harga_jual_satuan: $('#harga_jual_satuan').val(),
                    id_supplier: $('#supplier').val()
                }),
                contentType: 'application/json',
                success: function(response) {
                    if (response.type) {
                        toastr.success("<b>Berhasil</b> edit data!!");
                    } else {
                        toastr.error("<b>Galat : </b>" + response.message);
                    }
                    readUser();
                },
                error: function(xhr, status, error) {
                    toastr.error("<b>An error occured: </b>" + error);
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
                    toastr.success("<b>Berhasil</b> hapus data!!");
                    readUser();
                },
                error: function(xhr, status, error) {
                    toastr.error("<b>An error occured: </b>" + error);
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
        $('#kategori-select').html('Pilih kategori');
        $('#satuan-select').html('Pilih satuan');
        $('#harga_jual_satuan').val('');
        $('#supplier').val('');
        $('#supplier-select').html('Pilih supplier');

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
                    $('#kategori-select').html(getHtml(document.getElementById("kategori-select"), response.id_kategori));
                    $('#satuan').val(response.id_satuan);
                    $('#satuan-select').html(getHtml(document.getElementById("satuan-select"), response.id_satuan));
                    $('#harga_jual_satuan').val(response.harga_jual_satuan);
                    $('#supplier').val(response.id_supplier);
                    $('#supplier-select').html(getHtml(document.getElementById("supplier-select"), response.id_supplier));
                },
                error: function(xhr, status, error) {
                    toastr.error("<b>An error occured: </b>" + error);
                }
            });
        }
    }

    function modalStok(context) {
        const row = context.parentNode.parentNode.childNodes;
        document.getElementById("submit2").setAttribute("onclick", "stock(" + row[0].innerHTML + ")");
        $("#kadaluarsa").val(row[7].innerHTML);
    }

    function getHtml(context, value) { //Untuk mengambil nama item dropdown berdasarkan id data
        const list = context.parentNode.childNodes[3];
        for (var i = 2; i < list.childNodes.length; i++) {
            if (list.childNodes[i].nodeName !== "#text") {
                console.log(value);
                if (parseInt(list.childNodes[i].childNodes[0].getAttribute("data-select")) == parseInt(value)) {
                    console.log(value);
                    return list.childNodes[i].childNodes[0].innerHTML;
                }
            }
        }
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

    function filterFunction(context) {
        var input, filter, ul, li, a, i;
        input = context;
        filter = input.value.toUpperCase();
        div = context.parentNode.parentNode.parentNode;
        li = div.getElementsByTagName("li");
        a = li;
        for (i = 0; i < a.length; i++) {
            txtValue = li[i].childNodes[0].innerText || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
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