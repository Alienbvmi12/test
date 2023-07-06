<script>
    let deleteList = [];
    const requestUrl = '<?= base_url() ?>/admin/log/getLogByDate/' + $('#date').val();
    const requestDeleteUrl = '<?= base_url() ?>/admin/log/delete';
    const logTable = $('#table_log').DataTable({
        serverSide : true,
        dom: 'B<"mt-2"l>frti<"d-flex justify-content-end actions mb-2">p',
        ajax: {
            url: requestUrl,
            dataSrc: 'data'
        },
        rowCallback: function(row, data) {
            if (data.aktivitas === 'delete') {
                $(row).addClass('table-danger');
            }
            if (data.aktivitas === 'update') {
                $(row).addClass('table-warning');
            }
            if (data.aktivitas === 'create') {
                $(row).addClass('table-success');
            }
            if (data.aktivitas === 'put') {
                $(row).addClass('table-info');
            }
            if (data.aktivitas === 'logout') {
                $(row).addClass('table-primary');
            }
        },
        columns: [{
                data: 'id',
                title: 'ID'
            },
            {
                data: 'aktivitas',
                title: 'Aktivitas'
            },
            {
                data: 'waktu',
                title: 'Waktu'
            },
            {
                data: 'nama',
                title: 'User'
            },
            {
                data: 'detail',
                title: 'Detil'
            },
            {
                defaultContent: '<input type="checkbox" class="form-check-input" onclick="addToDeleteList(this)">',
                title: 'Select'
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
                    data : JSON.stringify({
                        data : deleteList,
                        type: type,
                        date: $('#date').val()
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
        const newUrl = '<?= base_url() ?>/admin/log/getLogByDate/' + $('#date').val();
        deleteList = [];
        console.log(logTable.ajax);
        logTable.ajax.url(newUrl);
        logTable.ajax.reload(null, false);
    }

    document.getElementsByClassName('actions')[0].innerHTML += `
        <button class="btn btn-dark me-1" style="background : black" onclick="deleteLogList('all')">Hapus semua</button>
        <button class="btn btn-danger" onclick="deleteLogList('list')">Hapus</button>`;

    document.getElementById('date').addEventListener('change', reloadTable);
</script>