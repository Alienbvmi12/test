<script>
    const requestCreateUrl = '<?= base_url() ?>/admin/supplier/create';
    const requestReadUrl = '<?= base_url() ?>/admin/supplier/read';
    const requestUpdateUrl = '<?= base_url() ?>/admin/supplier/update';
    const requestDeleteUrl = '<?= base_url() ?>/admin/supplier/delete';
    const userDetailUrl = '<?= base_url() ?>/admin/supplier/detail';
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
                data: 'nama_supplier',
                title: 'Supplier'
            },
            {
                data: 'telepon',
                title: 'No. Telepon'
            },
            {
                data: 'alamat',
                title: 'Alamat'
            },
            {
                defaultContent: `
                    <button class="btn btn-primary btn-sm" onclick="supplierDetail(this)">Detail</button>
                    <button class="btn btn-warning btn-sm" onclick="modal(this, 'edit')" data-bs-toggle="modal" data-bs-target="#editm">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteSupplier(this)">Hapus</button>
                `,
                title: 'Action'
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

    function createSupplier() {
        $.ajax({
            url: requestCreateUrl,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                nama_supplier: $('#nama_supplier').val(),
                telepon: $('#telepon').val(),
                alamat: $('#alamat').val()
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
                readSupplier();
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

    function readSupplier() {
        console.log(logTable.ajax);
        logTable.ajax.reload(null, false);
    }

    function updateSupplier() {
        confirmAndExec(function() {
            $.ajax({
                url: requestUpdateUrl,
                type: 'PUT',
                dataType: 'json',
                data: JSON.stringify({
                    id: $('#id').val(),
                    nama_supplier: $('#nama_supplier').val(),
                    telepon: $('#telepon').val(),
                    alamat: $('#alamat').val()
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
                    readSupplier();
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

    //Request delete ke server

    function deleteSupplier(context) {
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
                    readSupplier();
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
            document.getElementById("submit").setAttribute("onclick", "updateSupplier()");
        } else {
            $('#modal-title').html('Tambah User Baru');
            document.getElementById("submit").setAttribute("onclick", "createSupplier()");
        }

        //Kosongkan value

        $('#id').val('');
        $('#nama_supplier').val('');
        $('#telepon').val('');
        $('#alamat').val('');

        //Isi value

        if (type === "edit") {
            $('#id').val(row.childNodes[0].innerHTML);
            $('#nama_supplier').val(row.childNodes[1].innerHTML);
            $('#telepon').val(row.childNodes[2].innerHTML);
            $('#alamat').val(row.childNodes[3].innerHTML);
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

    function supplierDetail(ctx) {
        const id = ctx.parentNode.parentNode.childNodes[0].innerHTML;
        window.location.href = userDetailUrl + "/" + id;
    }

    document.getElementsByClassName('actions')[0].innerHTML += `
        <button class="btn btn-success text-white" onclick="modal(this, 'add')"  data-bs-toggle="modal" data-bs-target="#editm">Tambahkan Supplier</button>`
</script>