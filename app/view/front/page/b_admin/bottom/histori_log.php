<script>
    let deleteList = [];
    const requestUrl = '<?= base_url() ?>/admin/log/getLogByDate/' + $('#date').val();
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
            if (data.aktivitas === 'massive delete') {
                $(row).addClass('table-dark');
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
        order: [[0, 'desc']],
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

    function reloadTable() {
        const newUrl = '<?= base_url() ?>/admin/log/getLogByDate/' + $('#date').val();
        deleteList = [];
        console.log(logTable.ajax);
        logTable.ajax.url(newUrl);
        logTable.ajax.reload(null, false);
    }

    document.getElementById('date').addEventListener('change', reloadTable);
</script>