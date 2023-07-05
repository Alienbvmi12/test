<script>
    const requestCreateUrl = '<?= base_url() ?>/admin/user/create';
    const requestReadUrl = '<?= base_url() ?>/admin/user/read';
    const requestUpdateUrl = '<?= base_url() ?>/admin/user/update';
    const requestDeleteUrl = '<?= base_url() ?>/admin/user/delete';
    const userDetailUrl = '<?= base_url() ?>/admin/user/detail';
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
                data: 'tipe_user',
                title: 'Role'
            },
            {
                data: 'nama',
                title: 'Nama'
            },
            {
                data: 'username',
                title: 'Username'
            },
            {
                data: 'email',
                title: 'Email'
            },
            {
                data: 'telepon',
                title: 'Telepon'
            },
            {
                defaultContent: `
                    <button class="btn btn-primary btn-sm" onclick="userDetail(this)">Detail</button>
                    <button class="btn btn-warning btn-sm" onclick="modal(this, 'edit')" data-bs-toggle="modal" data-bs-target="#editm">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser(this)">Hapus</button>
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

    function createUser() {
        $.ajax({
            url: requestCreateUrl,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                tipe_user: $('#tipe_user').val(),
                nama: $('#nama').val(),
                email: $('#email').val(),
                telepon: $('#telepon').val(),
                username: $('#username').val(),
                password: $('#password').val()
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

    function readUser() {
        console.log(logTable.ajax);
        logTable.ajax.reload(null, false);
    }

    function updateUser() {
        confirmAndExec(function() {
            $.ajax({
                url: requestUpdateUrl,
                type: 'UPDATE',
                dataType: 'json',
                data: JSON.stringify({
                    id: $('#id').val(),
                    tipe_user: $('#tipe_user').val(),
                    nama: $('#nama').val(),
                    email: $('#email').val(),
                    telepon: $('#telepon').val(),
                    username: $('#username').val(),
                    password: $('#password').val()
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
            document.getElementById("password").setAttribute("placeholder", "Isi untuk ganti password");
        } else {
            $('#modal-title').html('Tambah User Baru');
            document.getElementById("submit").setAttribute("onclick", "createUser()");
            document.getElementById("password").setAttribute("placeholder", "Masukan Password");
        }

        //Kosongkan value

        $('#id').val('');
        $('#tipe_user').val('');
        $('#nama').val('');
        $('#email').val('');
        $('#telepon').val('');
        $('#username').val('');
        $('#password').val('');

        //Isi value

        if (type === "edit") {
            $('#id').val(row.childNodes[0].innerHTML);
            $('#tipe_user').val(row.childNodes[1].innerHTML);
            $('#nama').val(row.childNodes[2].innerHTML);
            $('#username').val(row.childNodes[3].innerHTML);
            $('#email').val(row.childNodes[4].innerHTML);
            $('#telepon').val(row.childNodes[5].innerHTML);
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

    function userDetail(ctx){
        const id = ctx.parentNode.parentNode.childNodes[0].innerHTML;
        window.location.href = userDetailUrl+"/"+id;
    }

    document.getElementsByClassName('actions')[0].innerHTML += `
        <button class="btn btn-success text-white" onclick="modal(this, 'add')"  data-bs-toggle="modal" data-bs-target="#editm">Tambahkan User</button>`
</script>